<?php

namespace App\Services;

use App\Models\Seat;

class SeatReservationService
{
    public function getSeatInfo(array $reservationData)
    {
        $seat = Seat::where('screening_id', $reservationData['screening_id'])
        ->where('row', $reservationData['row'])
        ->where('number', $reservationData['number'])
        ->first();
        
        return $seat;
    }

    public function reserveSeat(array $reservationData): void
    {
        $seat = $this->getSeatInfo($reservationData);

        if ($seat) {
            $seat->user_id = $reservationData['user_id'];
            $seat->is_reserved = true;
            $seat->save();
        } else {
            Seat::create([
                'row' => $reservationData['row'],
                'number' => $reservationData['number'],
                'screening_id' => $reservationData['screening_id'],
                'user_id' => $reservationData['user_id'],
                'is_reserved' => true,
            ]);
        }
    }
    
    /**
     * 座席予約をキャンセルする処理
     */
    public function cancelSeat(array $reservationData): void
    {
        $seat = Seat::where('id', $reservationData['seat_id'])
        ->where('screening_id', $reservationData['screening_id'])
        ->where('user_id', $reservationData['user_id'])
        ->where('row', $reservationData['row'])
        ->where('number', $reservationData['number'])
        ->first();
        
        if ($seat) {
            $seat->user_id = null;
            $seat->is_reserved = false;
            $seat->save();
        }
    }

    /**
     * ログインしたユーザーの予約した座席の一覧を取得
     */
    public function getReserveList(int $userId): object
    {
        // dd($userId);
        $today = \Carbon\Carbon::today();
        $authReserveList = Seat::with([
            'screening:id,start_time,end_time,movie_id',
            'screening.movie:id,title'
        ])
        ->select('seats.id', 'seats.screening_id', 'seats.row', 'seats.number', 'seats.is_reserved')
        ->join('screenings', 'seats.screening_id', '=', 'screenings.id') // screeningテーブルと結合
        ->where('seats.user_id', $userId)
        ->where('seats.is_reserved', true)
        ->where('screenings.start_time', '>=', $today) // 今日以降の予約情報
        ->orderBy('screenings.start_time', 'asc') // start_timeでソート
        ->get();
            // dd($authReserveList);
        return $authReserveList;
    }
}