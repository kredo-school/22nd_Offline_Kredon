<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\BookmarkController;



// 🌟 トップページ（スポット一覧）
Route::get('/', [StudyController::class, 'index'])->name('top');

// 🌟 検索機能
Route::get('/search', [StudyController::class, 'search'])->name('search');

// 🌟 スポット詳細ページ
Route::get('/spots/{id}', [StudyController::class, 'show'])->name('spots.show');

// 🌟 新規スポット登録
Route::post('/spots', [SpotController::class, 'store'])->name('spots.store');

// 🌟 レビュー投稿
Route::post('/spots/{spot}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// 🌟 ブックマーク（お気に入り）の追加・解除
Route::post('/spots/{id}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');

// 🌟 マイページ
Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

// --- ログイン関連（Laravel標準） ---
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
// 🌟 追加：レビュー削除ルート
Route::delete('/reviews/{id}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');