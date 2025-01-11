<?php

namespace App\Services\Admin;

use App\Models\Movie;

class MovieService
{
    /**
     * 映画の一覧を取得
     */
    public function getMovies(): object
    {
        return Movie::select('id', 'title', 'description', 'genre')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
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
}