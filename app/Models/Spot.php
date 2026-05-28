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
    // app/Models/Spot.php の中に追加

public function scopeExtremeFocus($query)
{
    // レビューの平均値が「死角が多い」「人通りが少ない」お店だけを裏側で絞り込む
    return $query->whereHas('reviews', function ($q) {
        $q->havingRaw('AVG(dead_spot_rating) >= 4')
          ->havingRaw('AVG(traffic_avoidance_rating) >= 4');
    });
}
}
