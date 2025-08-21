<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stand>
 */
class StandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $categories = [
            'Crêperie', 'Pâtisserie', 'Bar à jus', 
            'Cuisine du monde', 'Vegan', 'Produits bio',
            'Spécialités régionales', 'Café artisanale',
            'Le Petit Gourmand', 'Saveurs d\'Antan', 'La Table du Chef',
            'Délices & Merveilles', 'Au Bon Terroir', 'L\'Épicurien',
            'Jardin des Saveurs', 'La Marmite Dorée', 'Plaisirs Sucrés',
            'Le Coin Gourmand', 'Terroir & Tradition', 'L\'Art Culinaire',
            'Saveurs du Monde', 'La Belle Époque', 'Délices Authentiques'
        ];
        $images = [
            'stand_1.jpg', 'stand_2.jpg', 'stand_3.jpg', 'stand_4.jpg',
            'stand_5.jpg', 'stand_6.jpg', 'stand_7.jpg', 'stand_8.jpg'
        ];

        return [
            'nom_stand' => $this->faker->randomElement($categories),
            'description_stand' => $this->faker->paragraph(3) . ' ' . 
                                   $this->faker->sentence(10) . ' ' .
                                   'Venez découvrir nos spécialités locales et nos produits artisanaux.',
            'image_stand' => $this->faker->randomElement($images),
            'statut' => $this->faker->randomElement(['en_attente', 'approuve', 'rejete']),
            'user_id' => User::factory()->exposant(),
        ];
    }

    public function approuve(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => 'approuve',
        ]);
    }

    public function enAttente(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => 'en_attente',
        ]);
    }

    public function rejete(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => 'rejete',
        ]);
    }
}
