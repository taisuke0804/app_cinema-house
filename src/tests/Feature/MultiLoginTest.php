<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MultiLoginTest extends TestCase
{
    use RefreshDatabase;

    private function user_login(): User
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@gmail.com',
            'password' => Hash::make('password1234'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password1234',
        ])->assertRedirectToRoute('home');
        $this->assertAuthenticatedAs($user, 'web');
        return $user;
    }

    private function admin_login(): Admin
    {
        $admin = Admin::factory()->create([
            'name' => '管理者テスト',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1234'),
        ]);

        $this->post(route('admin.login.post'), [
            'email' => $admin->email,
            'password' => 'admin1234',
        ])->assertRedirectToRoute('admin.index');
        $this->assertAuthenticatedAs($admin, 'admin');
        return $admin;
    }

    /**
     * AdminとUserが別々にログインできることを確認するテスト。
     * また、Adminがログアウトした後でもUserがログイン状態を維持していることを確認。
     */
    public function test_admin_and_user_can_login_separately(): void
    {
        $admin = $this->admin_login();
        $user = $this->user_login();

        $this->post(route('admin.logout'));

        $this->assertGuest('admin');
        $this->assertAuthenticatedAs($user, 'web');
    }

    /**
     * UserとAdminが別々にログインできることを確認するテスト。
     * また、Userがログアウトした後でもAdminがログイン状態を維持していることを確認します。
     */
    public function test_user_and_admin_can_login_separately(): void
    {
        $user = $this->user_login();
        $admin = $this->admin_login();

        $this->post(route('logout'));

        $this->assertGuest('web');
        $this->assertAuthenticatedAs($admin, 'admin');
    }
}
