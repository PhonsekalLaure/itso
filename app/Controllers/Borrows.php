<?php
namespace App\Controllers;

class Borrows extends BaseController
{
    public function index()
    {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }
        $usersModel = model('Users_Model');
        $equipmentsModel = model('Equipments_Model');
        $borrowsModel = model('Borrows_Model');
        $perPage = 10;

        // Active users for the borrower select
        $users = $usersModel->where('is_deactivated', 0)->findAll();

        // Available equipments for the equipment select
        $equipments = $equipmentsModel->where('is_deactivated', 0)->findAll();

        // Borrow logs: join borrows with users and equipments to get readable names
        $borrows = $borrowsModel
            ->select('borrows.*, users.firstname AS borrower_firstname, users.lastname AS borrower_lastname, equipments.name AS equipment_name')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('equipments', 'equipments.equipment_id = borrows.equipment_id')
            ->where('borrows.is_deleted', 0)
            ->where('users.is_deactivated', 0)
            ->orderBy('borrow_date', 'DESC')
            ->paginate($perPage);

        // Normalize fields expected by the view
        foreach ($borrows as &$b) {
            $first = $b['borrower_firstname'] ?? ($b['firstname'] ?? '');
            $last = $b['borrower_lastname'] ?? ($b['lastname'] ?? '');
            $b['borrower_name'] = trim($first . ' ' . $last);
            $b['equipment_name'] = $b['equipment_name'] ?? ($b['name'] ?? '');
        }
        unset($b);

        $data = array(
            'title' => 'Borrowing Dashboard',
            'admin' => session()->get('admin'),
            'users' => $users,
            'equipments' => $equipments,
            'borrows' => $borrows,
            'pages' => $borrowsModel->pager,
        );

        return view('include\head_view', $data)
            . view('include\nav_view')
            . view('borrows\borrows_dashboard', $data)
            . view('include\foot_view');
    }

    public function insert()
    {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }

        $borrowsModel = model('Borrows_Model');
        $equipmentsModel = model('Equipments_Model');

        $data = [
            'user_id' => $this->request->getPost('user_id'),
            'equipment_id' => $this->request->getPost('equipment_id'),
            'quantity' => $this->request->getPost('quantity'),
            'borrow_date' => $this->request->getPost('borrow_date'),
            'status' => 'borrowed',
        ];

        // Validate inputs
        if (!$data['user_id'] || !$data['equipment_id'] || !$data['quantity'] || !$data['borrow_date']) {
            return redirect()->back()->with('error', 'All fields are required');
        }

        if ($data['quantity'] <= 0) {
            return redirect()->back()->with('error', 'Quantity must be greater than 0');
        }

        // Check equipment availability
        $equipment = $equipmentsModel->find($data['equipment_id']);
        if (!$equipment) {
            return redirect()->back()->with('error', 'Equipment not found');
        }

        if ($equipment['available_count'] < $data['quantity']) {
            return redirect()->back()->with('error', 'Insufficient equipment available');
        }

        // Use transaction to ensure both operations succeed
        $db = \Config\Database::connect();
        $db->transStart();

        $borrowsModel->insert($data);
        $equipmentsModel->update($equipment['equipment_id'], [
            'available_count' => $equipment['available_count'] - $data['quantity']
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Error recording borrow');
        }

        return redirect()->to(base_url('borrows'))->with('success', 'Borrow recorded successfully');
    }

    public function view($id)
    {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }
        $borrowsModel = model('Borrows_Model');
        $usersModel = model('Users_Model');
        $equipmentsModel = model('Equipments_Model');

        // Get the borrow record with user and equipment details
        $borrow = $borrowsModel
            ->select('borrows.*, users.firstname, users.lastname, users.email, equipments.name AS equipment_name, equipments.description')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('equipments', 'equipments.equipment_id = borrows.equipment_id')
            ->where('borrows.borrow_id', $id)
            ->first();

        if (!$borrow) {
            return redirect()->back()->with('error', 'Borrow record not found');
        }

        // Format the user and equipment names
        $borrow['borrower_name'] = trim($borrow['firstname'] . ' ' . $borrow['lastname']);

        $data = [
            'title' => 'View Borrow Log',
            'borrow' => $borrow
        ];

        return view('include/head_view', $data)
            . view('include/nav_view')
            . view('borrows/view_view', $data)
            . view('include/foot_view');
    }

    public function return($id)
    {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }

        $borrowsModel = model('Borrows_Model');

        $borrow = $borrowsModel->find($id);
        if (!$borrow) {
            return redirect()->to('borrows')->with('error', 'Borrow record not found.');
        }

        // Redirect to Returns page with borrow id to prefill the return form
        return redirect()->to(base_url('returns') . '?borrow_id=' . $id);
    }

    public function delete($id)
    {
        // Only Super Administrators can delete borrow logs
        $admin = session()->get('admin');
        if (!$admin || strtolower($admin['role']) !== 'sadmin') {
            return redirect()->to('borrows')->with('error', 'Unauthorized: only Super Administrators can delete borrow logs.');
        }

        $borrowsModel = model('Borrows_Model');
        $equipmentsModel = model('Equipments_Model');

        $borrow = $borrowsModel->find($id);
        if (!$borrow) {
            return redirect()->to('borrows')->with('error', 'Borrow Log not found.');
        }

        // If already soft-deleted, nothing to do
        if (!empty($borrow['is_deleted'])) {
            return redirect()->to('borrows')->with('info', 'Borrow Log already deleted.');
        }

        // Restore equipment available_count and soft-delete the borrow record inside a transaction
        $db = \Config\Database::connect();
        $db->transStart();

        // Mark borrow as deleted
        $borrowsModel->update($id, ['is_deleted' => 1]);

        // Add the borrowed quantity back to equipment.available_count when equipment exists
        if (!empty($borrow['equipment_id']) && isset($borrow['quantity'])) {
            $equipment = $equipmentsModel->find($borrow['equipment_id']);
            if ($equipment) {
                $newAvailable = (int) $equipment['available_count'] + (int) $borrow['quantity'];
                $equipmentsModel->update($equipment['equipment_id'], ['available_count' => $newAvailable]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('borrows')->with('error', 'Error deleting borrow log.');
        }

        return redirect()->to('borrows')->with('success', 'Borrow Log deleted successfully.');
    }
}

