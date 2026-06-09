<?php
use App\Models\TouristBookmark;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\TouristSpotController; // 🌟 観光コントローラー
use App\Http\Controllers\BookmarkController;

/*
|--------------------------------------------------------------------------
| 🌐 誰でも見られるページ（ログイン不要）
|--------------------------------------------------------------------------
*/

// --- 1階：学習スポット ---
// 🌟 トップページ（スポット一覧 兼 検索結果）
Route::get('/', [StudyController::class, 'index'])->name('top');
// 🌟 スポット詳細ページ
Route::get('/spots/{id}', [StudyController::class, 'show'])->name('spots.show');


// --- 2階：観光スポット（🌟新しく追加！） ---
// 🌟 観光トップページ（URLがぶつからないように /tourist に設定）
Route::get('/tourist', [TouristSpotController::class, 'index'])->name('tourist_spots.index');
// 🌟 観光スポット詳細ページ
Route::get('/tourist_spots/{id}', [TouristSpotController::class, 'show'])->name('tourist_spots.show');


/*
|--------------------------------------------------------------------------
| 🔐 ログイン関連（Laravel標準）
|--------------------------------------------------------------------------
*/
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');


/*
|--------------------------------------------------------------------------
| 🛡️ ログインしている人だけが使える機能（authミドルウェアの関所）
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // 🌟 マイページ
    Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

    // ==========================================
    // 1階：学習スポット用の管理機能
    // ==========================================
    // 新規スポット登録（保存処理）
    Route::post('/spots', [SpotController::class, 'store'])->name('spots.store');
    // スポット情報の更新
    Route::put('/spots/{id}', [SpotController::class, 'update'])->name('spots.update');
    // ブックマーク（お気に入り）の追加・解除
    Route::post('/spots/{id}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    // レビュー関連（投稿・更新・削除）
    Route::post('/spots/{spot}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');


    // ==========================================
    // 2階：観光スポット用の管理機能（🌟新しく追加！）
    // ==========================================
    // 🌟 新規観光スポット登録（保存処理）
    Route::post('/tourist_spots', [TouristSpotController::class, 'store'])->name('tourist_spots.store');
    // 🌟 観光スポット情報の更新
    Route::put('/tourist_spots/{id}', [TouristSpotController::class, 'update'])->name('tourist_spots.update');
    // 🌟 観光スポット情報の削除
    Route::delete('/tourist_spots/{id}', [TouristSpotController::class, 'destroy'])->name('tourist_spots.destroy');
    Route::post('/tourist_spots/{id}/bookmark', [App\Http\Controllers\TouristSpotController::class, 'toggleBookmark'])->name('tourist_bookmarks.toggle');
    // 🌟 コントローラーを丸ごと複製したため、観光用のブックマークやクチコミの保存処理も動くようにルートを開通させておきます
    Route::post('/tourist_spots/{id}/bookmark', [TouristSpotController::class, 'toggleBookmark'])->name('tourist_bookmarks.toggle');
    Route::post('/tourist_spots/{tourist_spot}/reviews', [TouristSpotController::class, 'storeReview'])->name('tourist_reviews.store');
    Route::put('/tourist_reviews/{review}', [TouristSpotController::class, 'updateReview'])->name('tourist_reviews.update');
    Route::delete('/tourist_reviews/{review}', [TouristSpotController::class, 'destroyReview'])->name('tourist_reviews.destroy');
    // 🌟 観光スポット：クチコミ投稿＆削除
    Route::post('/tourist_spots/{tourist_spot}/reviews', [App\Http\Controllers\TouristReviewController::class, 'store'])->name('tourist_reviews.store');
    Route::delete('/tourist_reviews/{id}', [App\Http\Controllers\TouristReviewController::class, 'destroy'])->name('tourist_reviews.destroy');
});