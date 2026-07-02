<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 🌟 マイページを表示する係
    public function mypage(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ========================================================
        // 📚 学習スポット＆クチコミのデータ（既存のまま完璧です）
        // ========================================================
        $myReviews = $user->reviews()->with('spot')->latest()->paginate(10, ['*'], 'reviews_page');

        $query = $user->bookmarks()->withCount('bookmarks');
        $filter = $request->query('filter');
        
        if ($filter === 'wifi') {
            $query->where('has_wifi', true);
        } elseif ($filter === 'power') {
            $query->where('has_power', true);
        }

        $myBookmarks = $query->latest()->paginate(10, ['*'], 'bookmarks_page');

        // ========================================================
        // 🌴 観光スポットのお気に入りデータ（🌟 ここを大改造！）
        // ========================================================
        $touristQuery = $user->bookmarkedTouristSpots();
        $touristFilter = $request->query('tourist_filter'); // Bladeからの指令を受け取る

        if ($touristFilter === 'area_cebu') {
            // 💡 セブ市内（ITパーク、アヤラなど近場）だけを抽出
            $touristQuery->whereIn('area', ['ITパーク', 'アヤラ']);
        } elseif ($touristFilter === 'area_far') {
            // 💡 遠方（ITパーク・アヤラ以外。マクタンやその他）を抽出
            $touristQuery->whereNotIn('area', ['ITパーク', 'アヤラ']);
        }

        // 最後に、絞り込んだ結果を「最近保存した順」で取得！
        $bookmarkedTouristSpots = $touristQuery->latest('tourist_bookmarks.created_at')->get();

        // ========================================================
        // 🌟 10秒フリップ用の最強ピックアップ！
        // 奇数・偶数週の縛りをなくし、「学習の1位」と「観光の1位」を同時に取得する
        // ========================================================
        $learningPickup = \App\Models\Spot::withCount('bookmarks')
                            ->orderByDesc('bookmarks_count')
                            ->first();

        $touristPickup = \App\Models\TouristSpot::withCount('bookmarks')
                            ->orderByDesc('bookmarks_count')
                            ->first();

        // ========================================================
        // 🌟 データをすべてまとめて画面（Blade）に渡す！
        // ========================================================
        return view('mypage', compact(
            'myReviews', 
            'myBookmarks', 
            'bookmarkedTouristSpots', 
            'learningPickup', 
            'touristPickup'
        ));
    }
}