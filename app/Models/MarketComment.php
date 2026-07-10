<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketComment extends Model
{
    protected $fillable = [
        'item_post_id',
        'user_id',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(ItemPost::class,'item_post_id');
    }
}