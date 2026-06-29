<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //  モックデータ
        
        // マーケットアイテムのモック
        $dummyItem = new \stdClass();
        $dummyItem->title = '人気のマーケットアイテムA';
        $dummyItem->description = 'これはテスト用の説明文です。';
        $dummyItem->user = new \stdClass();
        $dummyItem->user->name = 'テストユーザー';
        $dummyItem->created_at = new class { public function diffForHumans() { return '1時間前'; } };

        $marketItems = [$dummyItem];

        $workingSpots = []; 
        $touristSpots = [];

        //  通知のモック
        $n1 = new \stdClass();
        $n1->title = 'ダミー通知1';
        $n1->created_at = new class { public function diffForHumans() { return 'たった今'; } };
        $n1->image_url = 'https://placehold.co/45/45';

        $notifications = [$n1];

        $category = request('category', 'market');

        switch ($category) {

            case 'working':
            $posts = $workingSpots;
            break;

            case 'tourist':
            $posts = $touristSpots;
            break;

            default:
            $posts = $marketItems;
            break;
            }
        
            return view('home', [
                'posts' => $posts,
                'notifications' => $notifications
        ]);
    }
}
