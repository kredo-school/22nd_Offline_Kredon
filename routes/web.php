<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\HomeController;
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])
    ->name('home');
Route::get('/market', [MarketplaceController::class, 'index'])
    ->name('marketplace.index');
Route::get('/market/create', [MarketplaceController::class, 'create'])
    ->name('marketplace.create');
Route::post('/market/store', [MarketplaceController::class, 'store'])
    ->name('marketplace.store');
Route::get('/market/{item}', [MarketplaceController::class,'show'])
    ->name('marketplace.show');
 Route::get('/event', function () {
    return view('event.index');
})->name('event.index');

