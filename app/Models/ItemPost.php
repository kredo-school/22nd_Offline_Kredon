<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

class ItemPost extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'location_name',
        'description',
        'category',
        'status',
    ];


public function images()
{
    return $this->hasMany(Image::class);
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    
}