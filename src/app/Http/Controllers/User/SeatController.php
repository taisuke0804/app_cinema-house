<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    /**
     * 座席を予約する処理
     */
    public function reserve(Request $request)
    {
        dump($request->all());
    }
}
