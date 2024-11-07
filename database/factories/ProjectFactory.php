<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Client;
use App\Models\Equipment;
use App\Models\InstallationType;
use App\Models\Uf;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get an array of all equipment names
        $equipments = Equipment::all()->pluck('name')->toArray();

        // Select a random set of equipment, with each equipment having a
        // quantity between 1 and 10
        $randomEquipments = collect($equipments)
            ->random(rand(1, 5)) // Select a random number of equipment between 1 and 5
            ->mapWithKeys(function ($equipment) {
                // For each equipment, return an array with the equipment name
                // as the key, and a random quantity between 1 and 10 as the value
                return [$equipment => rand(1, 10)];
            })
            ->toArray();

        return [
            /**
             * Generate a random project name by combining a company name
             * with the word "Project"
             */
            'name' => $this->faker->company . ' Project',

            /**
             * Generate a random description for the project
             */
            'description' => $this->faker->optional()->paragraph,

            /**
             * Associate a random client with the project. The client is
             * created using the Client factory.
             */
            'client_id' => Client::factory(),

            /**
             * Set the installation type to a random installation type from
             * the InstallationTypes table
             */
            'installation_type' => InstallationType::inRandomOrder()->first()->name,

            /**
             * Set the UF to a random UF from the Ufs table
             */
            'location_uf' => Uf::inRandomOrder()->first()->acronym,

            /**
             * Set the equipment to a random set of equipment, with each
             * equipment having a random quantity between 1 and 10
             */
            'equipment' => $randomEquipments,
        ];
    }
}
