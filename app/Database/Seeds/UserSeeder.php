<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Base seeding strictly on App\Models\Users_Model fields
        // Allowed fields: role, firstname, lastname, email, date_added, is_deactivated, is_verified
        $now = Time::now('UTC')->toDateTimeString();

        $users = [
            [
                'role'           => 'associate',
                'firstname'      => 'John',
                'lastname'       => 'Cena',
                'email'          => 'sadmin@example.com',
            ],
            [
                'role'           => 'student',
                'firstname'      => 'Bong-Bong',
                'lastname'       => 'Marcos',
                'email'          => 'admin@example.com',
            ],
            [
                'role'           => 'associate',
                'firstname'      => 'John',
                'lastname'       => 'Doe',
                'email'          => 'john.doe@example.com',
            ],
            [
                'role'           => 'student',
                'firstname'      => 'Alice',
                'lastname'       => 'Smith',
                'email'          => 'alice.smith@example.com',
            ],
        ];

        // Use the Users_Model for insertion to respect its configuration
        $usersModel = model('Users_Model');
        $usersModel->insertBatch($users);
    }
}
