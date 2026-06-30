<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NgWord extends Model
{
    protected $fillable = [
        'word',
        'category',
        'min_strength',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
