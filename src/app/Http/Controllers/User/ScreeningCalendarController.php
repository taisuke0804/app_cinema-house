<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Screening;
use App\Models\Seat;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\ScreeningService;

class ScreeningCalendarController extends Controller
{
    private $screeningService;

    public function __construct(ScreeningService $screeningService)
    {
        $this->screeningService = $screeningService;
    }

    /**
     * カレンダー表示ページ.
     */
    public function index()
    {
        return view('user.screenings.calendar');
    }

    /**
     * カレンダー上映スケジュールデータを取得するAPI
     */
    public function events(Request $request)
    {
        // リクエストパラメータから年月を取得
        $year = $request->input('year');
        $month = $request->input('month');

        $events = $this->screeningService->getCalendarEvents('web', $year, $month);

        return response()->json($events);
    }

    /**
     * 上映スケジュールの詳細情報を表示するページ
     */
    public function show(Screening $screening)
    {
        $screeningDetails = $this->screeningService->getScreeningDetails($screening);
        $seatRows = $this->screeningService->getScreeningSeats($screening, 'web');

        // ログインユーザーの予約済み座席情報を取得
        // 詳細画面全体で使用するため、ここで取得
        $authReservedSeatInfo = $this->screeningService->getAuthReservedSeatInfo($screening);
        
        return view('user.screenings.show')->with([
            'screening' => $screeningDetails,
            'authReservedSeatInfo' => $authReservedSeatInfo,
            'seatRows' => $seatRows,
        ]);
    }

    public function test()
    {
        return view('user.screenings.test');
    }
}
