<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class EquipmentSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now('UTC')->toDateTimeString();

        $equipments = [
            [
                'name' => 'Laptop (Lenovo)',
                'description' => 'Standard student laptop for general use.',
                'accessories' => 'Charger',
                'total_count' => 15,
                'available_count' => 11, // 4 laptops currently borrowed (Bob 1, Charlie 2, Eve 1)
                'is_deactivated' => 0,
            ],
            [
                'name' => 'DLP Projector',
                'description' => 'Digital Light Processing Projector.',
                'accessories' => 'Extension cord, VGA/HDMI cable, Power cable',
                'total_count' => 5,
                'available_count' => 4, // Charlie borrowed 1
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Wacom Drawing Tablet',
                'description' => 'Medium size professional graphics tablet.',
                'accessories' => 'Pen',
                'total_count' => 8,
                'available_count' => 8, // Frank returned his borrow
                'is_deactivated' => 0,
            ],
            [
                'name' => 'HDMI Cable',
                'description' => '10-meter High-Definition Multimedia Interface cable.',
                'accessories' => NULL,
                'total_count' => 30,
                'available_count' => 25, // Alice borrowed 5
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Lab Room Key',
                'description' => 'Key for Computer Lab Room 305.',
                'accessories' => NULL,
                'total_count' => 2,
                'available_count' => 1, // Dana borrowed 1
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Desktop Computer',
                'description' => 'High-performance desktop for programming and design.',
                'accessories' => 'Keyboard, Mouse',
                'total_count' => 20,
                'available_count' => 19, // Grace borrowed 1
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse for general use.',
                'accessories' => 'USB Receiver',
                'total_count' => 25,
                'available_count' => 23, // Henry borrowed 2
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'Durable mechanical keyboard with backlight.',
                'accessories' => NULL,
                'total_count' => 15,
                'available_count' => 15, // Isabella returned hers
                'is_deactivated' => 0,
            ],
            [
                'name' => 'External Hard Drive',
                'description' => '1TB portable external hard drive.',
                'accessories' => 'USB Cable',
                'total_count' => 10,
                'available_count' => 9, // Jack borrowed 1
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Network Switch',
                'description' => '24-port Gigabit Ethernet switch.',
                'accessories' => 'Power Adapter',
                'total_count' => 4,
                'available_count' => 3, // Karen borrowed 1
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Router',
                'description' => 'Dual-band wireless router for lab use.',
                'accessories' => 'Power Adapter',
                'total_count' => 6,
                'available_count' => 6, // Liam returned his
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Microphone',
                'description' => 'USB condenser microphone for recording.',
                'accessories' => 'Stand, USB Cable',
                'total_count' => 7,
                'available_count' => 6, // Mia borrowed 1
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Webcam',
                'description' => 'HD webcam for online meetings.',
                'accessories' => 'USB Cable',
                'total_count' => 12,
                'available_count' => 11, // Noah borrowed 1
                'is_deactivated' => 0,
            ],
            [
                'name' => 'VR Headset',
                'description' => 'Virtual reality headset for immersive applications.',
                'accessories' => 'Controllers, Charger',
                'total_count' => 3,
                'available_count' => 2, // Olivia borrowed 1
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Arduino Kit',
                'description' => 'Starter kit for electronics and IoT projects.',
                'accessories' => 'Cables, Sensors',
                'total_count' => 10,
                'available_count' => 9, // Paul borrowed 1
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Raspberry Pi',
                'description' => 'Mini computer for embedded projects.',
                'accessories' => 'Power Adapter, Case',
                'total_count' => 8,
                'available_count' => 7, // Quinn borrowed 1
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Ethernet Cable',
                'description' => '5-meter Cat6 Ethernet cable.',
                'accessories' => NULL,
                'total_count' => 40,
                'available_count' => 35, // Ryan borrowed 5
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Power Bank',
                'description' => '20,000mAh portable power bank.',
                'accessories' => 'USB Cable',
                'total_count' => 10,
                'available_count' => 10, // not borrowed
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Laser Pointer',
                'description' => 'Presentation laser pointer with remote control.',
                'accessories' => 'Battery',
                'total_count' => 5,
                'available_count' => 5, // not borrowed
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Tripod Stand',
                'description' => 'Adjustable tripod stand for cameras and projectors.',
                'accessories' => NULL,
                'total_count' => 6,
                'available_count' => 6, // not borrowed
                'is_deactivated' => 0,
            ],
        ];

        $equipmentsModel = model('Equipments_Model');
        $equipmentsModel->insertBatch($equipments);
    }
}
