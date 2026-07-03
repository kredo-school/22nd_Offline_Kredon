<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CharacterTemp extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image_path',
        'initial',
        'bg_color',
        'accent',
        'description',
        'is_default',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'is_active'  => 'boolean',
        ];
    }

    public function userSettings(): HasMany
    {
        return $this->hasMany(UserSetting::class);
    }
}
