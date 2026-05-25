<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarketplaceController; // ここを MarketplaceController に変更

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ここも MarketplaceController に変更
Route::get('/market', [MarketplaceController::class, 'index'])->name('marketplace.index');