<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
    use HasFactory;

    protected $fillable = [
        'concert_id',
        'concert_name',
        'concert_date',
        'concert_time',
        'name_of_artist',
        'venue',
        'seat_capacity',
    ];

}
