<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadershipAttedJuly extends Model
{
    use HasFactory;
    protected $table = "leadership_atted_julies";
    protected $fillable = [
        'client_name',
        'client_email',
        'client_country',
        'client_country_code',
        'client_phone',
        'attendance',
        'reservation',
        'chairNumber',
        'section'
    ];

    protected $casts = [
        'reservation' => 'array',
    ];
}
