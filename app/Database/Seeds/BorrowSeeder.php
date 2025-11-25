<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BorrowSeeder extends Seeder
{
    public function run()
    {
        // Based on App\Models\Borrows_Model allowed fields
        // user_id, equipment_id, quantity, borrow_date, return_date, status
        $borrows = [
            [
                'user_id' => 2, // Bob (Student)
                'equipment_id' => 1, // Laptop
                'quantity' => 1,
                'borrow_date' => '2025-11-24 09:00:00',
                'return_date' => '2025-11-24 18:00:00',
                'status' => 'Returned',
            ],
            [
                'user_id' => 3, // Charlie (Student)
                'equipment_id' => 2, // DLP Projector
                'quantity' => 1,
                'borrow_date' => '2025-11-25 08:30:00',
                'return_date' => NULL,
                'status' => 'Borrowed', // Current Borrow
            ],
            [
                'user_id' => 1, // Alice (Associate)
                'equipment_id' => 4, // HDMI Cable
                'quantity' => 5,
                'borrow_date' => '2025-11-25 09:15:00',
                'return_date' => NULL,
                'status' => 'Borrowed', // Current Borrow
            ],
            [
                'user_id' => 4, // Dana (Associate)
                'equipment_id' => 5, // Lab Room Key
                'quantity' => 1,
                'borrow_date' => '2025-11-25 10:00:00',
                'return_date' => NULL,
                'status' => 'Borrowed', // Current Borrow
            ],
            [
                'user_id' => 2, // Bob (Student)
                'equipment_id' => 1, // Laptop
                'quantity' => 1,
                'borrow_date' => '2025-11-25 10:30:00',
                'return_date' => NULL,
                'status' => 'Borrowed', // Current Borrow
            ],
            [
                'user_id' => 3, // Charlie (Student)
                'equipment_id' => 1, // Laptop
                'quantity' => 2,
                'borrow_date' => '2025-11-25 11:00:00',
                'return_date' => NULL,
                'status' => 'Borrowed', // Current Borrow
            ],
        ];

        $borrowsModel = model('Borrows_Model');
        $borrowsModel->insertBatch($borrows);
    }
}
