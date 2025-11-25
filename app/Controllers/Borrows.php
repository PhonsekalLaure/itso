<?php
namespace App\Controllers;

class Borrows extends BaseController {
    public function index() {
        if (!session()->get('user')) {
            return redirect()->to(base_url('auth/login'));
        }
        $usersModel = model('Users_Model');
        $equipmentsModel = model('Equipments_Model');
        $borrowsModel = model('Borrows_Model');

        // Active users for the borrower select
        $users = $usersModel->where('is_deactivated', 0)->findAll();

        // Available equipments for the equipment select
        $equipments = $equipmentsModel->where('is_deactivated', 0)->findAll();

        // Borrow logs: join borrows with users and equipments to get readable names
        $borrows = $borrowsModel
            ->select('borrows.*, users.firstname AS borrower_firstname, users.lastname AS borrower_lastname, equipments.name AS equipment_name')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('equipments', 'equipments.equipment_id = borrows.equipment_id')
            ->orderBy('borrow_date', 'DESC')
            ->findAll();

        // Normalize fields expected by the view
        foreach ($borrows as &$b) {
            $first = $b['borrower_firstname'] ?? ($b['firstname'] ?? '');
            $last = $b['borrower_lastname'] ?? ($b['lastname'] ?? '');
            $b['borrower_name'] = trim($first . ' ' . $last);
            $b['equipment_name'] = $b['equipment_name'] ?? ($b['name'] ?? '');
        }
        unset($b);

        $data = array(
            'title' => 'Users Dashboard',
            'user' => session()->get('user'),
            'users'=> $users,
            'equipments' => $equipments,
            'borrows'=> $borrows,
        );

        return view('include\head_view', $data)
            .view('include\nav_view')
            .view('borrows\borrows_dashboard', $data)
            .view('include\foot_view');
    }
}