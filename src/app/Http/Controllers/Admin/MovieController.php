<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\Admin\MovieService;
use App\Http\Requests\Admin\StoreMovieRequest;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        // MovieServiceクラスのインスタンスを生成
        $this->movieService = $movieService;
    }

    /**
     * 映画の一覧を表示
     */
    public function index(): View
    {
        $movies = $this->movieService->getMovies();
        
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
    public function store(StoreMovieRequest $request): RedirectResponse
    {
        $this->movieService->storeMovie($request->validated());

        return redirect()->route('admin.movies.index')->with('success', '映画の新規登録が完了しました');
    }

    /**
     * 映画の詳細を表示
     */
    public function show($id): View
    {
        $movie = $this->movieService->getMovieById($id);

        return view('admin.movies.show')->with(['movie' => $movie]);
    }

    /**
     * 映画情報の削除処理
     */
    public function destroy(int $movie_id)
    {
        dd($movie_id);
    }
}
