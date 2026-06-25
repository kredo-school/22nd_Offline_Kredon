<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\TouristSpotController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\TouristReviewController;

Route::get('/', [StudyController::class, 'index'])->name('top');
Route::get('/spots/{id}', [StudyController::class, 'show'])->name('spots.show');

Route::get('/tourist', [TouristSpotController::class, 'index'])->name('tourist_spots.index');
Route::get('/tourist_spots/{id}', [TouristSpotController::class, 'show'])->name('tourist_spots.show');

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

    // 学習スポット
    Route::post('/spots', [SpotController::class, 'store'])->name('spots.store');
    Route::put('/spots/{id}', [SpotController::class, 'update'])->name('spots.update');
    Route::delete('/spots/{id}', [SpotController::class, 'destroy'])->name('spots.destroy');
    Route::post('/spots/{id}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::post('/spots/{spot}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/spots/photos/reorder', [SpotController::class, 'reorderPhotos'])->name('spots.photos.reorder');
    Route::post('/spots/{spot}/coupon', [SpotController::class, 'useCoupon'])->name('spots.coupon.use');

    // 観光スポット
    Route::post('/tourist_spots', [TouristSpotController::class, 'store'])->name('tourist_spots.store');
    Route::put('/tourist_spots/{id}', [TouristSpotController::class, 'update'])->name('tourist_spots.update');
    Route::delete('/tourist_spots/{id}', [TouristSpotController::class, 'destroy'])->name('tourist_spots.destroy');
    Route::post('/tourist_spots/{id}/bookmark', [TouristSpotController::class, 'toggleBookmark'])->name('tourist_bookmarks.toggle');
    Route::post('/tourist_spots/{tourist_spot}/reviews', [TouristReviewController::class, 'store'])->name('tourist_reviews.store');
    Route::put('/tourist_reviews/{review}', [TouristReviewController::class, 'update'])->name('tourist_reviews.update');
    Route::delete('/tourist_reviews/{id}', [TouristReviewController::class, 'destroy'])->name('tourist_reviews.destroy');
});