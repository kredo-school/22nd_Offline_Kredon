<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // updated_at カラムがないため、Laravelの自動更新をオフ
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'image_path',
        'created_at',
    ];
}
