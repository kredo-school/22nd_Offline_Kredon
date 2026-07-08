<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\Bookmark;
use App\Models\User;
use App\Models\SpotPhoto;

class Spot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'area', 'photo_path', 'hours', 'description',
        'has_wifi', 'has_power', 'has_food', 'user_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | 🔗 繋ぎ込み（リレーション設定）
    |--------------------------------------------------------------------------
    */
    // 🌟 このスポットを登録したユーザー（作成者）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reviewsAsSpot()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔍 検索ロジックスコープ（scopeSearch）
    |--------------------------------------------------------------------------
    */
    public function scopeSearch($query, $request)
    {
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('area', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        if ($request->has('has_wifi')) {
            $query->where('has_wifi', true);
        }

        if ($request->has('has_power')) {
            $query->where('has_power', true);
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | 🔄 プロの先読み：ソート（並べ替え）ロジックを集約するスコープ（scopeSort）
    |--------------------------------------------------------------------------
    | 画面から送られてきたソート順（sort）に応じて、並べ替えを切り替えます。
    | モデルに書くことで、将来「評価順」などを追加する際も、ここを修正するだけ！
    */
    public function scopeSort($query, $request)
    {
        // ① デフォルト（ソート指定なし）の場合は「新着順」
        if (!$request->filled('sort')) {
            return $query->latest();
        }

        // ② ソート順の切り替え
        switch ($request->sort) {
            case 'new': // 新着順
                return $query->latest();
            case 'old': // 古い順
                return $query->oldest();
            case 'reviews': // クチコミの多い順
                // ※withCount('reviews') がコントローラー側で呼ばれている前提で、
                // reviews_count という架空のカラムで並べ替えます。
                return $query->orderByDesc('reviews_count');
            
            // 将来、ここに case 'rating': (評価順) などを足せば、1秒で拡張完了！
            
            default:
                return $query->latest(); // 該当なしは新着順
        }
    }
    /*
    |--------------------------------------------------------------------------
    | ⭐ 午前中の努力を復旧：お気に入り（Bookmark）機能
    |--------------------------------------------------------------------------
    */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function isBookmarkedBy($user)
    {
        if (!$user) {
            return false;
        }
        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }

    public function photos()
    {
        return $this->hasMany(SpotPhoto::class);
    }
    // app/Models/Spot.php の中に追加

public function isCouponUsedByMonth($user)
{
    if (!$user) {
        return false;
    }

    return \Illuminate\Support\Facades\DB::table('coupon_usages')
        ->where('user_id', $user->id)
        ->where('spot_id', $this->id)
        ->where('used_at', '>=', now()->startOfMonth()) // 今月の1日以降のデータがあるか
        ->exists();
}
// 🌟 追加：このスポットの編集履歴を「新しい順（latest）」で全部持ってくる！
    public function editHistories()
    {
        return $this->hasMany(SpotEditHistory::class)->latest();
    }
}