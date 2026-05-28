<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // 💡 どこのお店（Spot）に対するレビューなのかを振り返る電線
    public function spot()
    {
        return $this->belongsTo(Spot::class);
    }

    // 💡 誰（User）が書いたレビューなのかを振り返る電線
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
