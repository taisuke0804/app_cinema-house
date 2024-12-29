<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Screening extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'start_time',
        'end_time',
    ];

    /**
     * キャスト定義
     */
    protected function casts(): array
    {
        return [
            'start_time' => 'datetime', // 日時型へのキャスト
            'end_time' => 'datetime', // 日時型へのキャスト
        ];
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
