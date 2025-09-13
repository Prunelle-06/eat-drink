<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Stand;
use App\Models\Product;
use App\Models\StandFavorite;
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
                ->count(rand(0, 13)) 
                ->create(['stand_id' => $stand->id]);
        }

        // Seeder Favoris
        $visiteurs = User::where('type', 'visiteur')->get();
        foreach ($visiteurs as $visiteur) {
            // 25% de chance qu'un visiteur n'ait aucun favori
            if (rand(1, 100) <= 25) {
                continue;
            }

            $nombreFavoris = rand(1, 8);
            $favoriteStands = $standsApprouves->random($nombreFavoris);

            foreach ($favoriteStands as $stand) {
                StandFavorite::factory()->create([
                    'user_id' => $visiteur->id,
                    'stand_id' => $stand->id,
                ]);
            }
        }
    }
}
