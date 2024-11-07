<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds to populate the clients table.
     *
     * This method will generate 50 random client entries
     * using the Client factory.
     *
     * @return void
     */
    public function run(): void
    {
        // Generate 50 clients using the factory and save them to the database
        Client::factory()->count(20)->create();
    }
}
