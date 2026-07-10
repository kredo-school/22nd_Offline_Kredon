<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'item_post_id',
        'path',
    ];

    public function itemPost()
    {
        return $this->belongsTo(ItemPost::class, 'item_post_id');
    }
}