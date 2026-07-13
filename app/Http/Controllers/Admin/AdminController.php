<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Spot;
use App\Models\TouristSpot;
use App\Models\Hospital;
use App\Models\ItemPost;
use App\Models\Notification;
use App\Models\Event;

use Carbon\Carbon;


class AdminController extends Controller
{
   public function dashboard()
{
    $lastWeek = Carbon::now()->subWeek();

    // ── Total Users ──
    $totalUsers = User::count();
    $lastWeekUsers = User::where('created_at', '<=', $lastWeek)->count();
    $userGrowthRate = $lastWeekUsers > 0
        ? round((($totalUsers - $lastWeekUsers) / $lastWeekUsers) * 100, 1)
        : 0;

    // ── Total Spots (Working + Tourism + Hospital) ──
    $totalSpots = Spot::count() + TouristSpot::count() + Hospital::count();
    $totalSpotsLastWeek = Spot::where('created_at', '<=', $lastWeek)->count()
        + TouristSpot::where('created_at', '<=', $lastWeek)->count()
        + Hospital::where('created_at', '<=', $lastWeek)->count();
    $spotsDiffRate = $totalSpotsLastWeek > 0
        ? round((($totalSpots - $totalSpotsLastWeek) / $totalSpotsLastWeek) * 100, 1)
        : 0;

    // 互換用（既存Bladeで $totalLocations / $locationsDiff を使っている箇所がまだあるなら残す）
    $totalLocations = $totalSpots;
    $locationsDiff = $totalSpots - $totalSpotsLastWeek;

    // ── Active Events ──
    $today = today();
    $activeEventsCount = Event::whereDate('start_date', '<=', $today)
        ->whereDate('end_date', '>=', $today)
        ->count();

    $lastWeekDate = $today->copy()->subWeek();
    $lastWeekActiveEventsCount = Event::whereDate('start_date', '<=', $lastWeekDate)
        ->whereDate('end_date', '>=', $lastWeekDate)
        ->count();

    $activeEventsDiff = $activeEventsCount - $lastWeekActiveEventsCount;

    // ── Total Markets ──
    $totalMarkets = ItemPost::count();
    $totalMarketsLastWeek = ItemPost::where('created_at', '<=', $lastWeek)->count();
    $marketsDiffRate = $totalMarketsLastWeek > 0
        ? round((($totalMarkets - $totalMarketsLastWeek) / $totalMarketsLastWeek) * 100, 1)
        : 0;

    // ── Total Reviews (3テーブル合算) ──
    $totalReviews = DB::table('all_reviews')->count()
        + DB::table('reviews')->count()
        + DB::table('tourist_reviews')->count();
    $totalReviewsLastWeek = DB::table('all_reviews')->where('created_at', '<=', $lastWeek)->count()
        + DB::table('reviews')->where('created_at', '<=', $lastWeek)->count()
        + DB::table('tourist_reviews')->where('created_at', '<=', $lastWeek)->count();
    $reviewsDiff = $totalReviews - $totalReviewsLastWeek;

    // ── Total Notifications ──
    $totalNotifications = Notification::count();
    $totalNotificationsLastWeek = Notification::where('created_at', '<=', $lastWeek)->count();
    $notificationsDiffRate = $totalNotificationsLastWeek > 0
        ? round((($totalNotifications - $totalNotificationsLastWeek) / $totalNotificationsLastWeek) * 100, 1)
        : 0;

    return view('admin.dashboard', compact(
        'totalUsers', 'userGrowthRate',
        'totalSpots', 'spotsDiffRate',
        'totalLocations', 'locationsDiff',
        'activeEventsCount', 'activeEventsDiff',
        'totalMarkets', 'marketsDiffRate',
        'totalReviews', 'reviewsDiff',
        'totalNotifications', 'notificationsDiffRate'
    ));
}

    
}