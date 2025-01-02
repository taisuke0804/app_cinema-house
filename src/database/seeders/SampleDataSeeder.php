<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Seat;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@gmail.com',
            'password' => Hash::make('1111aaaa'),
        ]);

        $movie = Movie::factory()->create([
            'title' => 'スターウォーズ エピソード4/新たなる希望',
            'description' => 'かつて、銀河帝国の支配下にあった銀河系。反乱軍は、帝国軍の支配から逃れるため、銀河系の辺境に拠点を構えていた。しかし、帝国軍は反乱軍の拠点を発見し、攻撃を開始する。反乱軍は、帝国軍の攻撃をかわすため、銀河系の遥か彼方にある惑星タトゥイーンに逃れる。',
            'genre' => 1,
        ]);

        $yesterday = Carbon::yesterday();

        $screening = Screening::factory()->create([
            'movie_id' => $movie->id,
            'start_time' => $yesterday->clone()->setTime(10, 0, 0),
            'end_time' => $yesterday->clone()->setTime(12, 0, 0),
        ]);

        $seat = Seat::factory()->create([
            'screening_id' => $screening->id,
            'user_id' => $user->id,
            'row' => 'A',
            'number' => 1,
            'is_reserved' => true,
        ]);

        $movie = Movie::factory()->create([
            'title' => 'スターウォーズ エピソード5/帝国の逆襲',
            'description' => '反乱軍は、帝国軍の攻撃をかわすため、銀河系の遥か彼方にある氷の惑星ホスに拠点を移した。しかし、帝国軍は、反乱軍の新たな拠点を発見し、攻撃を開始する。反乱軍は、帝国軍の攻撃をかわすため、ホスの氷の惑星を離れる。',
            'genre' => 1,
        ]);

        $today = Carbon::today();

        $screening = Screening::factory()->create([
            'movie_id' => $movie->id,
            'start_time' => $today->clone()->setTime(10, 0, 0),
            'end_time' => $today->clone()->setTime(12, 0, 0),
        ]);

        $seat = Seat::factory()->create([
            'screening_id' => $screening->id,
            'user_id' => $user->id,
            'row' => 'B',
            'number' => 2,
            'is_reserved' => true,
        ]);

        $movie = Movie::factory()->create([
            'title' => 'スターウォーズ エピソード6/ジェダイの帰還',
            'description' => '反乱軍は、帝国軍の攻撃をかわすため、銀河系の遥か彼方にある森の惑星エンドアに拠点を移した。しかし、帝国軍は、反乱軍の新たな拠点を発見し、攻撃を開始する。反乱軍は、帝国軍の攻撃をかわすため、エンドアの森の惑星を離れる。',
            'genre' => 2,
        ]);

        $tomorrow = Carbon::tomorrow();

        $screening = Screening::factory()->create([
            'movie_id' => $movie->id,
            'start_time' => $tomorrow->clone()->setTime(10, 0, 0),
            'end_time' => $tomorrow->clone()->setTime(12, 0, 0),
        ]);

        $seat = Seat::factory()->create([
            'screening_id' => $screening->id,
            'user_id' => null,
            'row' => 'A',
            'number' => 3,
            'is_reserved' => false,
        ]);
    }
}
