<?php
namespace App\Models;

use CodeIgniter\Model;

class Equipments_model extends Model {
    protected $table      = 'equipments';

    protected $primaryKey = 'equipment_id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'name',
        'description',
        'total_count',
        'available_count',
        'is_deactivated',
        'date_added',
        
    ];

    protected bool $allowEmptyInserts = false;
}
?>