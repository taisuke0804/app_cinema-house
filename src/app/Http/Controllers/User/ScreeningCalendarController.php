<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Screening;

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
                // 'url' => route('admin.screenings.show', $screening),
            ];
        });

        $events = $screenings->toArray();

        return response()->json($events);
    }
}
