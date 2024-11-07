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
     * This method creates a default user with the email 'case77sol@case77sol.com'
     * and password 'password' if it does not already exist.
     *
     * @return void
     */
    public function run()
    {
        // Query the database for a user with the email address 'case77sol@case77sol.com'
        $user = User::where('email', 'case77sol@case77sol.com')->first();

        // If the user does not already exist, create one
        if (!$user) {
            User::create([
                'name' => 'case77sol',
                'email' => 'case77sol@case77sol.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
