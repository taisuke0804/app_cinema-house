<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;

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
        // リクエストバリデーションと認証を実行
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('admin.index'));
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
