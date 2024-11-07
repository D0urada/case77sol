<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create();

        // Run the seeders in the correct order.
        $this->call([
            UserSeeder::class,
            UfsSeeder::class, // First, seed the Ufs table.
            InstallationTypeSeeder::class, // Then, seed the InstallationTypes table.
            ClientSeeder::class, // After that, seed the Clients table.
            EquipmentSeeder::class, // EquipmentSeeder have to also be added.
            ProjectSeeder::class, // Finally, seed the Projects table.
        ]);
    }
}
