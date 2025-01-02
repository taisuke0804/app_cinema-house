<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DevelopmentSeeder extends Seeder
{
    
    public function run(): void
    {
        Admin::factory()->create([
            'name' => '管理者太郎',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin1234'),
            'remember_token' => Str::random(10),
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->count(50)->create();

        $this->call([
            MovieSeeder::class,
            ScreeningSeeder::class,
            SeatSeeder::class,
        ]);

        $this->call(SampleDataSeeder::class);
    }
}
