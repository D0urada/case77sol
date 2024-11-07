<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds to populate the projects table.
     *
     * This method will generate 50 random project entries
     * using the Project factory.
     *
     * @return void
     */
    public function run(): void
    {
        // Generate 50 projects using the factory and save them to the database
        Project::factory()->count(5)->create();
    }
}
