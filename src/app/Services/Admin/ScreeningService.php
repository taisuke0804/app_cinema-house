<?php

namespace App\Services\Admin;

use App\Models\Screening;
use Carbon\Carbon;

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
    public function getCalendarEvents(?int $year, ?int $month): array
    {
        $screenings = Screening::with('movie')
            ->select('id', 'movie_id', 'start_time', 'end_time')
            ->get();
        
        $events = $screenings->map(function ($screening) {
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
    public function getScreeningSeats(Screening $screening): array
    {
        $seatRows = [];
        foreach (range('A', 'B') as $row) {
            $seats = [];
            foreach (range(1, 10) as $number) {
                $seat = $screening->seats->whereStrict('row', $row)->whereStrict('number', $number)->first();
                $seats[] = [
                    'label' => $row . strval($number),
                    'is_reserved' => $seat->is_reserved ?? false,
                ];
            }
            $seatRows[$row] = $seats;
        }

        return $seatRows;
    }
}