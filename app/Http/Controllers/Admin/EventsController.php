<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Notification;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    public function index(Request $request)
    {
        $today = today();
        $month = (int) ($request->query('month') ?? $today->month);
        $year  = (int) ($request->query('year') ?? $today->year);
        
        // --- サマリーカード ---
        $allEventsCount = Event::count();
        
        $nowOnCount = Event::whereDate('start_date', '<=', $today)
        ->whereDate('end_date', '>=', $today)
        ->count();

        // 開催予定のイベント数（start_dateがまだ来ていないもの）
        $upcomingEventsCount = Event::where('start_date', '>', $today)->count();

        $allParticipants = EventParticipant::count();

        $thisMonthParticipants = EventParticipant::whereMonth('created_at', $today->month)
            ->whereYear('created_at', $today->year)
            ->count();

        $lastMonth = $today->copy()->subMonth();
        $lastMonthParticipants = EventParticipant::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $participantsGrowth = $lastMonthParticipants > 0
            ? round((($thisMonthParticipants - $lastMonthParticipants) / $lastMonthParticipants) * 100, 1)
            : 0;

        // --- 期間限定イベント一覧（開催中→予定の順で4件） ---
        $limitedEvents = Event::withCount('participants')
            ->where('organizer_type', 'company')
            ->orderByRaw("
                CASE
                    WHEN CURDATE() BETWEEN start_date AND end_date THEN 0
                    WHEN start_date > CURDATE() THEN 1
                    ELSE 2
                END
            ")
            ->orderBy('start_date')
            ->take(4)
            ->get();

        // --- 期間限定イベント一覧（全件・モーダル用） ---
        $allEvents = Event::withCount('participants')
            ->where('organizer_type', 'company')
            ->orderByRaw("
                CASE
                    WHEN CURDATE() BETWEEN start_date AND end_date THEN 0
                    WHEN start_date > CURDATE() THEN 1
                    ELSE 2
                END
            ")
            ->orderBy('start_date')
            ->get();


        // --- 参加者一覧（最新5件） ---
        $recentParticipants = EventParticipant::with(['user:id,name', 'event:id,title'])
            ->latest()
            ->take(5)
            ->get();

        // --- カレンダー（当月分） ---
        $firstDay = Carbon::create($year, $month, 1);
        $daysInMonth = $firstDay->daysInMonth;
        $startWeekday = $firstDay->dayOfWeek; // 0=Sun

        $monthEvents = Event::where(function ($q) use ($month, $year) {
            $q->whereYear('start_date', '<=', $year)
                ->whereYear('end_date', '>=', $year);
        })->get(['id', 'start_date', 'end_date']);

        $eventDays = [];
        foreach ($monthEvents as $ev) {
            $period = CarbonPeriod::create($ev->start_date, $ev->end_date);
            foreach ($period as $date) {
                if ((int) $date->month === $month && (int) $date->year === $year) {
                    $eventDays[$date->day] = true;
                }
            }
        }

        $weeks = [];
        $day = 1 - $startWeekday;
        while ($day <= $daysInMonth) {
            $week = [];
            for ($i = 0; $i < 7; $i++, $day++) {
                if ($day < 1 || $day > $daysInMonth) {
                    $outsideDate = Carbon::create($year, $month, 1)->addDays($day - 1);
                    $week[] = ['d' => $outsideDate->day, 'o' => true];
                } else {
                    $entry = ['d' => $day];
                    if ($today->year === $year && $today->month === $month && $today->day === $day) {
                        $entry['today'] = true;
                    }
                    if (isset($eventDays[$day])) {
                        $entry['dot'] = 'primary';
                    }
                    $week[] = $entry;
                }
            }
            $weeks[] = $week;
        }

        $calendarLabel = $firstDay->translatedFormat('Y年n月');

        return view('admin.events.index', compact(
            'allEventsCount',
            'nowOnCount',
            'upcomingEventsCount',
            'allParticipants',
            'thisMonthParticipants',
            'participantsGrowth',
            'limitedEvents',
            'allEvents',
            'recentParticipants',
            'weeks',
            'calendarLabel',
            'month',
            'year'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required|max:255',
            'description' => 'required',
            'location' => 'nullable|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'display_channel' => 'required|in:event_page,share_info',

            'image1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image1')) {
            $validated['image1'] = $request->file('image1')->store('events', 'public');
        }
        if ($request->hasFile('image2')) {
            $validated['image2'] = $request->file('image2')->store('events', 'public');
        }

        $validated['end_date'] = $validated['end_date'] ?? $validated['start_date'];
        $validated['user_id'] = Auth::id();
        $validated['organizer_type'] = 'company';
        $validated['is_published'] = false; // 承認されるまで非公開

        $event = Event::create($validated);

        // 通知管理画面にPendingとして自動登録
        Notification::create([
            'category' => 'event',
            'title' => $event->title,
            'body' => \Illuminate\Support\Str::limit($event->description, 100),
            'target_type' => 'all',
            'data' => (['event_id' => $event->id]),
            'status' => 'pending',
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'You have created an event! Please publish it via the notifications management screen.');
    }
}