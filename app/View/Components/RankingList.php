<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RankingList extends Component
{
    public $title;
    public $metric;
    public $items;
    public $totalPlayers; // 追加: Bladeでのエラーを防ぐため

    public function __construct($type = 'game_score')
    {
        switch ($type) {
            case 'game_score':
                $this->title        = 'プレイヤーランキング';
                $this->metric       = 'pt';
                $this->totalPlayers = 66; // 適宜数値を設定してください
                $this->items        = [
                    (object)['title' => 'クレ田', 'value' => 9999],
                    (object)['title' => 'クレ村', 'value' => 7000],
                    (object)['title' => '山クレ', 'value' => 6000],
                ];
                break;

            case 'game_level':
                $this->title        = 'キャラレベルランキング';
                $this->metric       = 'Lv';
                $this->totalPlayers = 66; // 適宜数値を設定してください
                $this->items        = [
                    (object)['title' => 'クレミチ', 'value' => 99],
                    (object)['title' => 'クレジナ', 'value' => 85],
                    (object)['title' => 'クレドン', 'value' => 82],
                ];
                break;
                
            default:
                $this->title        = 'ランキング';
                $this->metric       = '';
                $this->totalPlayers = 0;
                $this->items        = [];
                break;
        } 
    } 

    public function render(): View|Closure|string
    {
        return view('components.ranking-list');
    }
}