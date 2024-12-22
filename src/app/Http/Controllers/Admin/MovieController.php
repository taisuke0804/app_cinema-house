<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::select('title', 'description', 'release_date')->paginate(10);
        
        dump($movies);
        return view('admin.movies.index')->with(['movies' => $movies]);
    }
}
