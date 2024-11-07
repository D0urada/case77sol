<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the list of equipment names
        $equipments = [
            'Módulo',
            'Inversor',
            'Microinversor',
            'Estrutura',
            'Cabo vermelho',
            'Cabo preto',
            'String Box',
            'Cabo Tronco',
            'Endcap',
        ];

        // Loop through the equipment names and create entries in the database
        foreach ($equipments as $equipment) {
            Equipment::create([
                'name' => $equipment,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
