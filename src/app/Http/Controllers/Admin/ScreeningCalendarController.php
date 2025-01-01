<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Screening;
use Illuminate\View\View;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        $validated = $request->validate([
            'movie_id' => ['required', 'integer', 'exists:movies,id'],
            'date' => ['required', 'date', 'after_or_equal:tomorrow'],
            'start_hour' => ['required', 'integer', 'between:9,21'],
            'start_minute' => ['required', 'integer', 'between:0,59'],
            'end_hour' => ['required', 'integer', 'between:10,22'],
            'end_minute' => ['required', 'integer', 'between:0,59'],
        ]);

        // 日付情報を取得
        $selectedDate = $validated['date'];
        $movie_id = $validated['movie_id'];

        // バリデーション後処理
        $validator->after(function ($validator) use ($selectedDate, $movie_id) {
            // 同じ日付で既存のスケジュールがあるか確認
            $existingSchedule = Screening::whereDate('start_time', $selectedDate)
                ->where('movie_id', $movie_id)
                ->exists();

            if ($existingSchedule) {
                $validator->errors()->add('date', '同じ日付には上映スケジュールを登録することはできません。');
            }
        });

        $startDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $validated['date'] . ' ' . sprintf('%02d:%02d', $validated['start_hour'], $validated['start_minute'])
        );

        $endDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $validated['date'] . ' ' . sprintf('%02d:%02d', $validated['end_hour'], $validated['end_minute'])
        );

        // バリデーション後処理
        $validator->after(function ($validator) use ($startDateTime) {
            // 同じ開始時間で既存のスケジュールがあるか確認
            $existingSchedule = Screening::where('start_time', $startDateTime)->exists();

            if ($existingSchedule) {
                $validator->errors()->add('start_time', '同じ日時で上映スケジュールを登録することはできません。');
            }
        });

        
        $validator->after(function ($validator) use ($startDateTime, $endDateTime) {
            if ($startDateTime->gte($endDateTime)) {
                $validator->errors()->add('end_hour', '上映終了時刻は上映開始時刻より後にしてください。');
            }

            // 上映時間が重複しているかチェック
            $overlapping = Screening::where('start_time', '<', $endDateTime)
                ->where('end_time', '>', $startDateTime)
                ->exists();
            if ($overlapping) {
                $validator->errors()->add('start_hour', '上映時間が他の作品と重複しています。');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Screening::create([
            'movie_id' => $validated['movie_id'],
            'start_time' => $startDateTime,
            'end_time' => $endDateTime,
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
