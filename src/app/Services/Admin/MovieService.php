<?php

namespace App\Services\Admin;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieService
{
    /**
     * 映画の一覧を取得
     */
    public function getMovies(Request $request): object
    {
        $query = Movie::query();
        
        // 検索条件に一致する映画情報を取得
        $query = $this->searchMoviesQuery($query, $request);

        $movies = $query->select('id', 'title', 'description', 'genre')
            ->orderBy('created_at', 'desc')
            ->paginate(10)->withQueryString();
        
        return $movies;
    }

    /**
     * 映画の新規登録
     */
    public function storeMovie(array $validated): void
    {
        Movie::create($validated);
    }

    /**
     * 映画の詳細を取得
     */
    public function getMovieById(int $id): object
    {
        $movie = Movie::select('id', 'title', 'description', 'genre')
            ->findOrFail($id);

        return $movie;
    }

    /**
     * 映画情報の削除処理
     */
    public function deleteMovie(int $movie_id): void
    {
        Movie::findOrFail($movie_id)->delete();
    }

    /**
     * 映画情報を検索するクエリを生成
     */
    private function searchMoviesQuery(object $query, Request $request): object
    {
        // タイトル検索（完全一致・あいまい）
        if ($request->filled('title')) {
            if ($request->input('search_type') === 'partial') {
                $query->where('title', 'LIKE', '%' . $request->input('title') . '%');
            } else {
                $query->where('title', $request->input('title'));
            }
        }

        // ジャンル検索
        if ($request->filled('genre')) {
            $query->where('genre', $request->input('genre'));
        }

        // 説明文検索
        if ($request->filled('description')) {
            $query->where('description', 'LIKE', '%' . $request->input('description') . '%');
        }

        return $query;
    }
}