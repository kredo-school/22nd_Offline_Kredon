<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketsController extends Controller
{
    public function index()
    {
        $items = [
            ['id'=>1,'name'=>'MacBook 充電器','category'=>'家電','condition'=>'ほぼ未使用','user'=>'Maria Santos','handle'=>'@maria_cebu','status'=>'出品中','comments'=>3,'icon'=>'fa-laptop'],
            ['id'=>2,'name'=>'Tシャツ S/M サイズ','category'=>'衣類','condition'=>'2枚セット','user'=>'John Dela Cruz','handle'=>'@john_cebu','status'=>'出品中','comments'=>1,'icon'=>'fa-shirt'],
            ['id'=>3,'name'=>'日焼け止め・虫除けセット','category'=>'消耗品','condition'=>'残り半分','user'=>'Sarah Kim','handle'=>'@sarah_kim','status'=>'譲渡済み','comments'=>0,'icon'=>'fa-pump-soap'],
            ['id'=>4,'name'=>'変換プラグ（EU型）','category'=>'家電','condition'=>'写真不鮮明','user'=>'David Lee','handle'=>'@david_t','status'=>'要確認','comments'=>2,'icon'=>'fa-plug'],
            ['id'=>5,'name'=>'ガイドブック セブ島','category'=>'その他','condition'=>'書き込みなし','user'=>'Lisa Wong','handle'=>'@lisa_w','status'=>'出品中','comments'=>0,'icon'=>'fa-book'],
            ['id'=>6,'name'=>'折りたたみ傘','category'=>'その他','condition'=>'1回使用','user'=>'Mike Tan','handle'=>'@mike_t','status'=>'出品中','comments'=>1,'icon'=>'fa-umbrella'],
        ];

        $comments = [
            ['text'=>'まだ出品中ですか？来週受け取れます！','item_name'=>'MacBook 充電器','item_id'=>1,'user'=>'John Dela Cruz','handle'=>'@john_cebu','date'=>'2025-05-23 18:30','status'=>'承認済み'],
            ['text'=>'サイズはSとMどちらが残ってますか？','item_name'=>'Tシャツ S/M サイズ','item_id'=>2,'user'=>'Sarah Kim','handle'=>'@sarah_kim','date'=>'2025-05-23 15:10','status'=>'承認済み'],
            ['text'=>'これ本当に機能しますか？怪しいです。','item_name'=>'変換プラグ（EU型）','item_id'=>4,'user'=>'Anonymous','handle'=>'@anonymous','date'=>'2025-05-22 12:45','status'=>'保留中'],
            ['text'=>'http://spam-link.com 安く買えます！','item_name'=>'変換プラグ（EU型）','item_id'=>4,'user'=>'System','handle'=>'@system','date'=>'2025-05-21 09:00','status'=>'スパム'],
            ['text'=>'折り畳み方を教えてもらえますか？','item_name'=>'折りたたみ傘','item_id'=>6,'user'=>'Lisa Wong','handle'=>'@lisa_w','date'=>'2025-05-20 14:20','status'=>'承認済み'],
        ];

        return view('admin.markets.index', compact('items', 'comments'));
    }

    public function show($id)
    {
        // ダミーデータ（実際はDB: MarketItem::with('comments', 'user')->findOrFail($id)）
        $item = [
            'id'          => $id,
            'name'        => 'MacBook 充電器',
            'category'    => '家電',
            'condition'   => 'ほぼ未使用・動作確認済み',
            'status'      => '出品中',
            'posted_at'   => '2025-05-20 14:30',
            'location'    => 'IT Park周辺（要相談）',
            'user'        => 'Maria Santos',
            'handle'      => '@maria_cebu',
            'description' => 'Apple純正のMacBook用充電器です。先月購入しましたが、帰国前に荷物を減らしたいため出品します。動作確認済みで問題なく使えます。次の滞在者の方にぜひ使っていただきたいです。受け渡しはIT Park周辺で対応可能です。',
            'comments'    => [
                [
                    'user'   => 'John Dela Cruz',
                    'handle' => '@john_cebu',
                    'text'   => 'まだ出品中ですか？来週受け取れます！',
                    'date'   => '2025-05-23 18:30',
                    'status' => '承認済み',
                ],
                [
                    'user'   => 'Sarah Kim',
                    'handle' => '@sarah_kim',
                    'text'   => 'どのMacBookモデルに対応していますか？',
                    'date'   => '2025-05-22 11:15',
                    'status' => '承認済み',
                ],
                [
                    'user'   => 'Anonymous',
                    'handle' => '@anonymous',
                    'text'   => '偽物では？写真が不鮮明すぎます。',
                    'date'   => '2025-05-21 09:00',
                    'status' => '保留中',
                ],
            ],
        ];

        return view('admin.markets.show', compact('item'));
    }
}