<?php
namespace App\Models;

use CodeIgniter\Model;

class Users_model extends Model {
    protected $table      = 'users';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'role',
        'username',
        'password',
        'fullname',
        'email',
        'date_created',
        'is_deleted'
    ];

    protected bool $allowEmptyInserts = false;
}
?>