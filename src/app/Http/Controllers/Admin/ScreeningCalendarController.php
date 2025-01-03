<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Screening;
use Illuminate\View\View;
use App\Models\Movie;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\StoreScreeningRequest;

class ScreeningCalendarController extends Controller
{
    /**
     * カレンダー表示ページ.
     */
    public function index(): View
    {
        return view('admin.screenings.calendar');
    }

    /**
     * 上映スケジュールの新規登録画面を表示
     */
    public function create($movie_id): View
    {
        $movie = Movie::findOrFail($movie_id);
        return view('admin.screenings.create')->with('movie', $movie);
    }

    /**
     * 上映スケジュールの新規登録処理
     */
    public function store(StoreScreeningRequest $request)
    {
        $validated = $request->only('movie_id', 'start_time', 'end_time');
        dump('test');
        dd($validated);

        Screening::create([
            'movie_id' => $validated['movie_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);
        
        return redirect()->route('admin.screenings.calendar.index')->with('success', '上映スケジュールを登録しました。');
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
                'url' => route('admin.screenings.show', $screening),
            ];
        });

        $events = $screenings->toArray();

        return response()->json($events);
    }

    /**
     * 上映スケジュールの詳細情報を表示するページ
     */
    public function show(Screening $screening): View
    {
        $screening = Screening::with([
            'movie:id,title,genre',
            'seats:id,screening_id,row,number,is_reserved',
        ])->select('id', 'movie_id', 'start_time', 'end_time')
        ->findOrFail($screening->id);
        
        return view('admin.screenings.show')->with('screening', $screening);
    }
}
