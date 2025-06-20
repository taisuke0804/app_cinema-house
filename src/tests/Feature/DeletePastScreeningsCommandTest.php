<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Screening;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class DeletePastScreeningsCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1週間以上前の上映スケジュールを削除するコマンドのテスト
     */
    public function test_deletes_screenings_ended_more_than_one_week_ago(): void
    {
        $movie = Movie::factory()->create();

        // 削除対象と非対象を作成
        $screening1 = Screening::factory()->create([
            'start_time' => Carbon::now()->subDays(8)->setTime(10, 0, 0),
            'end_time' => Carbon::now()->subDays(8)->setTime(12, 0, 0),
        ]);

        $screening2 = Screening::factory()->create([
            'start_time' => Carbon::now()->subDays(3)->setTime(14, 0, 0),
            'end_time' => Carbon::now()->subDays(3)->setTime(16, 0, 0),
        ]);

        $this->assertDatabaseCount('screenings', 2);

        Artisan::call('screenings:delete-past'); // Artisanコマンドを実行

        $this->assertDatabaseCount('screenings', 1);

        // 非対象のレコードが残ってるかどうかを確認
        $this->assertDatabaseHas('screenings', [
            'id' => $screening2->id,
        ]);
    }
}
