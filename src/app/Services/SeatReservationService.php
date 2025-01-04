<?php

namespace App\Services;

use App\Models\Seat;
use Illuminate\Support\Facades\Validator;

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
    
}