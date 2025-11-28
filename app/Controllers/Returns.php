<?php
namespace App\Controllers;

class Returns extends BaseController {
    public function index() {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }
        $borrowsModel = model('Borrows_Model');


        // Active borrows: those not yet returned
        $active_borrows = $borrowsModel
            ->select('borrows.*, users.firstname AS borrower_firstname, users.lastname AS borrower_lastname, equipments.name AS equipment_name')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('equipments', 'equipments.equipment_id = borrows.equipment_id')
            ->where('borrows.is_deleted', 0)
            ->where('users.is_deactivated', 0)
            ->where('borrows.status !=', 'returned')
            ->orderBy('borrow_date', 'DESC')
            ->findAll();

        // Returns logs: borrows that have been marked returned
        $returns = $borrowsModel
            ->select('borrows.*, users.firstname AS borrower_firstname, users.lastname AS borrower_lastname, equipments.name AS equipment_name')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('equipments', 'equipments.equipment_id = borrows.equipment_id')
            ->where('borrows.status', 'returned')
            ->orderBy('return_date', 'DESC')
            ->findAll();

        // Normalize fields for the view
        foreach ($active_borrows as &$ab) {
            $first = $ab['borrower_firstname'] ?? ($ab['firstname'] ?? '');
            $last = $ab['borrower_lastname'] ?? ($ab['lastname'] ?? '');
            $ab['borrower_name'] = trim($first . ' ' . $last);
        }
        unset($ab);

        foreach ($returns as &$r) {
            $first = $r['borrower_firstname'] ?? ($r['firstname'] ?? '');
            $last = $r['borrower_lastname'] ?? ($r['lastname'] ?? '');
            $r['borrower_name'] = trim($first . ' ' . $last);

            // The view expects a `return_id` key; borrow primary key is `borrow_id`
            if (!isset($r['return_id']) && isset($r['borrow_id'])) {
                $r['return_id'] = $r['borrow_id'];
            }
        }
        unset($r);

        // If a borrow_id is provided via query string, pass it to the view to pre-select
        $prefillBorrowId = $this->request->getGet('borrow_id');

        $data = array(
            'title' => 'Returning Dashboard',
            'admin' => session()->get('admin'),
            'active_borrows'=> $active_borrows,
            'returns'=> $returns,
            'prefill_borrow_id' => $prefillBorrowId,
        );

        return view('include\head_view', $data)
            .view('include\nav_view')
            .view('returns\returns_dashboard', $data)
            .view('include\foot_view');
    }
}