<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Screening;
use Illuminate\View\View;
use App\Models\Movie;
use App\Services\Admin\ScreeningService;
use App\Http\Requests\Admin\StoreScreeningRequest;

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

        $this->screeningService->storeScreening($validated);
        
        return redirect()->route('admin.screenings.calendar.index')->with('success', '上映スケジュールを登録しました。');
    }

    /**
     * カレンダー上映スケジュールデータを取得するAPI
     */
    public function events(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        $events = $this->screeningService->getCalendarEvents($year, $month);
        return response()->json($events);
    }

    /**
     * 上映スケジュールの詳細情報を表示するページ
     */
    public function show(Screening $screening): View
    {
        $screeningDetails = $this->screeningService->getScreeningDetails($screening);
        $searRows = $this->screeningService->getScreeningSeats($screening);
        
        return view('admin.screenings.show')->with([
            'screening' => $screeningDetails,
            'seatRows' => $searRows,
        ]);
    }
}
