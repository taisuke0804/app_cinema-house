<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private function create_user(): User
    {
        $user = User::factory()->create([
            'name' => 'テスト',
            'email' => 'test@gmail.com',
            'password' => Hash::make('password1234'),
        ]);
        return $user;
    }

    public function test_example(): void
    {
        $response = $this->get('/');
        $user = $this->create_user();
        $response->assertStatus(200);
    }

    public function test_login_page_can_be_accessed(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('CINEMA-HOUSEのアカウントにログイン');
    }

    public function test_unauthenticated_user_is_redirected_loginform(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(302);
        $response->assertRedirectToRoute('login');
    }

    // 認証済みのユーザーがログインページに遷移するとリダイレクトされる
    public function test_authenticated_user_redirected_home(): void
    {
        $user = $this->create_user();
        $this->actingAs($user, 'web'); //認証済み状態にする

        $response = $this->get(route('login'));

        $response->assertRedirect(route('home'));
    }

    public function test_user_can_login(): void
    {
        $user = $this->create_user();
        
        $response = $this->post('/login', [
            'email' => 'test@gmail.com',
            'password' => 'password1234',
        ]);
        
        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user, 'web'); // 認証済みかどうかを確認
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        $user = $this->create_user();

        $response = $this
            ->from(route('login')) // 前の画面を指定（リファラーを定義）
            ->post('/login', [
                'email' => 'test@gmail.com',
                'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません',
        ]);
        $response->assertRedirectToRoute('login');
        $this->assertGuest('web'); // 認証されていないことを確認
    }

    public function test_login_fails_with_empty(): void
    {
        $response = $this->from(route('login'))->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスは必須です', 
            'password' => 'パスワードは必須です',
        ]);

        $response->assertRedirectToRoute('login');
        $this->assertGuest('web');
    }

    public function test_login_password_must_be_at_least_8_characters(): void
    {
        $response = $this->from(route('login'))->post('/login', [
            'email' => 'test@gmail.com',
            'password' => 'short',
        ]);

        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください']);
        $response->assertRedirectToRoute('login'); 
        $this->assertGuest(); // 認証されていないことを確認
    }

    public function test_user_is_logout_successfully(): void
    {
        $user = $this->create_user();
        $this->actingAs($user); // 認証済み状態にする

        $response = $this->from(route('home'))->post(route('logout'));
        $response->assertStatus(302);
        $response->assertRedirectToRoute('index');
        $this->assertGuest('web'); // 認証されていないことを確認
    }

    // 無効なメール形式の場合、ログインが失敗するテスト
    public function test_invalid_email_format_fails_login(): void
    {
        $response = $this->from(route('login'))->post('/login', [
            'email' => 'invalid-email-format', // 無効なメール形式
            'password' => 'password1234', 
        ]);
        $response->assertSessionHasErrors(['email' => 'メールアドレスには有効なEメールアドレスを指定する必要があります']);
        $response->assertRedirectToRoute('login'); 
        $this->assertGuest('web'); 
    }
}
