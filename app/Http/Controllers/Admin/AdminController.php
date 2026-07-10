<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Spot;
use App\Models\TouristSpot;
use App\Models\Hospital;
use App\Models\Event;

use Carbon\Carbon;


class AdminController extends Controller
{
    public function dashboard()
    {
        // 総ユーザー数
        $totalUsers = User::count();

        // 先週時点でのユーザー数（1週間前までに登録されたユーザー数）
        $lastWeekUsers = User::where('created_at', '<=', Carbon::now()->subWeek())->count();

        // 増減率を計算（ゼロ除算対策あり）
        if ($lastWeekUsers > 0) {
            $userGrowthRate = round((($totalUsers - $lastWeekUsers) / $lastWeekUsers) * 100, 1);
        } else {
            $userGrowthRate = 0;
        }

        // Total Locations（Working + Tourism + Hospital の合計）
        $totalLocations = Spot::count() + TouristSpot::count() + Hospital::count();

        // 先週時点での合計（各テーブルで1週間前までに作成された件数を合算）
        $lastWeekLocations = Spot::where('created_at', '<=', Carbon::now()->subWeek())->count()
            + TouristSpot::where('created_at', '<=', Carbon::now()->subWeek())->count()
            + Hospital::where('created_at', '<=', Carbon::now()->subWeek())->count();

        // 増減数（+8のような差分表示）
        $locationsDiff = $totalLocations - $lastWeekLocations;

        // --- Active events（開催中のイベント数） ---
        $today = today();
        $activeEventsCount = Event::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->count();

        // 1週間前時点で「開催中」だったイベント数（同じ条件を1週間前の日付で判定）
        $lastWeek = $today->copy()->subWeek();
        $lastWeekActiveEventsCount = Event::whereDate('start_date', '<=', $lastWeek)
            ->whereDate('end_date', '>=', $lastWeek)
            ->count();

        $activeEventsDiff = $activeEventsCount - $lastWeekActiveEventsCount;

        return view('admin.dashboard', compact(
            'totalUsers',
            'userGrowthRate',
            'totalLocations',
            'locationsDiff',
            'activeEventsCount',
            'activeEventsDiff'
            // 他のカード用データもここに追加していく
        ));
    }
}