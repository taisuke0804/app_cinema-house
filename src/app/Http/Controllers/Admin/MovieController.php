<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\View\View;

class MovieController extends Controller
{
    /**
     * 映画の一覧を表示
     */
    public function index(): View
    {
        $movies = Movie::select('title', 'description', 'genre')->paginate(10);
        
        return view('admin.movies.index')->with(['movies' => $movies]);
    }

    /**
     * 映画の新規登録画面を表示
     */
    public function create(): View
    {
        return view('admin.movies.create');
    }
}
