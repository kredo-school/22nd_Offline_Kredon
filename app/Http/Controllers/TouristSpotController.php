<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TouristSpot;
use App\Models\Review;
use App\Models\TouristBookmark; // 🌟 欠落していたインポートを追加
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TouristSpotController extends Controller
{
  public function store(Request $request)
    {
        // 🌟 観光スポット用のバリデーション（最大10枚・複数画像・AVIF対応）
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'area' => 'required|string',
            'has_activity' => 'nullable|boolean',
            'has_view' => 'nullable|boolean',
            'has_shopping' => 'nullable|boolean',
            'has_food' => 'nullable|boolean',
            'budget' => 'nullable|string|max:255',
            'booking_url' => 'nullable|url',
            'hours_type' => 'required|in:specified,24h,unknown',
            'open_time' => 'nullable|string',
            'close_time' => 'nullable|string',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'file|mimes:jpg,jpeg,png,gif,webp,avif|max:10240',
        ]);

        if ($validator->fails()) {
            // dd('🚨【犯人判明】観光スポット入力チェックで弾かれました！', $validator->errors()->toArray());
        }

        DB::beginTransaction();

        try {
            $touristSpot = new TouristSpot();
            $touristSpot->name = $request->name;
            $touristSpot->area = $request->area;
            $touristSpot->budget = $request->budget;
            $touristSpot->booking_url = $request->booking_url;

            // タグ（チェックボックス）の処理
            $touristSpot->has_activity = $request->has('has_activity');
            $touristSpot->has_view = $request->has('has_view');
            $touristSpot->has_shopping = $request->has('has_shopping');
            $touristSpot->has_food = $request->has('has_food');

            // 営業時間の合体処理
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
            $touristSpot->hours = $hours;
            $touristSpot->user_id = Auth::id();
            
            $touristSpot->save();

            // 複数画像の保存ロジック（最大10枚対応）
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    $filename = uniqid() . '_' . time() . '.' . $photo->getClientOriginalExtension();
                    $path = $photo->storeAs('tourist_spots/' . $touristSpot->id, $filename, 'public');

                    if ($index === 0) {
                        $touristSpot->photo_path = $path;
                        $touristSpot->save();
                    }

                    $touristSpot->photos()->create([
                        'photo_path' => $path
                    ]);
                }
            }

            DB::commit();

            // =========================================================
            // 🌟 観光スポット専用「15%別観光地レコメンド / 85%裏チル情報」ガチャ
            // =========================================================
            
            $chance = rand(1, 100);
            $rewardTitle = '';
            $rewardText = '';

            // 🌟 1. 【15%の確率】同じエリアの「別の観光スポット」をレコメンド
            if ($chance <= 15) {
                $recommendedTourist = \App\Models\TouristSpot::where('area', $request->area)
                                               ->where('id', '!=', $touristSpot->id)
                                               ->inRandomOrder()
                                               ->first();

                if ($recommendedTourist) {
                    $rewardTitle = '🌴 ' . $request->area . 'エリアのおすすめスポット！';
                    $rewardText = "情報ありがとうございます！お礼に、このエリアの別の遊び場をシェアします。\n👉 「{$recommendedTourist->name}」\n次の休みに、ぜひ出かけてみてください！";
                }
            }

            // 🌟 2. 【85%の確率】（または別スポットが無い場合）は「大人のセブ裏チル情報20選」！
            if (empty($rewardTitle)) {
                $tips = [
                    // 💆‍♂️【極上の癒やし・マッサージハック】
                    [ 'title' => '💆‍♂️ モール内の「Blind Massage」はハズレなし', 'text' => 'アヤラやSMなどの各モールにある視覚障害者の方のマッサージ（Blind Massage）は、指先感覚が異常に鋭く、格安なのに技術は超一級品。勉強でガチガチになった肩コリがビビるほど軽くなります。' ],
                    [ 'title' => '😴 Nuat Thaiでは「スウェディッシュ」を選ぶべし', 'text' => '定番のタイ古式（Thai Massage）はバキバキ体を伸ばされますが、極上の睡眠を求めるならオイルを使う「Swedish（スウェディッシュ）」がおすすめ。極上のタッチで施術開始10分で気絶できます。' ],
                    [ 'title' => '🧖‍♂️ ITパークすぐ近くの韓国系スパでデトックス', 'text' => '疲れがピークの週末は、サウナ（チムジルバン）付きの韓国系スパへ。温冷浴を繰り返すことで脳疲労がすっきり抜け、翌週からのIT・英語の学習効率が数倍に跳ね上がります。' ],
                    [ 'title' => '🌟 平日昼間のローカルスパはプロモ天国', 'text' => '多くのスパでは、平日の午前中〜15時頃までにハッピーアワー（割引プロモ）をやっています。週末の混雑を避け、半額近い値段で贅沢な貸切状態の癒やしを味わうのがプロの技。' ],

                    // 🎬【最高のエンタメ・お出かけハック】
                    [ 'title' => '🎬 人混みを避けて映画を観るなら「SM Seaside」', 'text' => 'セブで映画を観るなら、圧倒的にSM Seaside（シーサイド）の映画館がおすすめ。市内中心部から少し離れているため、平日は信じられないほど空いていて、巨大スクリーンをほぼ独占状態で快適に楽しめます。' ],
                    [ 'title' => '電動リクライニング「Director\'s Cut」の贅沢', 'text' => 'アヤラセントラルブロック等の「Director\'s Cut（ディレクターズカット）」は、ふかふかの電動リクライニングシートに足を伸ばし、ポップコーンを食べながら映画に没頭できる大人の秘密基地。自分への極上のご褒美に。' ],
                    [ 'title' => '🚢 船で20分！オランゴ島で日帰りサイクリング', 'text' => 'マクタンの港から公共ボート（約20ペソ）でサクッと行ける「オランゴ島」は最高の現実逃避スポット。港で自転車を借りて、マングローブや鳥の保護区をのんびり走るだけで、南国リゾートをフルに体感できます。' ],
                    [ 'title' => '🌌 トップスまで行かない、ブサイ地区の隠れ家カフェ', 'text' => '展望台「トップス」まで登り切る手前の山道（Busay地区）には、地元民しか知らない夜景の綺麗なローカルカフェが点在しています。静かな夜風に吹かれながら飲むサンミゲルビールは格別です。' ],
                    [ 'title' => 'ベンチでチルする「アヤラの屋上庭園」', 'text' => 'お金をかけずにリフレッシュしたいなら、夕方のアヤラセンターセブ4階のテラス（The Terraces）へ。心地いい夜風とライトアップされた緑に囲まれながら、ただボーッと人間観察をするだけで脳が癒やされます。' ],
                    [ 'title' => '🏖️ 平日の夕方にマクタンのビーチで何もしない贅沢', 'text' => '週末は激混みのマクタンのパブリックビーチも、平日の夕方は静寂そのもの。海の波音（1/fゆらぎ）を聴きながら波打ち際を歩くだけで、日頃のストレスや勉強のプレッシャーが綺麗に消え去ります。' ],

                    // 🍽️【至高の食・リフレッシュハック】
                    [ 'title' => '🥑 濃厚すぎる「アボカド・マンゴー・シェイク」', 'text' => 'モールのスタンドで見かけるアボカドとマンゴーのミックスシェイクは、飲む美容液。ビタミンと良質な脂質がたっぷりで、脳の疲れを一瞬で吹き飛ばしてくれるフィリピン最強のエネルギー源です。' ],
                    [ 'title' => '胃が疲れた夜は「ルガウ（Lugaw）」一択', 'text' => '外食続きで胃が疲れた時は、フィリピン風のチキンお粥「ルガウ」を探しましょう。生姜とにんにくが効いた優しいスープが体に染み渡り、冷房で冷え切った内臓を一気に温めてくれます。' ],
                    [ 'title' => '🍺 地元産クラフトビール「Cebu Brewing」を探せ', 'text' => 'サンミゲルも最高ですが、セブ島発のクラフトビール「Cebu Brewing Company」のビールを見つけたらぜひ飲んでみて。南国らしいフルーティーで奥深い味わいで、大人の週末を贅沢に彩ってくれます。' ],
                    [ 'title' => '🥥 天然のスポーツドリンク「ブコジュース」', 'text' => '屋台で売っている新鮮なヤシの実ジュース（ブコ）は、カリウムや電解質が豊富で「飲む点滴」と呼ばれています。セブの強い日差しで火照った体を内側から効率よくクールダウンしてくれます。' ],

                    // 🤫【もっとマイナーな裏ハック】
                    [ 'title' => '歴史の静寂に隠れる「サンペドロ要塞の中庭」', 'text' => '下町の喧騒に疲れたら、コロン近くのサンペドロ要塞へ。石造りの城壁に囲まれた中庭は、鳥のさえずりしか聞こえない、市内随一の「静寂の聖域」です。ベンチで読書するのに最高の穴場。' ],
                    [ 'title' => '🏨 ホテルの「デイユース（日帰り）」は最強のコスパ', 'text' => '数万円払ってマクタンのリゾートホテルに泊まらなくても、数千ペソの「デイユース（日帰りプラン）」を使えば、高級ホテルのプール、ビーチ、豪華ランチビュッフェを丸ごと1日満喫できます。' ],
                    [ 'title' => '🎨 週末はAS Fortuna周辺のアートギャラリーへ', 'text' => 'カフェ巡りに飽きたら、小規模なローカルアートギャラリーを覗いてみましょう。現地の若手アーティストたちの熱い色彩に触れることで、プログラミングとは違う脳の右脳が刺激され、良い息抜きになります。' ],
                    [ 'title' => '🎶 地元バンドの「アコースティック生演奏」に癒やされる', 'text' => '週末の夜、アヤラ周辺のレストランではアコースティックの生演奏（Live Band）がよく行われています。フィリピン人の圧倒的な歌唱力と心地いいリズムに身を委ねて、最高のリラックスタイムを。' ],
                    [ 'title' => '🌅 朝6時、ITパークの「緑地エリア」を散歩する', 'text' => '昼間は渋滞と人で賑わうITパークも、日曜日などの早朝は静まり返っています。ザ・ウォーク周辺の並木道をのんびり歩く「ノイズレスな時間」は、自分を見つめ直す最高の贅沢です。' ],
                    [ 'title' => '🛒 スーパーの「お惣菜コーナー」のフィリピンおやつ', 'text' => 'メトロスーパーなどの奥にあるローカルおやつコーナーの「ウトン（Puto）」や「クチンタ」は、モチモチした優しい甘さの伝統蒸しパン。お茶請けに最高で、脳に優しい糖分を補給できます。' ],
                ];

                // 20個の中からランダムで1つ選ぶ
                $selectedTip = $tips[array_rand($tips)];
                $rewardTitle = $selectedTip['title'];
                $rewardText  = $selectedTip['text'];
            }

            // 🌟 3. 引いたガチャの結果を「観光スポット一覧」へ投げる！
            return redirect()->route('tourist_spots.index')
                ->with('success', '✨ 新しい観光スポットを登録しました！')
                ->with('reward_tip_title', $rewardTitle)
                ->with('reward_tip_text', $rewardText);

        } catch (\Throwable $e) {
            DB::rollback();
            dd('🚨【原因判明】観光スポット登録でエラー発生！', $e->getMessage(), '行番号: ' . $e->getLine());
        }
    }

    public function update(Request $request, $id)
    {
        // ① 入力チェック（予約URLを追加）
        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'required|string',
            'budget' => 'nullable|string',
            'booking_url' => 'nullable|url', // 🌟 追加：URL形式チェック
            'hours' => 'nullable|string',
            'photo' => 'nullable|image|max:10240',
        ]);

        $tourist_spot = TouristSpot::findOrFail($id);

        // ② セキュリティ
        if ($tourist_spot->user_id !== Auth::id()) {
            return redirect()->route('tourist_spots.index')->with('error', '編集権限がありません。');
        }

        // ③ データの更新
        $tourist_spot->name = $request->name;
        $tourist_spot->area = $request->area;
        $tourist_spot->budget = $request->budget;
        $tourist_spot->booking_url = $request->booking_url; // 🌟 追加：予約URLを更新
        $tourist_spot->hours = $request->hours;

        $tourist_spot->has_activity = $request->has('has_activity');
        $tourist_spot->has_view     = $request->has('has_view');
        $tourist_spot->has_shopping = $request->has('has_shopping');
        $tourist_spot->has_food     = $request->has('has_food');

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = uniqid() . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('tourist_spots/' . $tourist_spot->id, $filename, 'public');
            $tourist_spot->photo_path = $path;
        }

        $tourist_spot->save();

        return redirect()->route('tourist_spots.show', $tourist_spot->id)
            ->with('success', '✨ 観光スポットの情報を更新しました！');
    }

    public function index(Request $request)
    {
        // 星の平均点も一緒に取得
        $query = TouristSpot::withAvg('reviews', 'rating');

        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('area', 'LIKE', "%{$keyword}%");
            });
        }

        // エリア検索
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        // ========================================================
        // 🌟 ここから追加：体験タグでの絞り込み
        // ========================================================
        if ($request->has('activity')) {
            $query->where('has_activity', true);
        }
        if ($request->has('view')) {
            $query->where('has_view', true);
        }
        if ($request->has('shopping')) {
            $query->where('has_shopping', true);
        }
        if ($request->has('food')) {
            $query->where('has_food', true);
        }
        // ========================================================

        // 並び替え（人気順 or 新着順）
        $sort = $request->input('sort', 'newest');
        if ($sort === 'bookmark_count') {
            $query->withCount('bookmarks')->orderBy('bookmarks_count', 'desc');
        } else {
            $query->latest();
        }

        $tourist_spots = $query->paginate(20);

        return view('tourist_top', compact('tourist_spots'));
    }

    public function show($id)
    {
        // 🌟 進化ポイント1：スポット情報と一緒に「星の平均点(avg)」と「クチコミ件数(count)」も取得！
        $tourist_spot = TouristSpot::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->findOrFail($id);

        // 🌟 進化ポイント2：このスポットに投稿されたクチコミ一覧を最新順で取得！
        $reviews = $tourist_spot->reviews()->latest()->get();

        // 🌟 取得したデータを画面に渡す（$reviews を追加）
        return view('tourist_spot_detail', compact('tourist_spot', 'reviews'));
    }

    public function destroy($id)
    {
        $tourist_spot = TouristSpot::findOrFail($id);

        if ($tourist_spot->user_id !== Auth::id()) {
            return redirect()->route('tourist_spots.index')->with('error', '削除権限がありません。');
        }

        $tourist_spot->delete();

        return redirect()->route('tourist_spots.index')
            ->with('success', '🗑️ 観光スポットを削除しました。');
    }

    public function toggleBookmark($id)
    {
        $userId = Auth::id();

        $bookmark = TouristBookmark::where('user_id', $userId)
            ->where('tourist_spot_id', $id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return back()->with('success', '🤍 お気に入りから外しました。');
        } else {
            TouristBookmark::create([
                'user_id' => $userId,
                'tourist_spot_id' => $id
            ]);
            return back()->with('success', '❤️ お気に入りに登録しました！');
        }
    }
    // =========================================================
    // 🌟 観光スポット：クチコミ保存処理
    // =========================================================
    public function storeReview(Request $request, $id)
    {
        // ① 入力されたデータのチェック
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // ② どの観光スポットに対するクチコミかを探す
        $touristSpot = \App\Models\TouristSpot::findOrFail($id);

        // ③ クチコミをデータベースに保存
        $touristSpot->reviews()->create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // ④ 元の詳細ページへ戻る
        return redirect()->route('tourist_spots.show', $id)
            ->with('success', '✨ クチコミを投稿しました！');
    }
}
