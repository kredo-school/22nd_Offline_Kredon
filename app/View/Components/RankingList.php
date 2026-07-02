<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RankingList extends Component
{
    public $title;
    public $metric;
    public $items;
    public $totalPlayers;

    public function __construct($type = 'game_score')
    {
        $this->totalPlayers = User::count();

        switch ($type) {
            case 'game_score':
                $this->title  = 'プレイヤーランキング';
                $this->metric = 'pt';
                $this->items  = User::query()
                    ->orderByDesc('posts_count')
                    ->orderBy('name')
                    ->limit(3)
                    ->get()
                    ->map(fn (User $user) => (object) [
                        'title' => $user->name,
                        'value' => $user->posts_count,
                    ])
                    ->all();
                break;

            case 'game_level':
                $this->title  = 'キャラレベルランキング';
                $this->metric = 'Lv';
                $this->items  = User::query()
                    ->orderByDesc('role')
                    ->orderByDesc('posts_count')
                    ->orderBy('name')
                    ->limit(3)
                    ->get()
                    ->map(fn (User $user) => (object) [
                        'title' => $user->name,
                        'value' => $user->role,
                    ])
                    ->all();
                break;

            default:
                $this->title  = 'ランキング';
                $this->metric = '';
                $this->items  = [];
                break;
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.ranking-list');
    }
}
