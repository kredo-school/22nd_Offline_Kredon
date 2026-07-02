<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TouristBookmark extends Model
{
    protected $fillable = ['user_id', 'tourist_spot_id'];
}
