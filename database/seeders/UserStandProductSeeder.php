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
        // Créer les visiteurs
        User::factory(10)->visiteur()->create();

        // Créer des stands avec leurs exposants
        Stand::factory(16)->approuve()->create();
        Stand::factory(9)->enAttente()->create();
        Stand::factory(7)->rejete()->create();

        // Récuperation stand approuvés
        $standsApprouves = Stand::where('statut', 'approuve')->get();

        foreach ($standsApprouves as $stand) {
            Product::factory()
                ->count(rand(0, 13)) // Entre 3 et 8 produits par stand
                ->create(['stand_id' => $stand->id]);
        }
    }
}
