<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    /**
     * ユーザー一覧表示
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index')->with(['users' => $users]);
    }

    public function create()
    {
        return view('admin.users.create');
    }
}
