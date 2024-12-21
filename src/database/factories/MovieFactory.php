<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = '2024-01-01';
        $endDate = '2024-12-31';
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(3),
            'release_date' => fake()->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),
        ];
    }
}
