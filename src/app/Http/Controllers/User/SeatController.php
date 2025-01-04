<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\ReserveSeatRequest;
use App\Models\Seat;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use App\Services\SeatReservationService;
use Illuminate\Validation\Rule;

class SeatController extends Controller
{
    private $seatReservationService;

    public function __construct(SeatReservationService $seatReservationService)
    {
        $this->seatReservationService = $seatReservationService;
    }

    /**
     * 座席を予約する処理
     */
    public function reserve(ReserveSeatRequest $request): RedirectResponse
    {
        $reservationData = $request->validated(); // バリデーション済みのデータを取得
        $this->seatReservationService->reserveSeat($reservationData); // 座席予約処理を呼び出し

        // 成功した場合、完了画面にリダイレクト
        return redirect()->route('user.seat.reserve.completed')
            ->with('success', '座席予約が完了しました！');
    }

    /**
     * 座席予約完了画面
     */
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
