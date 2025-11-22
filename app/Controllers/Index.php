<?php
namespace App\Controllers;

class Index extends BaseController {
    public function index() {
        if (!session()->get('user')) {
            return redirect()->to(base_url('auth/login'));
        }
        // Use models for aggregated queries
        $usermodel = model('Users_model');
        $equipmentModel = model('Equipments_model');
        $borrowModel = model('Borrows_Model');


        $userId = session()->get('user')['user_id'];
        $user = $usermodel->find($userId);

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

        $data = array(
            'title' => 'ITSO',
            'user' => $user,
            'total_equipment' => $total_equipment,
            'available_equipment' => $available_equipment,
            'borrowed_today' => $borrowed_today,
            'currently_borrowed' => $currently_borrowed,
        );

        return view('include/head_view', $data)
            .view('include/nav_view')
            .view('main_view', $data)
            .view('include/foot_view');
    }
}
?>