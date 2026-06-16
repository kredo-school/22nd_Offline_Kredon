<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ChatController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// =====================
// MARKET
// =====================
Route::get('/market', [MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('/market/create', [MarketplaceController::class, 'create'])->name('marketplace.create');
Route::post('/market/store', [MarketplaceController::class, 'store'])->name('marketplace.store');
Route::get('/market/{item}', [MarketplaceController::class, 'show'])->name('marketplace.show');

// =====================
// EVENT
// =====================
Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
Route::get('/event/{event}', [EventController::class, 'show'])->name('event.show');
Route::middleware('auth')->group(function () {

});
Route::middleware('auth')->group(function () {

    // ユーザーとのチャット開始
    Route::get('/chat/user/{user}',
        [ChatController::class,'index'])
        ->name('chat.index');

    // メッセージ送信
    Route::post('/chat/send',
        [ChatController::class,'store'])
        ->name('chat.store');

    // チャットルーム表示
    Route::get('/chat/room/{chat}',
        [ChatController::class,'show'])
        ->name('chat.show');

    // チャットルーム送信
    Route::post('/chat/room/{chat}/send',
        [ChatController::class,'send'])
        ->name('chat.send');

    Route::get('/messages',
    [ChatController::class,'list'])
    ->name('chat.list');
});
