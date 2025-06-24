<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * ユーザー一覧表示
     */
    public function index()
    {
        return view('admin.users.index');
    }
}
