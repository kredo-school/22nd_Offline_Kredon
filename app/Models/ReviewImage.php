<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReviewImage extends Model
{
    use HasFactory;

    protected $table = 'review_images';

    protected $fillable = [
        'review_id',
        'image_path',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function images(): HasMany {
       return $this->hasMany(ReviewImage::class);
    }
}
