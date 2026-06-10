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
        // 📚 学習スポット＆クチコミのデータ
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
        // 🌴 観光スポットのお気に入りデータ
        // ========================================================
        $bookmarkedTouristSpots = $user->bookmarkedTouristSpots()->latest('tourist_bookmarks.created_at')->get();


        // ========================================================
        // 🌟 Taka-san考案！週替わりピックアップ・アルゴリズム
        // ========================================================
        $weekNumber = now()->weekOfYear; // 現在が今年の第何週目か
        $pickupSpot = null;
        $pickupType = ''; // 'study' か 'tourist' か

        if ($weekNumber % 2 == 0) {
            // 💡 偶数週：観光スポットの1位
            $pickupSpot = \App\Models\TouristSpot::withCount('bookmarks')
                            ->orderByDesc('bookmarks_count')
                            ->first();
            $pickupType = 'tourist';
        } else {
            // 💡 奇数週：学習スポットの1位
            $pickupSpot = \App\Models\Spot::withCount('bookmarks')
                            ->orderByDesc('bookmarks_count')
                            ->first();
            $pickupType = 'study';
        }


        // ========================================================
        // 🌟 5つのデータをすべてまとめて画面（Blade）に渡す！
        // ※この行が一番重要です！
        // ========================================================
        return view('mypage', compact('myReviews', 'myBookmarks', 'bookmarkedTouristSpots', 'pickupSpot', 'pickupType'));
    }
}