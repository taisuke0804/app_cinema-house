<?php

namespace App\Services\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorAuthOnetimePass;

class TwoFactorAuthService
{
    /**
     * 2段階認証処理で署名付きログインURLを生成しメールで管理者に送信
     * temporarySignedRoute()メソッド・・・時間制限付きの署名付きURLを生成
     */
    public function twoFactorAuthFirstProcess($credentials): void
    {
        if (Auth::guard('admin')->validate($credentials)) {
            $randomPassword = $this->generateCode();
            $loginLimitTime = now()->addMinutes(5); // 5分間の有効期限
            $admin = Admin::where('email', $credentials['email'])->first();
            $admin->tfa_token = Hash::make($randomPassword);
            $admin = $admin->save();
            
            $signedUrl = URL::temporarySignedRoute(
                'admin.secondLogin', $loginLimitTime, 
                ['email' => $credentials['email']]
            );

            // 2段階認証コードをメールで送信
            \Mail::to($credentials['email'])->send(new TwoFactorAuthOnetimePass(
                $randomPassword, $signedUrl
            ));
            
        } else {
            throw ValidationException::withMessages(['failed' => __('auth.failed')]);
        }
    }

    /**
     * 2段階認証処理の2回目の処理
     * Hash::check()メソッド・・・ハッシュ化された文字列が一致するかどうかを確認
     */
    public function twoFactorAuthSecondProcess($email, $tfaToken): void
    {
        $admin = Admin::where('email', $email)->first();
        
        if (Hash::check($tfaToken, $admin->tfa_token)) {
            $admin->tfa_token = null;
            $admin->save();
            Auth::guard('admin')->login($admin);
        } else {
            throw ValidationException::withMessages(['tfa_token' => '2段階認証コードが正しくありません']);
        }
    }

    /**
     * 2段階認証コードを生成
     * pow()関数・・・べき乗を計算する
     * random_int()関数・・・指定した範囲の乱数を生成する
     */
    private function generateCode($length = 4): string
    {
        $max = pow(10, $length) - 1;                    // コードの最大値算出, 4桁なら9999
        $rand = random_int(0, $max);                    // 0から最大値までの乱数生成
        $code = sprintf('%0'. $length. 'd', $rand);     // 指定桁数に0埋め

        return $code;
    }
}
