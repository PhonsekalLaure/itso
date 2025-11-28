<?php
namespace App\Controllers;

class Returns extends BaseController {

    // Dashboard view
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

        // Normalize borrower names
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

            // Ensure return_id exists
            if (!isset($r['return_id']) && isset($r['borrow_id'])) {
                $r['return_id'] = $r['borrow_id'];
            }
        }
        unset($r);

        // Prefill borrow_id if provided in query string
        $prefillBorrowId = $this->request->getGet('borrow_id');

        $data = [
            'title' => 'Returning Dashboard',
            'admin' => session()->get('admin'),
            'active_borrows'=> $active_borrows,
            'returns'=> $returns,
            'prefill_borrow_id' => $prefillBorrowId,
        ];

        return view('include\head_view', $data)
            . view('include\nav_view')
            . view('returns\returns_dashboard', $data)
            . view('include\foot_view');
    }

    // Handle return insertion
public function insert()
{
    $borrowId = $this->request->getPost('borrow_id');

    $borrowsModel = new \App\Models\Borrows_Model();
    $equipmentsModel = new \App\Models\Equipments_Model();

    // Get borrow record
    $borrow = $borrowsModel->find($borrowId);

    if ($borrow && $borrow['status'] != 'returned') {

        // Mark borrow as returned
        $borrowsModel->update($borrowId, [
            'status' => 'returned',
            'return_date' => date('Y-m-d H:i:s'),
        ]);

        // Add returned quantity back to equipment
        $equipment = $equipmentsModel->find($borrow['equipment_id']);
        if ($equipment) {
            $newQty = ($equipment['available_count'] ?? 0) + $borrow['quantity'];
            $equipmentsModel->update($borrow['equipment_id'], [
                'available_count' => $newQty,
                'is_available'   => 1 // optional flag if you want
            ]);
        }

        // Flashdata for success modal
        session()->setFlashdata('return_success', true);
    }

    return redirect()->to(base_url('returns'));
}

public function clearAll()
{
    $borrowsModel = new \App\Models\Borrows_Model();

    // Get all returned borrows
    $returnedBorrows = $borrowsModel->where('status', 'returned')->findAll();

    foreach ($returnedBorrows as $borrow) {
        // Reset borrow status
        $borrowsModel->update($borrow['borrow_id'], [
            'status' => 'borrowed',
            'return_date' => null
        ]);

        // Update equipment quantity
        $equipmentModel = new \App\Models\Equipments_Model();
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
}


