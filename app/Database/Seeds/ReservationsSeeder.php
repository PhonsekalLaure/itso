<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ReservationsSeeder extends Seeder
{
    public function run()
    {
        // Based on App\Models\Reservations_Model allowed fields
        // user_id, equipment_id, quantity, reservation_date, pickup_date, status, is_deleted
        $reservations = [
            [
                'user_id' => 2,
                'equipment_id' => 1,
                'quantity' => 1,
                'reservation_date' => '2025-11-29 09:15:00',
                'pickup_date' => '2025-11-29 10:00:00',
                'status' => 'ready for pickup',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 5,
                'equipment_id' => 4,
                'quantity' => 2,
                'reservation_date' => '2025-11-28 14:30:00',
                'pickup_date' => '2025-11-28 15:00:00',
                'status' => 'finished',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 3,
                'equipment_id' => 2,
                'quantity' => 1,
                'reservation_date' => '2025-11-27 11:00:00',
                'pickup_date' => NULL,
                'status' => 'canceled',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 7,
                'equipment_id' => 6,
                'quantity' => 1,
                'reservation_date' => '2025-11-26 10:00:00',
                'pickup_date' => '2025-11-26 12:00:00',
                'status' => 'finished',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 9,
                'equipment_id' => 8,
                'quantity' => 1,
                'reservation_date' => '2025-11-25 09:30:00',
                'pickup_date' => NULL,
                'status' => 'ready for pickup',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 11,
                'equipment_id' => 10,
                'quantity' => 1,
                'reservation_date' => '2025-11-25 16:00:00',
                'pickup_date' => '2025-11-26 09:00:00',
                'status' => 'finished',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 12,
                'equipment_id' => 11,
                'quantity' => 1,
                'reservation_date' => '2025-11-24 08:45:00',
                'pickup_date' => NULL,
                'status' => 'canceled',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 14,
                'equipment_id' => 13,
                'quantity' => 1,
                'reservation_date' => '2025-11-24 13:20:00',
                'pickup_date' => '2025-11-24 14:00:00',
                'status' => 'finished',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 15,
                'equipment_id' => 14,
                'quantity' => 1,
                'reservation_date' => '2025-11-23 12:00:00',
                'pickup_date' => NULL,
                'status' => 'canceled',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 16,
                'equipment_id' => 15,
                'quantity' => 1,
                'reservation_date' => '2025-11-23 15:30:00',
                'pickup_date' => '2025-11-24 09:30:00',
                'status' => 'finished',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 4,
                'equipment_id' => 5,
                'quantity' => 1,
                'reservation_date' => '2025-11-29 08:00:00',
                'pickup_date' => NULL,
                'status' => 'ready for pickup',
                'is_deleted' => 0,
            ],
            [
                'user_id' => 8,
                'equipment_id' => 7,
                'quantity' => 2,
                'reservation_date' => '2025-11-28 09:45:00',
                'pickup_date' => NULL,
                'status' => 'ready for pickup',
                'is_deleted' => 0,
            ],
        ];

        $reservationsModel = model('Reservations_Model');
        $reservationsModel->insertBatch($reservations);
    }
}
