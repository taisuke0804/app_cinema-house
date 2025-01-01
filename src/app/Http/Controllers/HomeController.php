<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Seat;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ユーザーの予約一覧を表示するページ.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $reservations = Seat::with([
                'screening:id,start_time,end_time,movie_id',
                'screening.movie:id,title'
            ])
            ->select('seats.id', 'seats.screening_id', 'seats.row', 'seats.number', 'seats.is_reserved')
            ->join('screenings', 'seats.screening_id', '=', 'screenings.id') // screeningテーブルと結合
            ->where('seats.user_id', $user->id)
            ->where('seats.is_reserved', true)
            ->orderBy('screenings.start_time', 'asc') // start_timeでソート
            ->get();

        return view('home.index')->with('reservations', $reservations);
    }
}
