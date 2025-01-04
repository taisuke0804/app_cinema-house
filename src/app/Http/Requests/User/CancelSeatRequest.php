<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CancelSeatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'seat_id' => ['required', 'integer', 'exists:seats,id'],
            'screening_id' => ['required', 'integer', 'exists:screenings,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'row' => ['required', 'string', Rule::in(['A', 'B']), 'max:1'],
            'number' => ['required', 'integer', 'between:1,10'],
        ];
    }
}
