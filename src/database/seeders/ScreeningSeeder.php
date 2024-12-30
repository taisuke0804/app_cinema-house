<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Screening;

class ScreeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 重複する上映スケジュールが生成される可能性があるため、for文を利用して20件生成する
        for ($i = 0; $i < 20; $i++) {
            Screening::factory()->create();
        }
    }
}
