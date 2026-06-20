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
    public $label;

    public function __construct($type = 'market')
    {
        switch ($type) {
            case 'game_score':
                $this->title  = 'プレイヤーランキング';
                $this->metric = 'pt';
                $this->items  = [
                    (object)['title' => 'クレ田', 'value' => 9999, 'url' => null],
                    (object)['title' => 'クレ村', 'value' => 7000, 'url' => null],
                    (object)['title' => '山クレ', 'value' => 6000, 'url' => null],
                ];
                break;

            case 'spot':
                $this->title  = '観光スポットランキング';
                $this->metric = 'レビュー';
                $this->items  = [
                    (object)['title' => 'オスロブ',    'value' => 4,   'url' => null],
                    (object)['title' => 'カワサン',    'value' => 3.7, 'url' => null],
                    (object)['title' => 'モアルボアル', 'value' => 3.6, 'url' => null],
                ];
                break;

            case 'game_level':
                $this->title  = 'キャラレベルランキング';
                $this->metric = 'Lv';
                $this->items  = [
                    (object)['title' => 'クレミチ', 'value' => 99, 'url' => null],
                    (object)['title' => 'クレジナ', 'value' => 85, 'url' => null],
                    (object)['title' => 'クレドン', 'value' => 82, 'url' => null],
                ];
                break;

            case 'market':
            default:
                $this->title  = 'マーケットランキング';
                $this->metric = '件のコメント';
                $this->items  = [
                    (object)['title' => 'Akira先輩のマットレス', 'value' => 70, 'url' => null],
                    (object)['title' => '人気のプロテイン',       'value' => 18, 'url' => null],
                    (object)['title' => '教科書（カラン）',       'value' => 13, 'url' => null],
                ];
                break;

        } 
    } 

    public function render(): View|Closure|string
    {
        return view('components.ranking-list');
    }
}