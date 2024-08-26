<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class installementLand extends Model
{
    use HasFactory;
    protected $fillable = [
        "client_name",
        "client_country",
        "client_country_code",
        "client_phone",
        "client_email",
    ];
}
