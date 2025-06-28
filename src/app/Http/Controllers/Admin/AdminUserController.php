<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Services\Admin\UserService;

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

    public function store(StoreUserRequest $request, UserService $userService)
    {
        $validated = $request->validated();
        
        $userService->userStore($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'ユーザーを登録しました。');
    }
}
