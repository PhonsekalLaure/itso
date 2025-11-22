<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'johnpork',
                'password' => password_hash('Password1.', PASSWORD_DEFAULT),
                'firstname' => 'John',
                'lastname' => 'Pork',
                'email' => 'admin@itso.com',
                'role' => 'Admin',
            ],
            [
                'username' => 'sixseven',
                'password' => password_hash('Password1.', PASSWORD_DEFAULT),
                'firstname' => 'Six',
                'lastname' => 'Seven',
                'email' => 'sadmin@itso.com',
                'role' => 'SAdmin',
            ],
        ];

        $this->db->table('admins')->insertBatch($data);

        echo "Admins seeded successfully.\n";
    }
}
