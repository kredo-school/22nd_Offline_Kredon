<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function index()
    {
        return view('admin.analysis.index', [
            'growth'           => $this->getMonthlyGrowthAndChurn(),
            'dormancy'         => $this->getDormancyFunnel(),
            'loginDistribution'=> $this->getLoginCountDistribution(),
            'timeToChurn'      => $this->getTimeToChurn(),
            'roleComparison'   => $this->getRoleComparison(),
        ]);
    }

    /**
     * ① 月次の累計登録数 と 累計離脱数（過去12ヶ月）
     */
    private function getMonthlyGrowthAndChurn(): array
    {
        $months = collect(range(0, 11))
            ->map(fn ($i) => now()->subMonths(11 - $i)->format('Y-m'));

        $registrations = User::withTrashed()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as cnt")
            ->groupBy('ym')
            ->pluck('cnt', 'ym');

        $churns = User::onlyTrashed()
            ->selectRaw("DATE_FORMAT(deleted_at, '%Y-%m') as ym, COUNT(*) as cnt")
            ->groupBy('ym')
            ->pluck('cnt', 'ym');

        $cumulativeTotal = 0;
        $cumulativeChurn = 0;
        $labels = [];
        $totalSeries = [];
        $churnSeries = [];

        foreach ($months as $ym) {
            $cumulativeTotal += $registrations->get($ym, 0);
            $cumulativeChurn += $churns->get($ym, 0);

            $labels[]      = $ym;
            $totalSeries[] = $cumulativeTotal;
            $churnSeries[] = $cumulativeChurn;
        }

        return compact('labels', 'totalSeries', 'churnSeries');
    }

    /**
     * ② 休眠ファネル：直近ログインからの経過日数で4段階に分類
     */
    private function getDormancyFunnel(): array
    {
        $base = User::whereNull('deleted_at');

        return [
            'active'       => (clone $base)->where('last_login_at', '>=', now()->subDays(7))->count(),
            'cooling'      => (clone $base)->whereBetween('last_login_at', [now()->subDays(30), now()->subDays(7)])->count(),
            'dormant'      => (clone $base)->whereBetween('last_login_at', [now()->subDays(90), now()->subDays(30)])->count(),
            'long_dormant' => (clone $base)->where(function ($q) {
                $q->where('last_login_at', '<', now()->subDays(90))
                  ->orWhereNull('last_login_at');
            })->count(),
        ];
    }

    /**
     * ③ ログイン回数のヒストグラム
     */
    private function getLoginCountDistribution(): array
    {
        $buckets = [
            '0回'     => 0,
            '1-5回'   => 0,
            '6-20回'  => 0,
            '21-50回' => 0,
            '51回以上' => 0,
        ];

        User::withTrashed()->pluck('login_count')->each(function ($count) use (&$buckets) {
            $count = (int) $count;
            match (true) {
                $count === 0    => $buckets['0回']++,
                $count <= 5     => $buckets['1-5回']++,
                $count <= 20    => $buckets['6-20回']++,
                $count <= 50    => $buckets['21-50回']++,
                default         => $buckets['51回以上']++,
            };
        });

        return $buckets;
    }

    /**
     * ④ 登録〜離脱（Ban/削除）までの平均・中央値日数
     */
    private function getTimeToChurn(): ?array
    {
        $days = User::onlyTrashed()
            ->get(['created_at', 'deleted_at'])
            ->map(fn ($u) => $u->created_at->diffInDays($u->deleted_at))
            ->sort()
            ->values();

        if ($days->isEmpty()) {
            return null;
        }

        $count = $days->count();
        $median = $count % 2 === 0
            ? round(($days[$count / 2 - 1] + $days[$count / 2]) / 2, 1)
            : $days[intdiv($count, 2)];

        return [
            'avg'         => round($days->avg(), 1),
            'median'      => $median,
            'sample_size' => $count,
        ];
    }

    /**
     * ⑤ Role別の平均ログイン回数 と 休眠率
     */
    private function getRoleComparison(): array
    {
        $roles = [1 => 'Admin', 2 => 'Member', 3 => 'Premium-Member'];
        $result = [];

        foreach ($roles as $value => $label) {
            $users = User::where('role', $value)->whereNull('deleted_at')->get();
            $total = $users->count();

            $dormantCount = $users->filter(function ($u) {
                return is_null($u->last_login_at) || $u->last_login_at->lt(now()->subDays(30));
            })->count();

            $result[$label] = [
                'total'           => $total,
                'avg_login_count' => $total > 0 ? round($users->avg('login_count'), 1) : 0,
                'dormancy_rate'   => $total > 0 ? round($dormantCount / $total * 100, 1) : 0,
            ];
        }

        return $result;
    }
}