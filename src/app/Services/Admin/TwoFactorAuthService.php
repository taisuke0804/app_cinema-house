<?php

namespace App\Services\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

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
            $loginLimitTime = now()->addMinutes(5); 
            $admin = Admin::where('email', $credentials['email'])->first();
            $admin->tfa_token = Hash::make($randomPassword);
            $admin = $admin->save();
            
            $signedUrl = URL::temporarySignedRoute(
                'admin.secondLogin', $loginLimitTime, 
                ['email' => $credentials['email']]
            );

            // メール送信処理 後ほど実装
            
        } else {
            throw ValidationException::withMessages(['failed' => __('auth.failed')]);
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
