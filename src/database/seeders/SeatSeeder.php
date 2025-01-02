<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seat;
use Illuminate\Database\UniqueConstraintViolationException;
use App\Models\Screening;
use App\Models\User;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        $screenings = Screening::all();
        $rows = ['A', 'B']; // 行
        $seatsPerRow = 10;       // 1行あたりの席数

        foreach ($screenings as $screening) {
            $seats = [];

            foreach ($rows as $row) {
                for ($number = 1; $number <= $seatsPerRow; $number++) {
                    $seats[] = [
                        'screening_id' => $screening->id,
                        'row' => $row,
                        'number' => $number,
                        'is_reserved' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            Seat::insert($seats); // 一括挿入で座席を生成
        }

        /**
         * 予約済みの座席を生成
         */
        $seatReserveCount = 100; // 予約する座席数
        for ($i = 0; $i < $seatReserveCount; $i++) {
            do {
                $userId = User::query()->inRandomOrder()->value('id');
                $screeningId = Screening::query()->inRandomOrder()->value('id');
                $seat = Seat::where('screening_id', $screeningId)
                    ->inRandomOrder()
                    ->first();

                // ランダムで取得した座席が予約済みかチェック
                $ReservedSeat = Seat::where('screening_id', $screeningId)
                    ->where('row', $seat->row)
                    ->where('number', $seat->number)
                    ->where('is_reserved', true)
                    ->exists();

                // screening_idとuser_idの組み合わせが重複しているかチェック
                $overlappingUser = Seat::where('screening_id', $screeningId)
                    ->where('user_id', $userId)
                    ->exists();
            } while ($overlappingUser || $ReservedSeat);

            $seat->update([
                'user_id' => $userId,
                'is_reserved' => true,
            ]);
        }
    }
}
