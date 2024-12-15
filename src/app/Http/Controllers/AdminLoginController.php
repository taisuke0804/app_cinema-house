<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    /**
     * 管理者ログイン画面を表示する
     */
    public function showLoginForm(): View
    {
        return view('admin.login');
    }
}
