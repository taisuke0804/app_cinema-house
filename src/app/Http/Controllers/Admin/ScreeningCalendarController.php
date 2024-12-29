<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScreeningCalendarController extends Controller
{
    /**
     * カレンダー表示ページ.
     */
    public function index()
    {
        return view('admin.screenings.calendar');
    }
}
