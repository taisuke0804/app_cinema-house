<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ReserveSeatRequest;
use Illuminate\Http\RedirectResponse;
use App\Services\SeatReservationService;
use App\Http\Requests\User\CancelSeatRequest;
use Illuminate\Support\Facades\Auth;

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
    public function cancel(CancelSeatRequest $request)
    {
        $validated = $request->validated();
        $this->seatReservationService->cancelSeat($validated);

        return redirect()->route('home')
            ->with('success', '座席予約をキャンセルしました');
    }

    /**
     * 予約した座席の一覧を表示
     */
    public function reserveList()
    {
        $authReserveList = $this->seatReservationService->getReserveList(Auth::id());
        // dd($authReserveList, '予約した座席の一覧を表示');
        return view('user.seat.reserve_list')->with('authReserveList', $authReserveList);
        // dump('予約した座席の一覧を表示');
    }
}
