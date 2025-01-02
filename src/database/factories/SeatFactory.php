<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Seat;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
    protected $model = Seat::class; 

    public function definition(): array
    {
        return [
            'screening_id' => null,
            'row' => fake()->randomElement(['A', 'B']),
            'number' => fake()->numberBetween(1, 10),
            'is_reserved' => false,
        ];
    }
}
