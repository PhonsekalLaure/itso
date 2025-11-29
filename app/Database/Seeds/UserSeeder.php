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
                'role' => 'Student',
                'firstname' => 'Bob',
                'lastname' => 'Johnson',
                'email' => 'bob.j@student.edu',
                'date_added' => '2025-11-21 14:00:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Student',
                'firstname' => 'Charlie',
                'lastname' => 'Brown',
                'email' => 'charlie.b@student.edu',
                'date_added' => '2025-11-21 16:30:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Associate',
                'firstname' => 'Dana',
                'lastname' => 'White',
                'email' => 'dana.w@example.edu',
                'date_added' => '2025-11-22 08:00:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Student',
                'firstname' => 'Eve',
                'lastname' => 'Adams',
                'email' => 'eve.a@student.edu',
                'date_added' => '2025-11-23 10:15:00',
                'is_deactivated' => 1, // Deactivated user
                'is_verified' => 1,
            ],
            [
                'role' => 'Student',
                'firstname' => 'Frank',
                'lastname' => 'Miller',
                'email' => 'frank.m@student.edu',
                'date_added' => '2025-11-24 11:00:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Associate',
                'firstname' => 'Grace',
                'lastname' => 'Lee',
                'email' => 'grace.l@example.edu',
                'date_added' => '2025-11-24 13:30:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Student',
                'firstname' => 'Henry',
                'lastname' => 'Clark',
                'email' => 'henry.c@student.edu',
                'date_added' => '2025-11-25 09:45:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Student',
                'firstname' => 'Isabella',
                'lastname' => 'Lopez',
                'email' => 'isabella.l@student.edu',
                'date_added' => '2025-11-25 15:20:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Associate',
                'firstname' => 'Jack',
                'lastname' => 'Wilson',
                'email' => 'jack.w@example.edu',
                'date_added' => '2025-11-26 08:10:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Student',
                'firstname' => 'Karen',
                'lastname' => 'Taylor',
                'email' => 'karen.t@student.edu',
                'date_added' => '2025-11-26 12:00:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Student',
                'firstname' => 'Liam',
                'lastname' => 'Harris',
                'email' => 'liam.h@student.edu',
                'date_added' => '2025-11-27 09:00:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Associate',
                'firstname' => 'Mia',
                'lastname' => 'Martinez',
                'email' => 'mia.m@example.edu',
                'date_added' => '2025-11-27 14:30:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Student',
                'firstname' => 'Noah',
                'lastname' => 'Davis',
                'email' => 'noah.d@student.edu',
                'date_added' => '2025-11-28 10:00:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Student',
                'firstname' => 'Olivia',
                'lastname' => 'Garcia',
                'email' => 'olivia.g@student.edu',
                'date_added' => '2025-11-28 16:00:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Associate',
                'firstname' => 'Paul',
                'lastname' => 'Walker',
                'email' => 'paul.w@example.edu',
                'date_added' => '2025-11-29 08:00:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Student',
                'firstname' => 'Quinn',
                'lastname' => 'Young',
                'email' => 'quinn.y@student.edu',
                'date_added' => '2025-11-29 11:30:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Student',
                'firstname' => 'Ryan',
                'lastname' => 'King',
                'email' => 'ryan.k@student.edu',
                'date_added' => '2025-11-29 14:00:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
            [
                'role' => 'Associate',
                'firstname' => 'Sophia',
                'lastname' => 'Hall',
                'email' => 'sophia.h@example.edu',
                'date_added' => '2025-11-29 17:00:00',
                'is_deactivated' => 0,
                'is_verified' => 1,
            ],
        ];

        $usersModel = model('Users_Model');
        $usersModel->insertBatch($users);
    }
}
