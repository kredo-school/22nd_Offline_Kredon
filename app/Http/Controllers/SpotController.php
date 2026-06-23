<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;
use App\Models\Review;
use App\Models\SpotEditHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SpotController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'             => 'required|string|max:255',
            'area'             => 'required|string',
            'hours_type'       => 'required|in:specified,24h,unknown',
            'open_time'        => 'nullable|string',
            'close_time'       => 'nullable|string',
            'photos'           => 'nullable|array|max:10',
            'photos.*'         => 'file|mimes:jpg,jpeg,png,gif,webp,avif|max:10240',
            'customer_vibe'    => 'required|integer|between:1,5',
            'eye_fatigue_level'=> 'required|integer|between:1,5',
            'chair_comfort'    => 'required|integer|between:1,5',
            'desk_stability'   => 'required|integer|between:1,5',
            'comment'          => 'nullable|string',
        ]);

        // ✅ 修正1: バリデーション失敗時に必ずリダイレクトで返す
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $spot = new Spot();
            $spot->name = $request->name;
            $spot->area = $request->area;

            $hours = null;
            if ($request->hours_type === '24h') {
                $hours = '24時間営業';
            } elseif ($request->hours_type === 'unknown') {
                $hours = '不明';
            } else {
                if ($request->filled('open_time') && $request->filled('close_time')) {
                    $hours = $request->open_time . ' - ' . $request->close_time;
                } elseif ($request->filled('open_time')) {
                    $hours = $request->open_time . ' - 未定';
                } elseif ($request->filled('close_time')) {
                    $hours = '未定 - ' . $request->close_time;
                } else {
                    $hours = '未定';
                }
            }
            $spot->hours = $hours;

            $spot->has_wifi  = $request->has('has_wifi');
            $spot->has_power = $request->has('has_power');
            $spot->user_id   = Auth::id();

            $spot->save();

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    $filename = uniqid() . '_' . time() . '.' . $photo->getClientOriginalExtension();
                    $path = $photo->storeAs('spots/' . $spot->id, $filename, 'public');

                    if ($index === 0) {
                        $spot->photo_path = $path;
                        $spot->save();
                    }

                    $spot->photos()->create([
                        'photo_path' => $path,
                    ]);
                }
            }

            $spot->reviews()->create([
                'user_id'          => Auth::id(),
                'customer_vibe'    => $request->customer_vibe,
                'eye_fatigue_level'=> $request->eye_fatigue_level,
                'chair_comfort'    => $request->chair_comfort,
                'desk_stability'   => $request->desk_stability,
                'comment'          => $request->comment,
            ]);

            DB::commit();

            $chance      = rand(1, 100);
            $rewardTitle = '';
            $rewardText  = '';

            if ($chance <= 15) {
                $recommendedSpot = Spot::where('area', $request->area)
                    ->where('id', '!=', $spot->id)
                    ->inRandomOrder()
                    ->first();

                if ($recommendedSpot) {
                    $rewardTitle = '📍 ' . $request->area . 'エリアのおすすめスポット発掘！';
                    $rewardText  = "実は、あなたが登録したエリアには他にも注目の場所があります。\n👉 「{$recommendedSpot->name}」\n今度気分を変えたい時に、ぜひチェックしてみてください！";
                }
            }

            if (empty($rewardTitle)) {
                $tips = [
                    ['title' => '🥦 午後のパフォーマンスを最大化する食事',       'text' => 'ランチは「腹7分目」に抑え、ブロッコリーなどの野菜を多めに取り入れましょう。血糖値の乱高下を防ぎ、午後のコーディングや英語学習の眠気を完全にシャットアウトできます。'],
                    ['title' => '🧘 ネガティブ・ケイパビリティのすゝめ',         'text' => 'プログラミングのエラーで行き詰まった時は、すぐに答えを求めず「分からない状態に耐える力（ネガティブ・ケイパビリティ）」を発揮しましょう。このモヤモヤした時間が、脳の回路を最も成長させます。'],
                    ['title' => '🪑 集中力をハックする「死角（デッドスペース）」', 'text' => 'カフェで作業する際は、他人の視線に入らない「壁際の角」を選びましょう。人間の脳は無意識に他人の目を気にしてリソースを消費するため、死角に入るだけで作業効率が劇的に跳ね上がります。'],
                    ['title' => '🚶‍♂️ 座りっぱなしは生産性の敵',               'text' => '長時間の作業は血流を滞らせ、脳のパフォーマンスを低下させます。可能であればスタンディングデスクを活用するか、1時間に1回は立ち上がって姿勢をリセットする習慣をつけましょう。'],
                    ['title' => '⏱️ 意志の力に頼らない「環境構築」',             'text' => '「頑張って勉強しよう」という意志は長続きしません。スマホの通知を完全にオフにし、物理的にノイズを遮断する環境（ノイズレスUI）に身を置くことで、自動的に集中モードに入れます。'],
                    ['title' => '🛌 睡眠負債は休日の寝だめでは返せない',         'text' => '質の高いアウトプットの土台は「日々の睡眠」です。学習時間を削ってでも、毎日の睡眠リズムを一定に保つことが、長期的なスキルの定着（記憶の整理）において最も効率的な投資になります。'],
                    ['title' => '💰 時間の価値を時給換算で考える',               'text' => '少しの節約のために遠いスーパーを歩き回るより、近い場所で時間を買い、その浮いた時間でITスキルを磨きましょう。自己投資による将来の回収率（ROI）の方が圧倒的に高いからです。'],
                    ['title' => '📝 記録が「無意識の行動」を最適化する',          'text' => '自分が今日「何に時間を使ったか」を記録してみましょう。可視化することで初めて、無駄なスマホ時間や削れるスキマ時間に気づき、学習や開発にリソースを再配分できます。'],
                    ['title' => '📱 スマホとPCの使い分け（CapCutとDaVinci）',    'text' => '作業には適材適所があります。SNS用の気軽な動画はCapCutでサクッと、高品質なカラーコレクションが必要なポートフォリオはDaVinci Resolveで。ツールを分けることで作業のボトルネックが解消します。'],
                    ['title' => '🌐 セブのネット環境サバイバル術',               'text' => 'カフェのWi-Fiが死んだ瞬間に思考を止めないよう、SmartとGlobe両方のSIMを持つのが最強のリスクヘッジです。ロードは常にチャージしておき、シームレスにテザリングへ移行しましょう。'],
                    ['title' => '🎁 心理トリガー「返報性の法則」',               'text' => '人は「先に価値を与えられる」と、無意識にお返しをしたくなる生き物です。あなたが今このスポット情報をシェアしてくれたように、ビジネスでも常に「ギブ」から始めることで信頼が構築されます。'],
                    ['title' => '👀 脳をバグらせる「好奇心」の力',               'text' => 'すべてを説明し尽くすのではなく、あえて「続きが気になる」余白を残すこと。ユーザーに次のアクションを起こさせる最大のモチベーションは「知りたい」という強烈な好奇心です。'],
                    ['title' => '👣 小さな「一貫性」が大きな行動を生む',          'text' => 'まずは「クリックするだけ」「チェックを入れるだけ」といった小さな行動（コミットメント）を促しましょう。人は一度行動を起こすと、その行動に矛盾しないよう、次の大きなステップにも進みやすくなります。'],
                    ['title' => '📸 綺麗すぎる写真より「本物感」',               'text' => 'フリー素材やAIで作られた完璧な画像よりも、スマホで撮られた少し粗のある「リアルな現場の写真」の方が、消費者の警戒心を解き、圧倒的な信頼（オーセンティシティ）を獲得できます。'],
                    ['title' => '👑 迷いを消し去る「権威性」',                   'text' => '「美味しいです」と言うよりも、「15年の実績を持つ焙煎士が淹れた」と伝えること。具体的な数字や専門性（権威）を提示するだけで、説得力は格段に跳ね上がります。'],
                    ['title' => '🎢 滑り台効果（Slippery Slide）',              'text' => '文章を読む際の最初の1行目の目的は「2行目を読ませること」です。視覚的なノイズを削ぎ落とし、流れるように最後まで読ませるUI/UX設計こそが、ユーザーを離脱させない秘訣です。'],
                    ['title' => '🛡️ あえて「欠点」を見せて信頼を買う',           'text' => '「Wi-Fiは速いですが、椅子は硬いです」というように、ポジティブな面だけでなくネガティブな面も隠さず伝えることで、レビュー全体の信憑性が増し、ユーザーとの誠実な関係が築けます。'],
                    ['title' => '🔥 決断を迫る「希少性」',                       'text' => '「いつでも手に入る」と思った瞬間、人は行動を先延ばしにします。期間や数量、あるいは「この情報を知っている人限定」といった制限を設けることで、今すぐ動くべき理由が生まれます。'],
                    ['title' => '👥 他人の行動に同調する「社会的証明」',          'text' => '「私がおすすめします」より「今、このエリアで30人がこのカフェを保存しています」の方が強力です。人は迷った時、自分と似た属性の多くの人が取っている行動を正解だと認識します。'],
                    ['title' => '🎯 顧客の「痛み（ペイン）」に寄り添う',          'text' => 'サービスを作る時は「何を売りたいか」ではなく「ユーザーのどんな悩みを解決できるか」から逆算しましょう。「セブで集中できる場所が見つからない」という痛みを取り除くことこそが、価値の源泉です。'],
                ];

                $selectedTip = $tips[array_rand($tips)];
                $rewardTitle = $selectedTip['title'];
                $rewardText  = $selectedTip['text'];
            }

            return redirect('/')
                ->with('success', '✨ 新しい学習スポットを登録しました！')
                ->with('reward_tip_title', $rewardTitle)
                ->with('reward_tip_text', $rewardText);

        } catch (\Throwable $e) {
            DB::rollback();
            // ✅ 本番ではddではなくエラーレスポンスを返す
            return redirect()->back()
                ->with('error', '登録中にエラーが発生しました。もう一度お試しください。')
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $spot = Spot::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:255',
            'area'            => 'required|string',
            'hours_type'      => 'nullable|in:specified,24h,unknown',
            'open_time'       => 'nullable|string',
            'close_time'      => 'nullable|string',
            'photos'          => 'nullable|array|max:10',
            'photos.*'        => 'file|mimes:jpg,jpeg,png,gif,webp,avif|max:10240',
            'delete_photo_ids'=> 'nullable|array',
            'main_photo_id'   => 'nullable|integer',
        ]);

        if ($request->has('delete_photo_ids')) {
            $photosToDelete = $spot->photos()->whereIn('id', $request->delete_photo_ids)->get();
            foreach ($photosToDelete as $photo) {
                Storage::disk('public')->delete($photo->photo_path);
                $photo->delete();
            }
        }

        if ($request->has('main_photo_id') &&
            (!$request->has('delete_photo_ids') || !in_array($request->main_photo_id, $request->delete_photo_ids))) {

            $mainPhoto = $spot->photos()->find($request->main_photo_id);
            if ($mainPhoto) {
                $mainPhoto->touch();
                $spot->update(['photo_path' => $mainPhoto->photo_path]);
            }
        }

        // ✅ 修正2: update でも hours_type に対応
        $hours = $spot->hours;
        if ($request->filled('hours_type')) {
            if ($request->hours_type === '24h') {
                $hours = '24時間営業';
            } elseif ($request->hours_type === 'unknown') {
                $hours = '不明';
            } else {
                $open  = $request->filled('open_time')  ? $request->open_time  : '未定';
                $close = $request->filled('close_time') ? $request->close_time : '未定';
                $hours = $open . ' - ' . $close;
            }
        } elseif ($request->filled('open_time') || $request->filled('close_time')) {
            $open  = $request->filled('open_time')  ? $request->open_time  : '未定';
            $close = $request->filled('close_time') ? $request->close_time : '未定';
            $hours = $open . ' - ' . $close;
        }

        $spot->update([
            'name'          => $request->name,
            'area'          => $request->area,
            'hours'         => $hours,
            'has_wifi'      => $request->has('has_wifi'),
            'has_power'     => $request->has('has_power'),
            'last_edited_by'=> Auth::id(),
        ]);

        SpotEditHistory::create([
            'spot_id' => $spot->id,
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $filename = uniqid() . '_' . time() . '.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('spots/' . $spot->id, $filename, 'public');

                if (empty($spot->photo_path) && $index === 0) {
                    $spot->update(['photo_path' => $path]);
                }

                $spot->photos()->create([
                    'photo_path' => $path,
                ]);
            }
        }

        return redirect()->route('spots.show', $spot->id)
            ->with('success', '✨ スポット情報を最新に更新しました！');
    }

    public function destroy($id)
    {
        $spot = Spot::findOrFail($id);

        if (Auth::id() !== $spot->user_id) {
            return redirect()->back()->with('error', '削除する権限がありません。');
        }

        try {
            $spot->delete();
            return redirect('/')->with('success', '🗑️ スポットを削除しました。');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', '削除中にエラーが発生しました。');
        }
    }

    public function index(Request $request)
    {
        $query = Spot::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('area', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        if ($request->has('wifi')) {
            $query->where('has_wifi', true);
        }

        if ($request->has('power')) {
            $query->where('has_power', true);
        }

        $sort = $request->input('sort', 'newest');

        // ✅ 修正3: rating_high を平均評価順に正しく実装
        if ($sort === 'rating_high') {
            $query->withAvg('reviews', 'customer_vibe')
                  ->orderByDesc('reviews_avg_customer_vibe');
        } elseif ($sort === 'bookmark_count') {
            $query->withCount('bookmarks')->orderByDesc('bookmarks_count');
        } else {
            // newest（デフォルト）
            $query->latest();
        }

        $spots = $query->paginate(20);

        return view('top', compact('spots'));
    }

    public function show($id)
    {
        $spot = Spot::with(['reviews.user', 'photos', 'editHistories.user'])->findOrFail($id);
        return view('spot_detail', compact('spot'));
    }

    public function useCoupon(Spot $spot)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'ログインが必要です。']);
        }

        if ($spot->isCouponUsedByMonth($user)) {
            return response()->json(['success' => false, 'message' => '今月は既に使用済みです。']);
        }

        DB::table('coupon_usages')->insert([
            'user_id'    => $user->id,
            'spot_id'    => $spot->id,
            'used_at'    => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'クーポンを適用しました！']);
    }
    // 🌟 追加：写真のドラッグ＆ドロップ並び替え処理
    public function reorderPhotos(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:spot_photos,id', // spot_photosテーブルのidチェック
        ]);

        // トランザクションを張って一気に並び順を更新
        DB::transaction(function () use ($request) {
            foreach ($request->ids as $index => $id) {
                DB::table('spot_photos')->where('id', $id)->update([
                    'sort_order' => $index, // 0, 1, 2... と順番に格納
                    'updated_at' => now(),
                ]);
            }
        });

        // 並び替えた結果、0番目（先頭）になった写真のパスをSpot本体のphoto_pathにも同期（トップ画像用）
        $firstPhotoId = $request->ids[0] ?? null;
        if ($firstPhotoId) {
            $firstPhoto = DB::table('spot_photos')->find($firstPhotoId);
            if ($firstPhoto) {
                DB::table('spots')->where('id', $firstPhoto->spot_id)->update([
                    'photo_path' => $firstPhoto->photo_path
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => '並び順を更新しました！']);
    }
}