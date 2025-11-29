<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BorrowReturnSeeder extends Seeder
{
    public function run()
    {
        // Based on App\Models\Borrows_Model allowed fields
        // user_id, equipment_id, quantity, borrow_date, return_date, status, is_deleted
        $borrows = [
            // --- Returned Logs (10) ---
            [
                'user_id' => 2, // Bob
                'equipment_id' => 1, // Laptop
                'quantity' => 1,
                'borrow_date' => '2025-11-24 09:00:00',
                'return_date' => '2025-11-24 18:00:00',
                'status' => 'Returned',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 6, // Frank
                'equipment_id' => 3, // Wacom Tablet
                'quantity' => 1,
                'borrow_date' => '2025-11-26 09:00:00',
                'return_date' => '2025-11-26 17:00:00',
                'status' => 'Returned',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 9, // Isabella
                'equipment_id' => 8, // Mechanical Keyboard
                'quantity' => 1,
                'borrow_date' => '2025-11-27 09:30:00',
                'return_date' => '2025-11-27 15:00:00',
                'status' => 'Returned',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 12, // Liam
                'equipment_id' => 11, // Router
                'quantity' => 1,
                'borrow_date' => '2025-11-28 09:00:00',
                'return_date' => '2025-11-28 18:00:00',
                'status' => 'Returned',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 14, // Noah
                'equipment_id' => 13, // Webcam
                'quantity' => 1,
                'borrow_date' => '2025-11-28 11:00:00',
                'return_date' => '2025-11-29 09:00:00',
                'status' => 'Returned',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 1, // Alice
                'equipment_id' => 4, // HDMI Cable
                'quantity' => 3,
                'borrow_date' => '2025-11-25 09:15:00',
                'return_date' => '2025-11-26 08:00:00',
                'status' => 'Returned',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 7, // Grace
                'equipment_id' => 6, // Desktop Computer
                'quantity' => 1,
                'borrow_date' => '2025-11-26 10:00:00',
                'return_date' => '2025-11-27 17:00:00',
                'status' => 'Returned',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 10, // Jack
                'equipment_id' => 9, // External Hard Drive
                'quantity' => 1,
                'borrow_date' => '2025-11-27 10:00:00',
                'return_date' => '2025-11-28 14:00:00',
                'status' => 'Returned',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 13, // Mia
                'equipment_id' => 12, // Microphone
                'quantity' => 1,
                'borrow_date' => '2025-11-28 10:00:00',
                'return_date' => '2025-11-29 12:00:00',
                'status' => 'Returned',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 5, // Eve
                'equipment_id' => 1, // Laptop
                'quantity' => 1,
                'borrow_date' => '2025-11-23 10:15:00',
                'return_date' => '2025-11-23 17:00:00',
                'status' => 'Returned',
                'is_deleted' => 0,
            ],

            // --- Borrowed Logs (10) ---
            [
                'user_id' => 3, // Charlie
                'equipment_id' => 2, // DLP Projector
                'quantity' => 1,
                'borrow_date' => '2025-11-25 08:30:00',
                'return_date' => NULL,
                'status' => 'Borrowed',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 4, // Dana
                'equipment_id' => 5, // Lab Room Key
                'quantity' => 1,
                'borrow_date' => '2025-11-25 10:00:00',
                'return_date' => NULL,
                'status' => 'Borrowed',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 2, // Bob
                'equipment_id' => 1, // Laptop
                'quantity' => 1,
                'borrow_date' => '2025-11-25 10:30:00',
                'return_date' => NULL,
                'status' => 'Borrowed',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 3, // Charlie
                'equipment_id' => 1, // Laptop
                'quantity' => 2,
                'borrow_date' => '2025-11-25 11:00:00',
                'return_date' => NULL,
                'status' => 'Borrowed',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 8, // Henry
                'equipment_id' => 7, // Wireless Mouse
                'quantity' => 2,
                'borrow_date' => '2025-11-26 11:00:00',
                'return_date' => NULL,
                'status' => 'Borrowed',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 11, // Karen
                'equipment_id' => 10, // Network Switch
                'quantity' => 1,
                'borrow_date' => '2025-11-27 13:00:00',
                'return_date' => NULL,
                'status' => 'Borrowed',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 15, // Olivia
                'equipment_id' => 14, // VR Headset
                'quantity' => 1,
                'borrow_date' => '2025-11-28 09:00:00',
                'return_date' => NULL,
                'status' => 'Borrowed',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 16, // Paul
                'equipment_id' => 15, // Arduino Kit
                'quantity' => 1,
                'borrow_date' => '2025-11-28 10:00:00',
                'return_date' => NULL,
                'status' => 'Borrowed',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 17, // Quinn
                'equipment_id' => 16, // Raspberry Pi
                'quantity' => 1,
                'borrow_date' => '2025-11-28 11:00:00',
                'return_date' => NULL,
                'status' => 'Borrowed',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 18, // Ryan
                'equipment_id' => 17, // Ethernet Cable
                'quantity' => 5,
                'borrow_date' => '2025-11-29 09:00:00',
                'return_date' => NULL,
                'status' => 'Borrowed',
                'is_deleted' => 0,
            ],
        ];

        $borrowsModel = model('Borrows_Model');
        $borrowsModel->insertBatch($borrows);
    }
}
