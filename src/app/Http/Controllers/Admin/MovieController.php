<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use App\Enums\Genre;

class MovieController extends Controller
{
    /**
     * 映画の一覧を表示
     */
    public function index(): View
    {
        $movies = Movie::select('title', 'description', 'genre')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.movies.index')->with(['movies' => $movies]);
    }

    /**
     * 映画の新規登録画面を表示
     */
    public function create(): View
    {
        return view('admin.movies.create');
    }

    /**
     * 映画の新規登録処理
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'genre' => ['required', 'integer', Rule::in(Genre::values())],
            'description' => ['required', 'string', 'max:1000'],
        ]);

        Movie::create($validated);

        return redirect()->route('admin.movies.index')->with('success', '映画の新規登録が完了しました');
    }
}
