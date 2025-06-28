<?php
namespace App\Services\Admin;

use App\Models\User;

class UserService
{
    public function userStore(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}