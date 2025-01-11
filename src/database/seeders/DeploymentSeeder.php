<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Seat;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DeploymentSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            Admin::factory()->create([
                'name' => '管理者太郎',
                'email' => env('ADMIN_EMAIL', 'admin@gmail.com'),
                'email_verified_at' => now(),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin1234')),
                'remember_token' => Str::random(10),
            ]);

            User::factory()->count(10)->create();

            $movie1 = Movie::factory()->create([
                'title' => 'ハリーポッターと賢者の石',
                'description' => 'ハリー・ポッターは、魔法使いの世界で有名な一家の子供である。彼は、両親が魔法使いの世界で殺された後、叔父夫婦のもとで育てられていた。しかし、11歳の誕生日に、ホグワーツ魔法学校に入学することができることがわかり、そこで新しい友達と出会い、新しい世界を知る。',
                'genre' => 1,
            ]);

            $movie2 = Movie::factory()->create([
                'title' => 'ハリーポッターと秘密の部屋',
                'description' => 'ハリー・ポッターは、ホグワーツ魔法学校での2年目を迎える。しかし、学校には謎の怪物が現れ、生徒たちが次々と石になってしまう事件が起こる。ハリーは、この事件の真相を解明するために、秘密の部屋に潜入する。',
                'genre' => 1,
            ]);

            $movie3 = Movie::factory()->create([
                'title' => 'ハリーポッターとアズカバンの囚人',
                'description' => 'ハリー・ポッターは、ホグワーツ魔法学校での3年目を迎える。しかし、アズカバン刑務所から脱獄した囚人がホグワーツに迫っているという噂が広まる。ハリーは、囚人の正体を知るために、過去の真実を追求する。',
                'genre' => 3,
            ]);

            $now = \Carbon\Carbon::now();

            $tommorow = $now->copy()->addDays(1);
            $screening1 = Screening::factory()->create([
                'movie_id' => $movie1->id,
                'start_time' => $tommorow->copy()->setTime(9, 0, 0),
                'end_time' => $tommorow->copy()->setTime(11, 0, 0),
            ]);

            $today = $now->copy();
            $screening2 = Screening::factory()->create([
                'movie_id' => $movie2->id,
                'start_time' => $today->copy()->setTime(12, 0, 0),
                'end_time' => $today->copy()->setTime(14, 0, 0),
            ]);

            $yesterday = $now->copy()->subDays(1);
            $screening3 = Screening::factory()->create([
                'movie_id' => $movie3->id,
                'start_time' => $yesterday->copy()->setTime(15, 0, 0),
                'end_time' => $yesterday->copy()->setTime(17, 0, 0),
            ]);

            $rows = ['A', 'B']; // 行
            $seatsPerRow = 10;       // 1行あたりの席数
            $screening_ids = [$screening1->id, $screening2->id, $screening3->id];

            foreach ($screening_ids as $screening_id) {
                $seats = [];

                foreach ($rows as $row) {
                    for ($number = 1; $number <= $seatsPerRow; $number++) {
                        $seats[] = [
                            'screening_id' => $screening_id,
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

            // Userモデルからランダムにユーザーを5人取得
            $randomUsers = User::inRandomOrder()->limit(5)->get();

            // 予約済みの座席を生成
            $seats = Seat::inRandomOrder()->limit(5)->get();
            foreach ($seats as $seat) {
                $user = $randomUsers->shift(); // 配列から先頭の要素を取り出す
                $seat->update([
                    'user_id' => $user->id,
                    'is_reserved' => true,
                ]);
            }

            $testUser = User::factory()->create([
                'name' => 'テストユーザー',
                'email' => env('TEST_USER_EMAIL', 'test@gmail.com'),
                'password' => Hash::make(env('TEST_USER_PASSWORD', '1111aaaa')),
            ]);
            
        }
    }
}
