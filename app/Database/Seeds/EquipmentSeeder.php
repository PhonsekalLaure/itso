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
                'name'             => 'Canon EOS 80D Camera',
                'description'      => '24.2MP DSLR camera with 18-135mm lens kit.',
                'total_count'      => 5,
                'available_count'  => 5,
            ],
            [
                'name'             => 'Tripod Stand',
                'description'      => 'Aluminum tripod, 55-inch with quick release plate.',
                'total_count'      => 10,
                'available_count'  => 10,
            ],
            [
                'name'             => 'LED Panel Light',
                'description'      => 'Bi-color LED panel with adjustable brightness, includes battery.',
                'total_count'      => 8,
                'available_count'  => 8,
            ],
            [
                'name'             => 'Wireless Microphone',
                'description'      => 'UHF wireless lavalier mic system, dual-channel.',
                'total_count'      => 6,
                'available_count'  => 6,
            ],
            [
                'name'             => 'Projector',
                'description'      => '1080p portable projector, HDMI/USB inputs.',
                'total_count'      => 3,
                'available_count'  => 3,
            ],
        ];

        $equipmentsModel = model('Equipments_Model');
        $equipmentsModel->insertBatch($equipments);
    }
}
