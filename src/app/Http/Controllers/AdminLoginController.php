<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\TwoFactorAuthService;
use Illuminate\Http\RedirectResponse;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        // 管理者が未ログインかどうかチェック
        $this->middleware('guest:admin')->except('logout');

        // 管理者が認証済み状態かチェック
        $this->middleware('auth:admin')->only('logout');
    }

    /**
     * 管理者ログイン画面を表示する
     */
    public function showLoginForm(): View
    {
        return view('admin.login');
    }

    /**
     * 管理者ログインの認証処理
     */
     public function login(AdminLoginRequest $request)
     {
        // 2段階認証が有効かどうかをチェック
        if (env('ADMIN_TFA', false) === true) {
            return $this->twoFactorAuth($request); // 2段階認証処理を実行
        }
        
        // リクエストバリデーションと認証を実行
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('admin.index'));
     }

    /**
    * 2段階認証処理・1回目の認証処理
    */
    public function twoFactorAuth(AdminLoginRequest $request): View
    {
        $credentials = $request->only('email', 'password');
        $twoFactorAuthService = new TwoFactorAuthService();
        $twoFactorAuthService->twoFactorAuthFirstProcess($credentials);
        return view('admin.firstAuthcompleted');
    }

    /**
     * 2段階認証・2回目のログイン画面を表示
     */
    public function showSecondLogin(Request $request): View
    {
        // hasValidSignature()メソッド・・・リクエストの署名が有効かどうかをチェック
        if (! $request->hasValidSignature()) {
            abort(401);
        }
        return view('admin.secondLoginForm');
    }

    /**
     * 2段階認証・ワンタイムパスワードの認証処理
     */
    public function secondAuth(Request $request): RedirectResponse
    {
        $request->validate([
            'tfa_token' => ['required', 'numeric'],
            'email' => ['required', 'email', 'exists:admins,email'],
        ]);
        $twoFactorAuthService = new TwoFactorAuthService();
        $twoFactorAuthService->twoFactorAuthSecondProcess($request->email, $request->tfa_token);
        // ログイン成功後、管理者トップページへリダイレクト
        if (Auth::guard('admin')->check()) {
            return redirect()->intended(route('admin.index'));
        }
    }

     /**
      * 管理者ログアウト処理
      */
     public function logout(Request $request)
     {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('admin.login');
     }
}
