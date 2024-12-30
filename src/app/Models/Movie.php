<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\Genre;

class Movie extends Model
{
    use HasFactory; 

    protected $fillable = [
        'title',
        'genre',
        'description',
        'release_date',
    ];

    /**
     * 映画のジャンルを取得
     */
    protected $casts = [
        'genre' => Genre::class,
    ];

    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }
}
