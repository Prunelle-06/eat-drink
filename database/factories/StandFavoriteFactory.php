<?php

namespace Database\Factories;

use App\Models\Stand;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StandFavorite>
 */
class StandFavoriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 70% de chance d'être récent, 30% d'être ancien
        $isRecent = $this->faker->boolean(70);
        
        if ($isRecent) {
            // Favoris récents (0 à 6 jours)
            $createdAt = $this->faker->dateTimeBetween('-6 days', 'now');
        } else {
            // Favoris anciens (1 à 8 semaines)
            $createdAt = $this->faker->dateTimeBetween('-8 weeks', '-1 week');
        }
        return [
            'user_id' => User::factory(),
            'stand_id' => Stand::factory(),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }

    // public function forUser($user)
    // {
    //     return $this->state(function (array $attributes) use ($user) {
    //         return [
    //             'user_id' => $user->id,
    //         ];
    //     });
    // }

    // public function forStand($stand)
    // {
    //     return $this->state(function (array $attributes) use ($stand) {
    //         return [
    //             'stand_id' => $stand->id,
    //         ];
    //     });
    // }

    // public function withTimestamps($createdAt, $updatedAt = null)
    // {
    //     return $this->state(function (array $attributes) use ($createdAt, $updatedAt) {
    //         return [
    //             'created_at' => $createdAt,
    //             'updated_at' => $updatedAt ?? $createdAt,
    //         ];
    //     });
    // }
}
