<?php
namespace App\Controllers;

class Index extends BaseController {
    public function index() {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }
        // Use models for aggregated queries
        $equipmentModel = model('Equipments_Model');
        $borrowModel = model('Borrows_Model');

        // Total equipment: sum of `total_count` from `equipments`
        $row = $equipmentModel->select('SUM(total_count) AS total')->first();
        $total_equipment = (int) ($row['total'] ?? 0);

        // Available equipment: sum of `available_count` from `equipments`
        $row = $equipmentModel->select('SUM(available_count) AS available')->first();
        $available_equipment = (int) ($row['available'] ?? 0);

        // Borrowed today: count borrows with `borrow_date` within today's range
        $today = date('Y-m-d');
        $todayStart = $today . ' 00:00:00';
        $todayEnd   = $today . ' 23:59:59';
        $borrowed_today = (int) $borrowModel
            ->where('borrow_date >=', $todayStart)
            ->where('borrow_date <=', $todayEnd)
            ->countAllResults();

        // Currently borrowed: borrows where status is not 'returned' (adjust if you use a different status value)
        $currently_borrowed = (int) $borrowModel
            ->where('status !=', 'returned')
            ->countAllResults();

        // Fetch recent activities (borrows, returns, reservations from last 7 days)
        $recent_logs = $this->getRecentActivities(7);

        $data = array(
            'title' => 'ITSO',
            'admin' => session()->get('admin'),
            'total_equipment' => $total_equipment,
            'available_equipment' => $available_equipment,
            'borrowed_today' => $borrowed_today,
            'currently_borrowed' => $currently_borrowed,
            'recent_logs' => $recent_logs,
        );

        return view('include/head_view', $data)
            .view('include/nav_view')
            .view('main_view', $data)
            .view('include/foot_view');
    }

    /**
     * Fetch recent activities (borrows, returns, reservations) from the last N days
     */
    private function getRecentActivities($days = 7) {
        $borrowModel = model('Borrows_Model');
        $usersModel = model('Users_Model');
        $equipmentModel = model('Equipments_Model');
        $reservationsModel = model('Reservations_Model');

        $cutoffDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        $activities = [];

        // Fetch recent borrows
        $borrows = $borrowModel
            ->select('borrows.borrow_id, borrows.user_id, borrows.equipment_id, borrows.quantity, borrows.borrow_date, borrows.status,
                      users.firstname, users.lastname, equipments.name as equipment_name')
            ->join('users', 'users.user_id = borrows.user_id', 'left')
            ->join('equipments', 'equipments.equipment_id = borrows.equipment_id', 'left')
            ->where('borrows.borrow_date >=', $cutoffDate)
            ->orderBy('borrows.borrow_date', 'DESC')
            ->limit(20)
            ->findAll();

        foreach ($borrows as $borrow) {
            $userName = ($borrow['firstname'] ?? 'Unknown') . ' ' . ($borrow['lastname'] ?? '');
            $activities[] = [
                'type' => 'borrow',
                'timestamp' => $borrow['borrow_date'],
                'message' => trim($userName) . ' borrowed ' . $borrow['quantity'] . 'x ' . ($borrow['equipment_name'] ?? 'Unknown Equipment'),
                'status' => $borrow['status'],
            ];
        }

        // Fetch recent reservations (approved or canceled)
        $reservations = $reservationsModel
            ->select('reservations.reservation_id, reservations.user_id, reservations.equipment_id, reservations.quantity, 
                      reservations.reservation_date, reservations.status,
                      users.firstname, users.lastname, equipments.name as equipment_name')
            ->join('users', 'users.user_id = reservations.user_id', 'left')
            ->join('equipments', 'equipments.equipment_id = reservations.equipment_id', 'left')
            ->where('reservations.reservation_date >=', $cutoffDate)
            ->whereIn('reservations.status', ['ready for pickup', 'finished', 'canceled'])
            ->orderBy('reservations.reservation_date', 'DESC')
            ->limit(20)
            ->findAll();

        foreach ($reservations as $reservation) {
            $userName = ($reservation['firstname'] ?? 'Unknown') . ' ' . ($reservation['lastname'] ?? '');
            $statusLabel = strtolower($reservation['status']) === 'finished' ? 'picked up' : strtolower($reservation['status']);
            $activities[] = [
                'type' => 'reservation',
                'timestamp' => $reservation['reservation_date'],
                'message' => trim($userName) . ' ' . $statusLabel . ' reservation for ' . $reservation['quantity'] . 'x ' . ($reservation['equipment_name'] ?? 'Unknown Equipment'),
                'status' => $reservation['status'],
            ];
        }

        // Sort by timestamp descending (most recent first)
        usort($activities, function($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });

        // Return only the 10 most recent
        return array_slice($activities, 0, 10);
    }
}
?>