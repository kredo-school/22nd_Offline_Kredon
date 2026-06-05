<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\BookmarkController;

/*
|--------------------------------------------------------------------------
| 🔓 誰でもアクセスできるページ（ログイン不要）
|--------------------------------------------------------------------------
*/

// 🌟 トップページ（スポット一覧 兼 検索結果）※昨日一本化済み！
Route::get('/', [StudyController::class, 'index'])->name('top');

// 🌟 スポット詳細ページ
Route::get('/spots/{id}', [StudyController::class, 'show'])->name('spots.show');

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

    // 🌟 新規スポット登録（保存処理）
    Route::post('/spots', [SpotController::class, 'store'])->name('spots.store');

    // 🌟 レビュー関連（投稿・更新・削除）
    Route::post('/spots/{spot}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // 🌟 ブックマーク（お気に入り）の追加・解除
    Route::post('/spots/{id}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');

});