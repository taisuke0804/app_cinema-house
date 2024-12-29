<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.screenings.calendar');
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
            ];
        });

        $events = $screenings->toArray();

        return response()->json($events);
    }
}
