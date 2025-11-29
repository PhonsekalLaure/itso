<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Super Admin
            [
                'username' => 'superadmin',
                'password' => password_hash('SuperPass1.', PASSWORD_DEFAULT),
                'firstname' => 'Michael',
                'lastname' => 'Anderson',
                'email' => 'superadmin@itso.com',
                'role' => 'SAdmin',
                'token' => bin2hex(random_bytes(16))
            ],
            // Admin 1
            [
                'username' => 'admin.john',
                'password' => password_hash('Password1.', PASSWORD_DEFAULT),
                'firstname' => 'John',
                'lastname' => 'Smith',
                'email' => 'admin.john@itso.com',
                'role' => 'Admin',
                'token' => bin2hex(random_bytes(16))
            ],
            // Admin 2
            [
                'username' => 'admin.jane',
                'password' => password_hash('Password1.', PASSWORD_DEFAULT),
                'firstname' => 'Jane',
                'lastname' => 'Doe',
                'email' => 'admin.jane@itso.com',
                'role' => 'Admin',
                'token' => bin2hex(random_bytes(16))
            ],
        ];

        $this->db->table('admins')->insertBatch($data);

        echo "Super Admin and Admins seeded successfully.\n";
    }
}
