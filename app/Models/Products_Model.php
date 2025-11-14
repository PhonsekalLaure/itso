<?php
namespace App\Models;

use CodeIgniter\Model;

class Products_model extends Model {
    protected $table      = 'products';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'name',
        'image',
        'price',
        'date_added',
        'description',
        'is_deleted'
    ];

    protected bool $allowEmptyInserts = false;
}
?>