<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@eatdrink.com'],
            [
                'name' => 'Administrateur',
                'email' => 'admin@eatdrink.com',
                'password' => Hash::make('password'), // Change ce mot de passe après le premier login !
                'role' => 'admin',
                'nom_entreprise' => null,
            ]
        );
    }
}