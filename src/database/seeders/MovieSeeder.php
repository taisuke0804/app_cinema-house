<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movie::factory()->create([
            'title' => 'ハリーポッターと賢者の石',
            'description' => 'ハリー・ポッターは、魔法使いの世界で有名な一家の子供である。彼は、両親が魔法使いの世界で殺された後、叔父夫婦のもとで育てられていた。しかし、11歳の誕生日に、ホグワーツ魔法学校に入学することができることがわかり、そこで新しい友達と出会い、新しい世界を知る。',
            'genre' => 1,
        ]);

        Movie::factory()->create([
            'title' => 'ハリーポッターと秘密の部屋',
            'description' => 'ハリー・ポッターは、ホグワーツ魔法学校での2年目を迎える。しかし、学校には謎の怪物が現れ、生徒たちが次々と石になってしまう事件が起こる。ハリーは、この事件の真相を解明するために、秘密の部屋に潜入する。',
            'genre' => 1,
        ]);

        Movie::factory()->create([
            'title' => 'ハリーポッターとアズカバンの囚人',
            'description' => 'ハリー・ポッターは、ホグワーツ魔法学校での3年目を迎える。しかし、アズカバン刑務所から脱獄した囚人がホグワーツに迫っているという噂が広まる。ハリーは、囚人の正体を知るために、過去の真実を追求する。',
            'genre' => 3,
        ]);

        Movie::factory()->count(50)->create();
    }
}
