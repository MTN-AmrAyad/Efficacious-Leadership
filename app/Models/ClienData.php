<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienData extends Model
{
    use HasFactory;
    // protected $guarded = [];
    protected $fillable = [
        'client_name',
        'client_email',
        'client_job',
        'client_country',
        'client_country_code',
        'client_phone'
    ];
}
