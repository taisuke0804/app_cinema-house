<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Screening;
use App\Models\Seat;
use Illuminate\Support\Facades\Auth;

class ScreeningCalendarController extends Controller
{
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

        $screenings = Screening::with('movie')
        ->select('id', 'movie_id', 'start_time', 'end_time')
        ->get()
        ->map(function ($screening) {
            return [
                'id' => $screening->id,
                'title' => $screening->movie->title,
                'start' => $screening->start_time->format('Y-m-d'),
                'end' => $screening->end_time->format('Y-m-d'),
                'start_time' => $screening->start_time->format('H:i'),
                'end_time' => $screening->end_time->format('H:i'),
                'url' => route('user.screenings.show', $screening),
            ];
        });

        $events = $screenings->toArray();

        return response()->json($events);
    }

    /**
     * 上映スケジュールの詳細情報を表示するページ
     */
    public function show(Screening $screening)
    {
        $screening = Screening::with([
            'movie:id,title,genre',
            'seats:id,screening_id,row,number,is_reserved',
        ])->select('id', 'movie_id', 'start_time', 'end_time')
        ->findOrFail($screening->id);

        // ログインユーザーが予約済みの座席を取得
        $authReservedSeat = Seat::where('screening_id', $screening->id)
            ->where('user_id', Auth::guard('web')->id())
            ->where('is_reserved', true)
            ->first();
        
        // ログインユーザーが予約済みかどうか
        $authAlreadyReserved = $authReservedSeat ? true : false;
        
        return view('user.screenings.show')->with([
            'screening' => $screening,
            'authAlreadyReserved' => $authAlreadyReserved,
            'authReservedSeat' => $authReservedSeat,
        ]);
    }
}
