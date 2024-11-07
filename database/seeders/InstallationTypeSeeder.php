<?php

namespace Database\Seeders;

use App\Models\InstallationType;
use Illuminate\Database\Seeder;

class InstallationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Installation types to be seeded
        $installationTypes = [
            'Fibrocimento (Madeira)',
            'Fibrocimento (Metálico)',
            'Cerâmico',
            'Metálico',
            'Laje',
            'Solo',
        ];

        // Loop through the installation types and insert them into the database
        foreach ($installationTypes as $type) {
            InstallationType::create([
                'name' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
