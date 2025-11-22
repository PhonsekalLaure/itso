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
        'reservation_date',
        'pickup_date',
        'status',
        
    ];

    protected bool $allowEmptyInserts = false;
}
?>