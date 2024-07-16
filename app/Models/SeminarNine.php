<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarNine extends Model
{
    use HasFactory;
    protected $fillable = [
        "client_name",
        "client_email",
        "client_country",
        "client_country_code",
        "client_phone",
        "self_interste",
        "relationship_interest",
        "work_interest",
        "attend_in_transformational_leadership",
    ];
}
