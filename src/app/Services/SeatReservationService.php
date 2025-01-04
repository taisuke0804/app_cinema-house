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
}