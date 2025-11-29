<?php
namespace App\Models;

use CodeIgniter\Model;

class Reservations_Model extends Model {
    protected $table      = 'reservations';
    protected $primaryKey = 'reservation_id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = [
        'user_id',
        'equipment_id',
        'quantity',
        'reservation_date',
        'pickup_date',
        'status',
    ];
    protected bool $allowEmptyInserts = false;

    // Fetch reservations with user and equipment names
  public function getReservationsWithNames()
{
    return $this->select('reservations.*, 
                          CONCAT(users.firstname, " ", users.lastname) as reserver_name, 
                          equipments.name as equipment_name')
                ->join('users', 'users.user_id = reservations.user_id')
                ->join('equipments', 'equipments.equipment_id = reservations.equipment_id')
                ->findAll();
}


}
