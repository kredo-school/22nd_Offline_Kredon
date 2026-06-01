<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpotController; 

Route::get('/', [StudyController::class, 'index']);

Auth::routes();

Route::get('/home' , [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// マイページへのURL設定
Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

// レビュー投稿用のURL（どのスポットに対するレビューかを {spot} で受け取る）
Route::post('/spots/{spot}/reviews', [ReviewController::class, 'store'])->name('reviews.store');


// 新規スポット登録用のURL
Route::post('/spots', [SpotController::class, 'store'])->name('spots.store');


// 🌟 新しいトップページ（Figmaデザイン）への道
Route::get('/', [StudyController::class, 'top'])->name('top');

// 🌟 検索ページ（今日ずっと作っていた画面）への道
Route::get('/search', [StudyController::class, 'index'])->name('search');