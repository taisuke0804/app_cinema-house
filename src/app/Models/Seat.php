<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'screening_id',
        'row',
        'number',
        'is_reserved',
    ];

    public function screening()
    {
        return $this->belongsTo(Screening::class);
    }
}
