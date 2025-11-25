<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class EquipmentSeeder extends Seeder
{
    public function run()
    {
        // Based on App\Models\Equipments_Model allowed fields
        // name, description, total_count, available_count, is_deactivated, date_added
        $now = Time::now('UTC')->toDateTimeString();

        $equipments = [
            [
                'name' => 'Laptop (Lenovo)',
                'description' => 'Standard student laptop for general use.',
                'accessories' => 'Charger',
                'total_count' => 15,
                'available_count' => 15,
                'is_deactivated' => 0,
            ],
            [
                'name' => 'DLP Projector',
                'description' => 'Digital Light Processing Projector.',
                'accessories' => 'Extension cord, VGA/HDMI cable, Power cable',
                'total_count' => 5,
                'available_count' => 5,
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Wacom Drawing Tablet',
                'description' => 'Medium size professional graphics tablet.',
                'accessories' => 'Pen',
                'total_count' => 8,
                'available_count' => 8,
                'is_deactivated' => 0,
            ],
            [
                'name' => 'HDMI Cable',
                'description' => '10-meter High-Definition Multimedia Interface cable.',
                'accessories' => NULL,
                'total_count' => 30,
                'available_count' => 30,
                'is_deactivated' => 0,
            ],
            [
                'name' => 'Lab Room Key',
                'description' => 'Key for Computer Lab Room 305.',
                'accessories' => NULL,
                'total_count' => 2,
                'available_count' => 2,
                'is_deactivated' => 0,
            ]
        ];

        $equipmentsModel = model('Equipments_Model');
        $equipmentsModel->insertBatch($equipments);
    }
}
