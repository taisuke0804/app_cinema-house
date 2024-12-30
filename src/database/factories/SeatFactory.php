<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Screening;
use App\Models\Seat;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
    protected $model = Seat::class; 

    public function definition(): array
    {
        return $this->generateNonOverlappingSeat();
    }

    private function generateNonOverlappingSeat(): array
    {
        do {
            $row = fake()->randomElement(['A', 'B']);
            $number = fake()->numberBetween(1, 10);
            $screeningId = Screening::query()->inRandomOrder()->value('id');

            // 重複する座席が存在するかチェック
            $overlapping = Seat::where('screening_id', $screeningId)
                ->where('row', $row)
                ->where('number', $number)
                ->exists();

        } while ($overlapping);

        return [
            'screening_id' => $screeningId,
            'row' => $row,
            'number' => $number,
            'is_reserved' => fake()->boolean(90), // 90%の確率でtrue
        ];
    }
}
