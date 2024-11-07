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
            ->map(function ($equipment) {
                return [
                    'name' => $equipment,
                    'quantity' => rand(1, 10),
                ];
            })
            ->toArray();

        // Convert the equipment array to JSON
        $equipmentJson = json_encode($randomEquipments);

        return [
            'name' => $this->faker->company . ' Project',
            'description' => $this->faker->optional()->paragraph,
            'client_id' => Client::factory(),
            'installation_type' => InstallationType::inRandomOrder()->first()->name,
            'location_uf' => Uf::inRandomOrder()->first()->acronym,
            'equipment' => $randomEquipments,  // Garante que o formato seja um array de objetos com name e quantity
        ];
    }
}
