<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seat;
use Illuminate\Database\UniqueConstraintViolationException;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        // 複合ユニーク設定を設定してる場合、count()メソッドを利用すると、
        // 重複するデータが生成される可能性があるため、for文を利用して100件生成する
        for ($i = 0; $i < 100; $i++) {
            Seat::factory()->create();
        }
    }
}
