<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charactertemp extends Model
{
    protected $table = 'character_temps';

    protected = $fillable [
        'name',
        'image_path',
        'slug',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active'  => 'boolean',
    ];

    // デフォルトキャラを取得するスコープ
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // このキャラを選択しているユーザー
    public function users()
    {
        return $this->hasMany(User::class, 'character_temp_id');
    {
}

