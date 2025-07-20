<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Stand;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a pending contractor
        User::create([
            'name' => 'Pending Contractor',
            'company_name' => 'Pending Corp',
            'email' => 'pending@example.com',
            'password' => Hash::make('password'),
            'role' => 'contractor_pending',
        ]);

        // Create an approved contractor with a stand and products
        $approvedUser = User::create([
            'name' => 'Approved Contractor',
            'company_name' => 'Approved Inc',
            'email' => 'approved@example.com',
            'password' => Hash::make('password'),
            'role' => 'contractor_approved',
        ]);

        $stand = Stand::create([
            'stand_name' => 'Le stand de Approved Inc',
            'description' => 'Les meilleurs produits de la région.',
            'user_id' => $approvedUser->id,
        ]);

        Product::create([
            'name' => 'Produit 1',
            'description' => 'Description du produit 1',
            'price' => 10.50,
            'stand_id' => $stand->id,
        ]);

        Product::create([
            'name' => 'Produit 2',
            'description' => 'Description du produit 2',
            'price' => 20.00,
            'stand_id' => $stand->id,
        ]);
    }
}
