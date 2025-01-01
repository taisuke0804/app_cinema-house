<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Seat;
use Illuminate\Support\Facades\Validator;

class SeatController extends Controller
{
    /**
     * 座席を予約する処理
     */
    public function reserve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row' => ['required', 'string', Rule::in(['A', 'B']), 'max:1'],
            'number' => ['required', 'integer', 'between:1,10'],
            'screening_id' => ['required', 'integer', 'exists:screenings,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $validated = $validator->validate();

        // 同一のuser_idで予約済みか確認
        $reservedSeat = Seat::where('screening_id', $validated['screening_id'])
            ->where('user_id', $validated['user_id'])
            ->first();
        if ($reservedSeat) {
            $validator->errors()->add('seat', 'お客様はすでに予約済みです。');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // すでに予約済みか確認
        $seat = Seat::where('screening_id', $validated['screening_id'])
            ->where('row', $validated['row'])
            ->where('number', $validated['number'])
            ->first();

        if ($seat) {
            if ($seat->is_reserved) {
                $validator->errors()->add('seat', '選択された座席はすでに予約済みです。');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $seat->user_id = $validated['user_id'];
            $seat->is_reserved = true;
            $seat->save();
        } else {
            Seat::create([
                'row' => $validated['row'],
                'number' => $validated['number'],
                'screening_id' => $validated['screening_id'],
                'user_id' => $validated['user_id'],
                'is_reserved' => true,
            ]);
        }

        // 成功した場合、完了画面にリダイレクト
        return redirect()->route('user.seat.reserve.completed')
            ->with('success', '座席予約が完了しました！');
    }

    public function completed()
    {
        $successMessage = session('success', 'ありがとうございます');
        return view('user.seat.reserve_completed', compact('successMessage'));
    }

    /**
     * 座席予約をキャンセルする処理
     */
    public function cancel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seat_id' => ['required', 'integer', 'exists:seats,id'],
            'screening_id' => ['required', 'integer', 'exists:screenings,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'row' => ['required', 'string', Rule::in(['A', 'B']), 'max:1'],
            'number' => ['required', 'integer', 'between:1,10'],
        ]);
        
        $validated = $validator->validate();
        
        $seat = Seat::where('id', $validated['seat_id'])
        ->where('screening_id', $validated['screening_id'])
        ->where('user_id', $validated['user_id'])
        ->where('row', $validated['row'])
        ->where('number', $validated['number'])
        ->first();
        
        if ($seat) {
            $seat->user_id = null;
            $seat->is_reserved = false;
            $seat->save();
        }

        return redirect()->route('home')
            ->with('success', '座席予約をキャンセルしました');
    }
}
