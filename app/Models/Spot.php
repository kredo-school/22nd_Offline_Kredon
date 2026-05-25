<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;

    // 💡 複数形にするのがLaravelのルールです！
    // 「1つのお店（Spot）は、たくさんのレビュー（Reviews）を持っている」という電線を繋ぎます
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
