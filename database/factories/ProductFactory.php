<?php

namespace Database\Factories;

use App\Models\User;
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
        $foodNames = [
            'Crêpe Nutella', 'Galette Complète', 'Smoothie Detox', 
            'Salade César', 'Bagel Saumon', 'Pancakes Syrop',
            'Café Spécialité', 'Thé Artisanal', 'Cookie Maison',
            'Tarte Citron', 'Sandwich Club', 'Jus Pressé'
        ];

        return [
            'nom_produit' => $this->faker->randomElement($foodNames),
            'description' => $this->faker->sentence(10),
            'prix' => $this->faker->numberBetween(300, 2000),
            'photo' => 'products/' . $this->faker->randomElement([
                'crepe.jpg', 'jus.jpg', 'sandwich.jpg',
                'salade.jpg', 'dessert.jpg', 'cafe.jpg'
            ]),
            // 'user_id' => User::factory(),
        ];
    }
}
