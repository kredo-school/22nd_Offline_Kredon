<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    // 🌟 データベースへの一括保存を許可するリスト
    protected $fillable = [
        'spot_id',
        'user_id',
        'customer_vibe',
        'eye_fatigue_level',
        'chair_comfort',
        'desk_stability',
        'comment',
        'dead_spot_rating',
        'aircon_level',
        'stay_time_level',
        'rating',
        'title',
        'photo_path',
    ];
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
