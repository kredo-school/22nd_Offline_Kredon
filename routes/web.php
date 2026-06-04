<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ReviewController;

// 誰でもアクセス可能
Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');

#Review
Route::middleware('auth')->group(function(){

    Route::get('/review', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/review/create', [App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/review/store', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    // Route::get('/review/{review}/edit', [App\Http\Controllers\ReviewController::class, 'edit'])->name('reviews.edit');
    Route::patch('/review/{review}', [App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/review/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
});


// SPOT検索API　（modal)
Route::get('/reviews/search-locations', [ReviewController::class, 'searchLocations'])->name('locations.search');