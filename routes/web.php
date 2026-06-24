<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GameController;



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
    Route::get('/game', [GameController::class,'home'])
    ->name('game.home');
Route::get('/game/select', [GameController::class,'select'])
    ->name('game.select');

Route::get('/game/stage/easy', [GameController::class,'easy'])
    ->name('game.easy');

Route::get('/game/stage/normal', [GameController::class,'normal'])
    ->name('game.normal');

Route::get('/game/stage/hard', [GameController::class,'hard'])
    ->name('game.hard');

Route::get('/game/stage/oni', [GameController::class,'oni'])
    ->name('game.oni');
Route::get('/game/stage1-1',
    [GameController::class,'stage11'])
    ->name('game.stage11');
    Route::get('/battle', [GameController::class,'battle'])
    ->name('game.battle');
  // routes/web.php
Route::get('/game/stage2', function () {
    return view('game.game2'); // views/game/game2.blade.php を指します
})->name('game.stage2');
Route::get('/game/stage3', function () {
    return view('game.game3');
})->name('game.stage3');
Route::get('/game/boss', function () {
    return view('game.boss');
})->name('game.boss');
Route::get('/game/stage2-1', function () {
    return view('game.stage2-1');
})->name('game.stage2-1');
Route::get('/game/stage2-2', function () { return view('game.stage2-2'); })->name('game.stage2-2');
Route::get('/game/stage2-3', function () { return view('game.stage2-3'); })->name('game.stage2-3');
Route::get('/game/stage2-boss', function () { return view('game.stage2-boss'); })->name('game.stage2-boss');
 

Route::get('/game/stage3-1', function () {
    return view('game.stage3-1');
})->name('game.stage3-1');
Route::get('/game/stage3-2', function () { return view('game.stage3-2'); })->name('game.stage3-2');
Route::get('/game/stage3-3', function () { return view('game.stage3-3'); })->name('game.stage3-3');
Route::get('/game/stage3-boss', function () { return view('game.stage3-boss'); })->name('game.stage3-boss');
Route::get('/game/stageoni', function () {
    return view('game.stageoni'); // views/game/gameoni.blade.php を指します
})->name('game.stageoni');
Route::get('/game/result', function () {
    return view('game.result');
})->name('game.result');
});
