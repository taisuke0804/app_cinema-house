<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorAuthOnetimePass;
use Illuminate\Support\Facades\URL;

class TwoFactorAuthTest extends TestCase
{
    use RefreshDatabase;

    private function admin_create(): Admin
    {
        return Admin::factory()->create([
            'name' => '管理者太郎',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1234'),
        ]);
    }

    /**
     * 2段階認証が有効かどうかをチェック
     */
    public function test_two_factor_auth_enabled_using_env(): void
    {
        if (env('ADMIN_TFA', false) === false) return;

        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
        $admin = $this->admin_create();

        $this->post(route('admin.login.post'), [
            'email' => $admin->email,
            'password' => 'admin1234',
        ]);
        $response->assertOk();
    }

    /**
     * 2段階認証コードadminsテーブルに保存されているかチェック
     */
    public function test_tfa_token_is_saved_in_admin_table(): void
    {
        $admin = $this->admin_create();
        $this->assertDatabaseHas('admins', [
            'tfa_token' => null,
        ]);
        
        $this->post(route('admin.login.post'), [
            'email' => $admin->email,
            'password' => 'admin1234',
        ]);
        
        $this->assertDatabaseMissing('admins', [
            'tfa_token' => null, // 2段階認証コードが保存されているか
        ]);
    }

    /**
     * 2段階認証コードがメールで管理者メールアドレスに送信されるかチェック
     */
    public function test_two_factor_auth_email_is_sent(): void
    {
        Mail::fake();
        $admin = $this->admin_create();
        $this->post(route('admin.login.post'), [
            'email' => $admin->email,
            'password' => 'admin1234',
        ]);

        $tfa_token = Admin::where('email', $admin->email)->first()->tfa_token;

        Mail::assertSent(TwoFactorAuthOnetimePass::class, function (TwoFactorAuthOnetimePass $mail) use ($admin, $tfa_token) {
            
            $url = $mail->signedUrl;
            $randomPassword = $mail->randomPassword;

            // URLに署名が含まれているか
            $this->assertStringContainsString('/admin/login/second', $url); 
            // ランダムパスワードがDBに保存されたハッシュと一致するか
            $this->assertTrue(Hash::check($randomPassword, $tfa_token)); 

            return $mail->hasTo($admin->email) &&
                   $mail->hasSubject('2段階認証コードのお知らせ') &&
                   $mail->hasFrom('hello@example.com', 'CINEMA-HOUSE') &&
                   $mail->assertSeeInHtml($admin->tfa_token) &&
                   $mail->assertSeeInHtml($url);
        });
    }

    /**
     * 有効な署名付きURLとパスワードで2段階認証が成功することをテスト
     */
    public function test_two_factor_auth_verifies_with_valid_signed_url(): void
    {
        Mail::fake();
        $admin = $this->admin_create();
        $this->post(route('admin.login.post'), [
            'email' => $admin->email,
            'password' => 'admin1234',
        ]);
        
        $signedUrl = null;
        $randomPassword = null;
        // 署名付きURLとランダムパスワードを参照渡しで変数に格納
        Mail::assertSent(TwoFactorAuthOnetimePass::class, function (TwoFactorAuthOnetimePass $mail) use ($admin, &$signedUrl, &$randomPassword) {
            
            $signedUrl = $mail->signedUrl;
            $randomPassword = $mail->randomPassword;
            return true;
        });
        
        $response = $this->get($signedUrl);
        $response->assertStatus(200);
        
        $response = $this->post(route('admin.secondAuth'), [
            'email' => $admin->email,
            'tfa_token' => $randomPassword,
        ]);

        $response->assertRedirect(route('admin.index'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    /**
     * 有効期限切れの署名付きURLにアクセスした場合、エラーが返されることをテスト
     */
    public function test_signed_url_fails_after_expiry(): void
    {
        Mail::fake();
        $admin = $this->admin_create();
        $this->post(route('admin.login.post'), [
            'email' => $admin->email,
            'password' => 'admin1234',
        ]);
        
        $signedUrl = null;
        $randomPassword = null;
        Mail::assertSent(TwoFactorAuthOnetimePass::class, function (TwoFactorAuthOnetimePass $mail) use ($admin, &$signedUrl, &$randomPassword) {
            
            $signedUrl = $mail->signedUrl;
            $randomPassword = $mail->randomPassword;
            return true;
        });

        $this->travel(5)->minutes();
        $this->travel(1)->seconds();
        
        // 5分後に署名付きURLをアクセス
        $response = $this->get($signedUrl);
        $response->assertStatus(401); //署名付きURLが有効期限切れのためエラー
        
    }
}
