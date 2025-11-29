<?php
namespace App\Controllers;

use App\Models\Borrows_Model;
use App\Models\Equipments_Model;

class Returns extends BaseController {

    /**
     * Dashboard view (active borrows + return logs)
     */
    public function index() {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }

        $borrowsModel = new Borrows_Model();
        $perPage = 10;

        // Active borrows (not yet returned)
        $active_borrows = $borrowsModel
            ->select('borrows.*, users.firstname AS borrower_firstname, users.lastname AS borrower_lastname, equipments.name AS equipment_name')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('equipments', 'equipments.equipment_id = borrows.equipment_id')
            ->where('borrows.is_deleted', 0)
            ->where('users.is_deactivated', 0)
            ->where('borrows.status !=', 'returned')
            ->orderBy('borrow_date', 'DESC')
            ->findAll();

        // Returned borrows
        $returns = $borrowsModel
            ->select('borrows.*, users.firstname AS borrower_firstname, users.lastname AS borrower_lastname, equipments.name AS equipment_name')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('equipments', 'equipments.equipment_id = borrows.equipment_id')
            ->where('borrows.status', 'returned')
            ->orderBy('return_date', 'DESC')
            ->paginate($perPage);

        // Format borrower names
        foreach ($active_borrows as &$ab) {
            $ab['borrower_name'] = trim(($ab['borrower_firstname'] ?? '') . ' ' . ($ab['borrower_lastname'] ?? ''));
        }
        unset($ab);

        foreach ($returns as &$r) {
            $r['borrower_name'] = trim(($r['borrower_firstname'] ?? '') . ' ' . ($r['borrower_lastname'] ?? ''));
            $r['return_id'] = $r['borrow_id']; // normalize return_id
        }
        unset($r);

        $data = [
            'title' => 'Returning Dashboard',
            'admin' => session()->get('admin'),
            'active_borrows' => $active_borrows,
            'returns' => $returns,
            'pages' => $borrowsModel->pager,
            'prefill_borrow_id' => $this->request->getGet('borrow_id'),
        ];

        return view('include/head_view', $data)
             . view('include/nav_view')
             . view('returns/returns_dashboard', $data)
             . view('include/foot_view');
    }

    /**
     * View a single borrow/return record
     */
    public function view($id) {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }

        $borrowsModel = new Borrows_Model();

        $borrow = $borrowsModel
            ->select('borrows.*, users.firstname, users.lastname, users.email, equipments.name AS equipment_name, equipments.description, equipments.accessories')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('equipments', 'equipments.equipment_id = borrows.equipment_id')
            ->where('borrows.borrow_id', $id)
            ->first();

        if (!$borrow) {
            return redirect()->back()->with('error', 'Borrow record not found');
        }

        $borrow['borrower_name'] = trim($borrow['firstname'] . ' ' . $borrow['lastname']);

        $data = [
            'title' => 'Return Information',
            'borrow' => $borrow
        ];

        return view('include/head_view', $data)
             . view('include/nav_view')
             . view('returns/return_view', $data)
             . view('include/foot_view');
    }

    /**
     * Handle return insertion
     */
    public function insert() {
        $borrowId = $this->request->getPost('borrow_id');

        $borrowsModel = new Borrows_Model();
        $equipmentsModel = new Equipments_Model();

        $borrow = $borrowsModel->find($borrowId);

        if ($borrow && $borrow['status'] != 'returned') {
            $borrowsModel->update($borrowId, [
                'status' => 'returned',
                'return_date' => date('Y-m-d H:i:s'),
            ]);

            // Update equipment quantity
            $equipment = $equipmentsModel->find($borrow['equipment_id']);
            if ($equipment) {
                $newQty = ($equipment['available_count'] ?? 0) + $borrow['quantity'];
                $equipmentsModel->update($borrow['equipment_id'], [
                    'available_count' => $newQty,
                    'is_available'   => 1
                ]);
            }

            session()->setFlashdata('return_success', true);
        }

        return redirect()->to(base_url('returns'));
    }

    /**
     * Clear all returned records
     */
    public function clearAll() {
        $borrowsModel = new Borrows_Model();
        $equipmentModel = new Equipments_Model();

        $returnedBorrows = $borrowsModel->where('status', 'returned')->findAll();

        foreach ($returnedBorrows as $borrow) {
            $borrowsModel->update($borrow['borrow_id'], [
                'status' => 'borrowed',
                'return_date' => null
            ]);

            $equipment = $equipmentModel->find($borrow['equipment_id']);
            if ($equipment) {
                $newQty = ($equipment['available_count'] ?? 0) + $borrow['quantity'];
                $equipmentModel->update($borrow['equipment_id'], [
                    'available_count' => $newQty,
                    'is_available'   => 1
                ]);
            }
        }

        session()->setFlashdata('return_success', 'All return records cleared.');
        return redirect()->to(base_url('returns'));
    }
}
