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
                'role' => 'Associate',
                'firstname' => 'Alice',
                'lastname' => 'Smith',
                'email' => 'alice.s@example.edu',
                'date_added' => '2025-11-20 09:00:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'user_id' => 2,
                'role' => 'Student',
                'firstname' => 'Bob',
                'lastname' => 'Johnson',
                'email' => 'bob.j@student.edu',
                'date_added' => '2025-11-21 14:00:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'user_id' => 3,
                'role' => 'Student',
                'firstname' => 'Charlie',
                'lastname' => 'Brown',
                'email' => 'charlie.b@student.edu',
                'date_added' => '2025-11-21 16:30:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'user_id' => 4,
                'role' => 'Associate',
                'firstname' => 'Dana',
                'lastname' => 'White',
                'email' => 'dana.w@example.edu',
                'date_added' => '2025-11-22 08:00:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'user_id' => 5,
                'role' => 'Student',
                'firstname' => 'Eve',
                'lastname' => 'Adams',
                'email' => 'eve.a@student.edu',
                'date_added' => '2025-11-23 10:15:00',
                'is_deactivated' => 1, // Deactivated user
                'is_verified' => 1,
            ]
        ];


        $usersModel = model('Users_Model');
        $usersModel->insertBatch($users);
    }
}
