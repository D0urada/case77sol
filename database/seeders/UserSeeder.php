<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Usando a model User para criar ou garantir que o usuário não seja duplicado
        $user = User::where('email', 'case77sol@case77sol.com')->first();

        // Se o usuário não existir, cria-o
        if (!$user) {
            User::create([
                'name' => 'case77sol', // Nome fixo do usuário
                'email' => 'case77sol@case77sol.com', // E-mail fixo
                'password' => Hash::make('password'), // Senha criptografada
            ]);
        }
    }
}
