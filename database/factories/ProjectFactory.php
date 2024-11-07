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
        // Pega os nomes de todos os equipamentos
        $equipments = Equipment::all()->pluck('name')->toArray();

        // Seleciona de 1 a 5 equipamentos aleatórios
        $randomEquipments = collect($equipments)
            ->random(rand(1, 5)) // Pega entre 1 e 5 equipamentos aleatórios
            ->mapWithKeys(function ($equipment) {
                // Para cada equipamento, gera uma quantidade aleatória
                return [$equipment => rand(1, 10)]; // Quantidade entre 1 e 10
            })
            ->toArray();

        return [
            'name' => $this->faker->company . ' Project',
            'description' => $this->faker->optional()->paragraph,
            'client_id' => Client::factory(), // Associate a random client from the Client factory
            'installation_type' => InstallationType::inRandomOrder()->first()->name, // Random installation type from the InstallationTypes table
            'location_uf' => Uf::inRandomOrder()->first()->acronym, // Random UF from the Ufs table
            'equipment' => $randomEquipments, // Get random equipment names
        ];
    }
}
