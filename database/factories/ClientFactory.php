<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
	protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // CPFCNPJ: either a valid CPF or a valid CNPJ
        // 50% chance of being a CPF, 50% of being a CNPJ
        $cpfcnpj = $this->faker->randomElement([
            // CPF
            $this->faker->cpf(),
            // CNPJ
            $this->faker->cnpj(),
        ]);

        // Name: a random name
        $name = $this->faker->name();

        // Email: a unique safe email
        $email = $this->faker->unique()->safeEmail();

        // Phone: 50% chance of having a phone number, 50% of not having one
        // if there is a phone number, it's a valid Brazilian phone number
        $phone = $this->faker->optional()->brazilianPhoneNumber();

        return [
            'cpfcnpj' => $cpfcnpj,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
        ];
    }
}
