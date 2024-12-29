<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory; 

    protected $fillable = [
        'title',
        'description',
        'release_date',
    ];

    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }
}
