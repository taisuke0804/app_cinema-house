<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Seat;
use App\Services\Admin\MovieService;

class MovieServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_movie(): void
    {
        $movie = Movie::factory()->create();
        $screening = Screening::factory()->create(['movie_id' => $movie->id]);
        $reservedSeat = Seat::factory()->create([
            'screening_id' => $screening->id, 
            'row' => 'A',
            'number' => 1,
            'is_reserved' => true,
        ]);

        $movieService = new MovieService();
        $movieService->deleteMovie($movie->id);

        $this->assertModelMissing($movie);
        // 親テーブルのレコードが削除された時、子テーブルのレコードも削除されるか確認
        $this->assertModelMissing($screening); 
        $this->assertModelMissing($reservedSeat);
    }
}
