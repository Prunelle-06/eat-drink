<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Stand;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserStandProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création des 10 users avec leur statut et leur stand
        $users = User::factory(10)
            ->has(Stand::factory())
            ->create();

        // Filtrer seulement les users approuvés
        $approvedUsers = $users->where('role', 'entrepreneur_approuve');

        // Vérifier qu'il y a bien des users approuvés avant de créer des produits
        if ($approvedUsers->isNotEmpty()) {
            Product::factory(60)
                ->create([
                    'user_id' => fn() => $approvedUsers->random()->id
            ]);
        } 
    }
}
