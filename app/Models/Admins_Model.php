<?php
namespace App\Models;

use CodeIgniter\Model;

class Admins_Model extends Model {
    protected $table      = 'admins';

    protected $primaryKey = 'admin_id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'role',
        'username',
        'password',
        'firstname',
        'lastname',
        'email',
        'date_created',
        'is_deactivated',
    ];

    protected bool $allowEmptyInserts = false;
}
?>