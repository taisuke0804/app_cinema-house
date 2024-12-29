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
        // 重複しない時間を生成するメソッド
        $startAndEnd = $this->generateNonOverlappingTimes();

        return [
            // moviesテーブルの既存のmovie_idをランダムに取得
            'movie_id' => Movie::query()->inRandomOrder()->value('id'),
            'start_time' => $startAndEnd['start_time'],
            'end_time' => $startAndEnd['end_time'],
        ];
    }

    private function generateNonOverlappingTimes(): array
    {
        do {
            $hours = fake()->numberBetween(9, 21);
            $minutes = fake()->randomElement([0, 15, 30, 45]);
            $startDate = fake()->dateTimeBetween('now', '+3 month');
            $startDate = $startDate->setTime($hours, $minutes, 0); // 時間を設定

            // DateTimeオブジェクトを複製してから2時間後に変更
            // DateTime::modify() メソッドは、日時を相対的に変更できるメソッド
            $endDate = (clone $startDate)->modify('+2 hours');
            
            // 重複するスケジュールが存在するかチェック
            $overlapping = Screening::where('start_time', '<', $endDate)
                ->where('end_time', '>', $startDate)
                ->exists();

        } while ($overlapping);

        return [
            'start_time' => $startDate,
            'end_time' => $endDate,
        ];
    }
}
