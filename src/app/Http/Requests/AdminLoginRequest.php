<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * リクエストに含まれる認証情報を使用して管理者ユーザーを認証します
     * 
     * 認証に失敗した場合、ValidationException をスロー
     */
    public function authenticate(): void
    {
        // 管理者adminとして認証資格があるかどうかをチェックし認証
        if (!Auth::guard('admin')->attempt($this->only('email', 'password'))) {
            throw ValidationException::withMessages(['failed' => __('auth.failed')]);
        }
    }
}
