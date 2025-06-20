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

            $movie4 = Movie::factory()->create([
                'title' => 'となりのトトロ',
                'description' => '物語の舞台は昭和30年代。大学で考古学を研究する学者のお父さん、小学6年生のサツキ、4歳のメイの3人が引っ越してきたのは、豊かな自然と美しい四季があふれる田舎の、「お化け屋敷」のような一軒家。しかし本当に出たんです…… トトロが。',
                'genre' => 99,
            ]);

            $movie5 = Movie::factory()->create([
                'title' => '君の名は。',
                'description' => '東京に暮らす少年・瀧（たき）と飛騨地方の山深い田舎町で暮らす少女・三葉（みつは）の身に起きた「入れ替わり」という謎の現象と、1200年ぶりに地球に接近するという「ティアマト彗星」をめぐる出来事を描く。',
                'genre' => 99,
            ]);

            $movie6 = Movie::factory()->create([
                'title' => 'ターミネーター2',
                'description' => '最初のターミネーター出現から10年後。サラ・コナーの息子ジョンは少年に成長。ジョンは、近未来に人類抵抗軍のリーダーだ。機械軍はジョンを少年のうちに殺すため、新しいターミネーターを送り込む。ある日ロサンゼルスに2体のターミネーターが未来から送り込まれる。息子を守るために、サラの死闘が始まる。だが、残忍非道なターミネーターに立ち向かうサラとジョン母子に、強い味方が現れる。いかなる犠牲を払ってもジョンを守れと厳命を受け、人類抵抗軍によって送り込まれた戦士だ。未来への戦いが、いま始まる……',
                'genre' => 99,
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

            $daysLater10 = $now->copy()->addDays(10);
            $screening4 = Screening::factory()->create([
                'movie_id' => $movie4->id,
                'start_time' => $daysLater10->copy()->setTime(9, 0, 0),
                'end_time' => $daysLater10->copy()->setTime(11, 0, 0),
            ]);

            $daysLater20 = $now->copy()->addDays(20);
            $screening5 = Screening::factory()->create([
                'movie_id' => $movie5->id,
                'start_time' => $daysLater20->copy()->setTime(9, 0, 0),
                'end_time' => $daysLater20->copy()->setTime(11, 0, 0),
            ]);

            $daysAgo = $now->copy()->subDays(15);
            $screening6 = Screening::factory()->create([
                'movie_id' => $movie6->id,
                'start_time' => $daysAgo->copy()->setTime(9, 0, 0),
                'end_time' => $daysAgo->copy()->setTime(11, 0, 0),
            ]);

            $rows = ['A', 'B']; // 行
            $seatsPerRow = 10;       // 1行あたりの席数
            $screening_ids = [$screening1->id, $screening2->id, $screening3->id, $screening4->id, $screening5->id, $screening6->id];

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
