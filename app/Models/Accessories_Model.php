<?php
namespace App\Models;

use CodeIgniter\Model;

class Accessories_Model extends Model {
    protected $table      = 'accessories';

    protected $primaryKey = 'accessory_id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'equipment_id',
        'name',
        'total_count',
        'available_count',
        
    ];

    protected bool $allowEmptyInserts = false;
}
?>