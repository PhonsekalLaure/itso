<?php
namespace App\Controllers;

use App\Models\Users_Model;
use App\Models\Equipments_Model;
use App\Models\Reservations_Model;

class Reservations extends BaseController {

    public function index() {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }

        $userModel = new Users_Model();
        $equipmentModel = new Equipments_Model();
        $reservationModel = new Reservations_Model();

        $data = [
            'title' => 'Reservations Dashboard',
            'admin' => session()->get('admin'),
            'users' => $userModel->findAll(),
            'equipments' => $equipmentModel->findAll(),
            'reservations' => $reservationModel->getReservationsWithNames(),
        ];

        return view('include/head_view', $data)
            . view('include/nav_view')
            . view('reservations/reservations_dashboard', $data)
            . view('include/foot_view');
    }

    public function insert() {
        $reservationModel = new Reservations_Model();

        $data = [
            'user_id' => $this->request->getPost('user_id'),
            'equipment_id' => $this->request->getPost('equipment_id'),
            'quantity' => $this->request->getPost('quantity'),
            'reservation_date' => $this->request->getPost('reservation_date'),
            'pickup_date' => $this->request->getPost('pickup_date'),
            'status' => 'pending',
        ];

        $reservationModel->insert($data);
        return redirect()->to(base_url('reservations'));
    }




    public function delete($id) {
        $reservationModel = new Reservations_Model();
        $reservationModel->delete($id);
        return redirect()->to(base_url('reservations'));
    }


public function view($id = null) {
    if (!session()->get('admin')) {
        return redirect()->to(base_url('auth/login'));
    }

    $reservationModel = new Reservations_Model();

    $reservation = $reservationModel
        ->select('reservations.*, 
                  users.firstname as reserver_firstname, 
                  users.lastname as reserver_lastname, 
                  users.email as reserver_email,
                  equipments.name as equipment_name, 
                  equipments.description as equipment_description')
        ->join('users', 'users.user_id = reservations.user_id')
        ->join('equipments', 'equipments.equipment_id = reservations.equipment_id')
        ->where('reservation_id', $id)
        ->first();

    if (!$reservation) {
        return redirect()->to(base_url('reservations'))->with('error', 'Reservation not found.');
    }

    // Combine first and last name
    $reservation['reserver_name'] = $reservation['reserver_firstname'] . ' ' . $reservation['reserver_lastname'];
    $reservation['status'] = $reservation['status'] ?? 'pending'; // fallback

    $data = [
        'title' => 'Reservation Details',
        'admin' => session()->get('admin'),
        'reservation' => $reservation,
    ];

    return view('include/head_view', $data)
        . view('include/nav_view')
        . view('reservations/reservation_view', $data)
        . view('include/foot_view');
}

public function approve($id = null) {
    $reservationModel = new Reservations_Model();
    $reservationModel->update($id, ['status' => 'Ready for Pickup']); // DB enum value
    return redirect()->to(base_url('reservations/view/' . $id))
                     ->with('success', 'Reservation approved successfully');
}

public function cancel($id) {
    $reservationModel = new Reservations_Model();
    $reservationModel->update($id, ['status' => 'Canceled']); // DB enum value
    return redirect()->to(base_url('reservations/view/' . $id))
                     ->with('success', 'Reservation cancelled successfully');
}

public function pickup($id) {
    $reservationModel = new Reservations_Model();
    $reservationModel->update($id, ['status' => 'Finished']); // DB enum value
    return redirect()->to(base_url('reservations/view/' . $id))
                     ->with('success', 'Equipment marked as picked up');
}



}
