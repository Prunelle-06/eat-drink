<?php

namespace Database\Factories;

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
            'Spécialités régionales', 'Café artisanale'
        ];

        return [
            'nom_stand' => $this->faker->randomElement($categories),
            'description_stand' => $this->faker->paragraph(2),
        ];
    }
}
