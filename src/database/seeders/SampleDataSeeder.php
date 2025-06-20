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
            'email' => env('TEST_USER_EMAIL', 'test@gmail.com'),
            'password' => Hash::make(env('TEST_USER_PASSWORD', '1111aaaa')),
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

        foreach (range('A', 'B') as $row) {
            foreach (range(1, 10) as $number) {
                $seat = Seat::factory()->create([
                    'screening_id' => $screening->id,
                    'user_id' => NULL,
                    'row' => $row,
                    'number' => $number,
                    'is_reserved' => false,
                ]);
            }
        }
        $seatSample1 = Seat::where('screening_id', $screening->id)->where('row', 'A')->where('number', 1)->first();
        $seatSample1->user_id = $user->id;
        $seatSample1->is_reserved = true;
        $seatSample1->save();

        $movie = Movie::factory()->create([
            'title' => 'スターウォーズ エピソード5/帝国の逆襲',
            'description' => '反乱軍は、帝国軍の攻撃をかわすため、銀河系の遥か彼方にある氷の惑星ホスに拠点を移した。しかし、帝国軍は、反乱軍の新たな拠点を発見し、攻撃を開始する。反乱軍は、帝国軍の攻撃をかわすため、ホスの氷の惑星を離れる。',
            'genre' => 1,
        ]);

        $today = Carbon::today();

        $screening = Screening::factory()->create([
            'movie_id' => $movie->id,
            'start_time' => $today->clone()->setTime(21, 0, 0),
            'end_time' => $today->clone()->setTime(22, 0, 0),
        ]);

        foreach (range('A', 'B') as $row) {
            foreach (range(1, 10) as $number) {
                $seat = Seat::factory()->create([
                    'screening_id' => $screening->id,
                    'user_id' => NULL,
                    'row' => $row,
                    'number' => $number,
                    'is_reserved' => false,
                ]);
            }
        }
        $seatSample2 = Seat::where('screening_id', $screening->id)->where('row', 'B')->where('number', 2)->first();
        $seatSample2->user_id = $user->id;
        $seatSample2->is_reserved = true;
        $seatSample2->save();

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

        foreach (range('A', 'B') as $row) {
            foreach (range(1, 10) as $number) {
                $seat = Seat::factory()->create([
                    'screening_id' => $screening->id,
                    'user_id' => NULL,
                    'row' => $row,
                    'number' => $number,
                    'is_reserved' => false,
                ]);
            }
        }
        $seatSample3 = Seat::where('screening_id', $screening->id)->where('row', 'A')->where('number', 3)->first();
        $seatSample3->user_id = $user->id;
        $seatSample3->is_reserved = false;
        $seatSample3->save();

        $movie = Movie::factory()->create([
            'title' => 'プロジェクトA',
            'description' => 'ジャッキー・チェン主演のアクション映画。20世紀初頭の香港。海賊の撃退をドラゴンたち水上警察が任せられるもうまくいかない。おかげでライバルがいる陸上警察に吸収。しかし友情が芽生え、協力して海賊退治へ乗り出す。',
            'genre' => 2,
        ]);

        $before15Days = Carbon::now()->subDays(15);

        $screening = Screening::factory()->create([
            'movie_id' => $movie->id,
            'start_time' => $before15Days->clone()->setTime(10, 0, 0),
            'end_time' => $before15Days->clone()->setTime(12, 0, 0),
        ]);

        foreach (range('A', 'B') as $row) {
            foreach (range(1, 10) as $number) {
                $seat = Seat::factory()->create([
                    'screening_id' => $screening->id,
                    'user_id' => NULL,
                    'row' => $row,
                    'number' => $number,
                    'is_reserved' => false,
                ]);
            }
        }
        $seatSample4 = Seat::where('screening_id', $screening->id)->where('row', 'B')->where('number', 5)->first();
        $seatSample4->user_id = $user->id;
        $seatSample4->is_reserved = false;
        $seatSample4->save();
    }
}
