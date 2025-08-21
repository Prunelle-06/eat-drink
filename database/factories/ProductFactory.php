<?php

namespace Database\Factories;

use App\Models\Stand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $produits = [
            'Crêpe Nutella', 'Galette Complète', 'Smoothie Detox', 
            'Salade César', 'Bagel Saumon', 'Pancakes Syrop',
            'Café Spécialité', 'Thé Artisanal', 'Cookie Maison',
            'Tarte Citron', 'Sandwich Club', 'Jus Pressé',
            'Croissant aux Amandes', 'Tarte Tatin', 'Coq au Vin',
            'Bouillabaisse', 'Ratatouille', 'Crème Brûlée',
            'Macarons Assortis', 'Foie Gras', 'Fromages Affinés',
            'Confit de Canard', 'Soupe à l\'Oignon', 'Éclair au Chocolat'
        ];

        return [
            'nom_produit' => $this->faker->randomElement($produits),
            'description' => $this->faker->sentence(10),
            'prix' => $this->faker->numberBetween(300, 2000),
            'photo' => $this->faker->randomElement([
                'crepe.jpg', 'jus.jpg', 'sandwich.jpg',
                'salade.jpg', 'dessert.jpg', 'cafe.jpg'
            ]),
            'stand_id' => Stand::factory()->approuve()
        ];
    }
}
