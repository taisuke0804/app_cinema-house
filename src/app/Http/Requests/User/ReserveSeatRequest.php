<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use App\Models\Seat;

class ReserveSeatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'row' => ['required', 'string', Rule::in(['A', 'B']), 'max:1'],
            'number' => ['required', 'integer', 'between:1,10'],
            'screening_id' => ['required', 'integer', 'exists:screenings,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            // バリデーションエラーがある場合は処理を中断
            if ($validator->stopOnFirstFailure()->failed()) {
                return;
            }

            // $screening_idにログインユーザーがすでに予約済みかチェック
            $authUserReservedSeat = Seat::where('screening_id', $this->screening_id)
                ->where('user_id', $this->user_id)
                ->where('is_reserved', true)
                ->first();
            if ($authUserReservedSeat) {
                $validator->errors()->add('seat', 'お客様はすでに予約済みです。');
                return;
            }

            // 他のユーザーがすでに予約済みかチェック
            $seat = Seat::where('screening_id', $this->screening_id)
                ->where('row', $this->row)
                ->where('number', $this->number)
                ->first();
            if ($seat && $seat->is_reserved) {
                $validator->errors()->add('seat', '選択された座席はすでに予約済みです。');
                return;
            }
        });
    }
}
