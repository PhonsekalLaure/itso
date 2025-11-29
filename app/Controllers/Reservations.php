<?php
namespace App\Controllers;

use App\Models\Users_Model;
use App\Models\Equipments_Model;
use App\Models\Reservations_Model;
use App\Models\Borrows_Model;

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
        $equipmentModel = new Equipments_Model();

        $userId = $this->request->getPost('user_id');
        $equipmentId = $this->request->getPost('equipment_id');
        $quantity = $this->request->getPost('quantity');
        $reservationDate = $this->request->getPost('reservation_date');
        $pickupDate = $this->request->getPost('pickup_date');

        // Validate that equipment has enough available quantity
        $equipment = $equipmentModel->find($equipmentId);
        if (!$equipment || $equipment['available_count'] < $quantity) {
            return redirect()->back()->with('error', 'Not enough available equipment to reserve.');
        }

        // Create reservation record
        $data = [
            'user_id' => $userId,
            'equipment_id' => $equipmentId,
            'quantity' => $quantity,
            'reservation_date' => $reservationDate,
            'pickup_date' => $pickupDate,
            'status' => 'pending',
        ];

        $reservationModel->insert($data);

        // Subtract reserved quantity from available count
        $newAvailableCount = $equipment['available_count'] - $quantity;
        $equipmentModel->update($equipmentId, ['available_count' => $newAvailableCount]);

        return redirect()->to(base_url('reservations'))->with('success', 'Reservation created successfully');
    }




    public function delete($id) {
        $reservationModel = new Reservations_Model();
        $equipmentModel = new Equipments_Model();

        // Get reservation to find equipment and quantity
        $reservation = $reservationModel->find($id);
        if (!$reservation) {
            return redirect()->to(base_url('reservations'))->with('error', 'Reservation not found.');
        }

        // Only allow delete if reservation is pending (not approved/picked up)
        if ($reservation['status'] !== 'pending') {
            return redirect()->back()->with('error', 'Cannot delete non-pending reservations.');
        }

        // Restore the available count when canceling
        $equipment = $equipmentModel->find($reservation['equipment_id']);
        $newAvailableCount = $equipment['available_count'] + $reservation['quantity'];
        $equipmentModel->update($reservation['equipment_id'], ['available_count' => $newAvailableCount]);

        // Delete the reservation
        $reservationModel->update($id, ['is_deleted' => 1]);
        return redirect()->to(base_url('reservations'))->with('success', 'Reservation deleted and inventory restored');
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
    $reservation = $reservationModel->find($id);

    if (!$reservation) {
        return redirect()->to(base_url('reservations'))->with('error', 'Reservation not found.');
    }

    // Update status to "Ready for Pickup"
    $reservationModel->update($id, ['status' => 'Ready for Pickup']);

    return redirect()->to(base_url('reservations/view/' . $id))
                     ->with('success', 'Reservation approved successfully');
}

public function cancel($id) {
    $reservationModel = new Reservations_Model();
    $equipmentModel = new Equipments_Model();

    $reservation = $reservationModel->find($id);
    if (!$reservation) {
        return redirect()->to(base_url('reservations'))->with('error', 'Reservation not found.');
    }

    // Only allow cancel if not already picked up
    if ($reservation['status'] === 'Finished') {
        return redirect()->back()->with('error', 'Cannot cancel a completed reservation.');
    }

    // Restore the available count when canceling
    $equipment = $equipmentModel->find($reservation['equipment_id']);
    $newAvailableCount = $equipment['available_count'] + $reservation['quantity'];
    $equipmentModel->update($reservation['equipment_id'], ['available_count' => $newAvailableCount]);

    // Update status to "Canceled"
    $reservationModel->update($id, ['status' => 'Canceled']);

    return redirect()->to(base_url('reservations/view/' . $id))
                     ->with('success', 'Reservation cancelled successfully and inventory restored');
}

public function pickup($id) {
    $reservationModel = new Reservations_Model();
    $borrowsModel = new Borrows_Model();

    $reservation = $reservationModel->find($id);
    if (!$reservation) {
        return redirect()->to(base_url('reservations'))->with('error', 'Reservation not found.');
    }

    // Check if reservation is ready for pickup
    if ($reservation['status'] !== 'Ready for Pickup') {
        return redirect()->back()->with('error', 'Reservation must be approved before pickup.');
    }

    // Create a borrow record when equipment is picked up
    $borrowData = [
        'user_id' => $reservation['user_id'],
        'equipment_id' => $reservation['equipment_id'],
        'quantity' => $reservation['quantity'],
        'borrow_date' => date('Y-m-d H:i:s'),
        'return_date' => null, // To be set when returned
        'status' => 'borrowed',
        'is_deleted' => 0,
    ];

    $borrowsModel->insert($borrowData);

    // Update reservation status to "Finished"
    $reservationModel->update($id, ['status' => 'Finished']);

    return redirect()->to(base_url('reservations/view/' . $id))
                     ->with('success', 'Equipment picked up successfully and borrow record created');
}



}
