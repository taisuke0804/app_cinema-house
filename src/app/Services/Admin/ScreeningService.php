<?php

namespace App\Services\Admin;

use App\Models\Screening;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Seat;
use Illuminate\Support\Facades\DB;

class ScreeningService
{
    /**
     * 上映スケジュールの新規登録
     */
    public function storeScreening(array $validated): void
    {
        Screening::create($validated);
    }

    /**
     * カレンダー表示用の上映スケジュールデータを取得
     */
    public function getCalendarEvents(string $guard, $year = null, $month = null): array
    {
        $screenings = Screening::with('movie')
            ->select('id', 'movie_id', 'start_time', 'end_time')
            ->get();

        $route = $guard === 'web' ? 'user.screenings.show' : 'admin.screenings.show';
        
        $events = $screenings->map(function ($screening) use ($route) {
            return [
                'id' => $screening->id,
                'title' => $screening->movie->title,
                'start' => $screening->start_time->format('Y-m-d'),
                'end' => $screening->end_time->format('Y-m-d'),
                'start_time' => $screening->start_time->format('H:i'),
                'end_time' => $screening->end_time->format('H:i'),
                'url' => route($route, $screening),
            ];
        });

        return $events->toArray();
    }

    /**
     * 上映スケジュールの詳細情報を取得
     */
    public function getScreeningDetails(Screening $screening): Screening
    {
        $screeningDetails = Screening::with([
            'movie:id,title,genre',
            'seats:id,screening_id,row,number,is_reserved',
        ])
        ->select('id', 'movie_id', 'start_time', 'end_time')
        ->findOrFail($screening->id);

        return $screeningDetails;
    }

    /**
     * 上映スケジュールの座席予約状況を取得
     */
    public function getScreeningSeats(Screening $screening, string $guard): array
    {
        $seatRows = [];
        $authId = (int)Auth::guard('web')->id();
        $screeningId = (int)$screening->id;
        
        $seats = DB::table('seats')
            ->select('id', 'screening_id','user_id', 'row', 'number', 'is_reserved',
            DB::raw("CASE user_id WHEN {$authId} THEN TRUE ELSE FALSE END AS auth_reserved")
            )
            ->where('screening_id', $screeningId)
            ->orderBy('row')
            ->orderBy('number')
            ->get()
            ->groupBy('row');

        $seatRows = $seats->toArray(); // 列ごとにグループ化

        return $seatRows;
    }

    /**
     * ログインユーザーの予約済み座席情報を取得
     * 詳細画面全体で使用するためのメソッド
     */
    public function getAuthReservedSeatInfo(Screening $screening): ?object
    {
        $authReservedSeatInfo = Seat::where('screening_id', $screening->id)
            ->where('user_id', Auth::guard('web')->id())
            ->where('is_reserved', true)
            ->first();

        return $authReservedSeatInfo;
    }
}