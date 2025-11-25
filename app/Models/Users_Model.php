<?php
namespace App\Models;

use CodeIgniter\Model;

class Users_Model extends Model {
    protected $table      = 'users';

    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'role',
        'firstname',
        'lastname',
        'email',
        'date_added',
        'is_deactivated',
        'is_verified',
        'token',
    ];

    protected bool $allowEmptyInserts = false;
}
?>