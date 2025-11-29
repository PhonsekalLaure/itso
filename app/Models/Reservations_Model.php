<?php
namespace App\Models;

use CodeIgniter\Model;

class Reservations_Model extends Model {
    protected $table         = 'reservations';
    protected $primaryKey    = 'reservation_id';
    protected $useAutoIncrement = true;
    protected $returnType    = 'array';
    protected $allowedFields = [
        'user_id',
        'equipment_id',
        'quantity',
        'reservation_date',
        'pickup_date',
        'status',
    ];
    protected bool $allowEmptyInserts = false;

    /**
     * Fetch all reservations along with user and equipment names
     */
    public function getReservationsWithNames()
    {
        return $this->select('reservations.*, 
                              CONCAT(users.firstname, " ", users.lastname) AS reserver_name, 
                              users.email AS reserver_email,
                              equipments.name AS equipment_name,
                              equipments.description AS equipment_description')
                    ->join('users', 'users.user_id = reservations.user_id')
                    ->join('equipments', 'equipments.equipment_id = reservations.equipment_id')
                    ->orderBy('reservation_date', 'DESC')
                    ->findAll();
    }
}
