<?php
namespace App\Models;

use CodeIgniter\Model;

class Borrows_Model extends Model {
    protected $table      = 'borrows';

    protected $primaryKey = 'borrow_id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'user_id',
        'equipment_id',
        'quantity',
        'borrow_date',
        'status',
        
    ];

    protected bool $allowEmptyInserts = false;
}
?>