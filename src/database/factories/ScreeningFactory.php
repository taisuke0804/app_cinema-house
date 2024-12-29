<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Screening;
use App\Models\Movie;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Screening>
 */
class ScreeningFactory extends Factory
{
    protected $model = Screening::class;

    public function definition(): array
    {
        // DateTimeオブジェクトを複製してから2時間後に変更
        // DateTime::modify() メソッドは、日時を相対的に変更できるメソッド
        $start = fake()->dateTimeBetween('now', '+1 month');
        $end = (clone $start)->modify('+2 hours');

        return [
            // moviesテーブルの既存のmovie_idをランダムに取得
            'movie_id' => Movie::query()->inRandomOrder()->value('id'),
            'start_time' => $start,
            'end_time' => $end,
        ];
    }
}
