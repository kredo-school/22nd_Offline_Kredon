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
use App\Http\Controllers\TouristReviewController;
use App\Http\Controllers\NotificationsController; // User Notification Controller

// #Admin Controller (Aimiさん達のコード)
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\MarketsController;
use App\Http\Controllers\Admin\AnalysisController;
use App\Http\Controllers\Admin\NotificationsController as AdminNotificationsController;
use App\Http\Controllers\Admin\NotificationTemplateController;
use App\Http\Controllers\Admin\SpotsController as AdminSpotsController;

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
// 🌟 観光トップページ
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
    Route::post('/spots', [SpotController::class, 'store'])->name('spots.store');
    Route::put('/spots/{id}', [SpotController::class, 'update'])->name('spots.update');
    Route::delete('/spots/{id}', [SpotController::class, 'destroy'])->name('spots.destroy');
    Route::post('/spots/photos/reorder', [SpotController::class, 'reorderPhotos'])->name('spots.photos.reorder');
    Route::post('/spots/{id}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::post('/spots/{spot}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/spots/{spot}/coupon', [SpotController::class, 'useCoupon'])->name('spots.coupon.use');
    
    // ==========================================
    // 2階：観光スポット用の管理機能
    // ==========================================
    Route::post('/tourist_spots', [TouristSpotController::class, 'store'])->name('tourist_spots.store');
    Route::put('/tourist_spots/{id}', [TouristSpotController::class, 'update'])->name('tourist_spots.update');
    Route::delete('/tourist_spots/{id}', [TouristSpotController::class, 'destroy'])->name('tourist_spots.destroy');
    Route::post('/tourist_spots/{id}/bookmark', [TouristSpotController::class, 'toggleBookmark'])->name('tourist_bookmarks.toggle');
    Route::post('/tourist_spots/{tourist_spot}/reviews', [TouristSpotController::class, 'storeReview'])->name('tourist_reviews.store');
    Route::put('/tourist_reviews/{review}', [TouristSpotController::class, 'updateReview'])->name('tourist_reviews.update');
    Route::delete('/tourist_reviews/{review}', [TouristSpotController::class, 'destroyReview'])->name('tourist_reviews.destroy');

    // ==========================================
    // ユーザー通知機能
    // ==========================================
    Route::post('/notifications/mark-all-read', [NotificationsController::class, 'markAllRead'])->name('notifications.mark-all-read');

    /*
    |--------------------------------------------------------------------------
    | 🛡️ 管理者（Admin）専用機能
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('users', [UsersController::class, 'index'])->name('users.index');
        Route::get('events', [EventsController::class, 'index'])->name('events.index');
        Route::get('reviews', [ReviewsController::class, 'index'])->name('reviews.index');
        Route::get('markets', [MarketsController::class, 'index'])->name('markets.index');
        Route::get('markets/show/{id}', [MarketsController::class, 'show'])->name('markets.show');
        Route::get('analysis', [AnalysisController::class, 'index'])->name('analysis.index');
        Route::get('spots', [AdminSpotsController::class, 'index'])->name('spots.index');

        // Notifications (Admin)
        Route::patch('/notifications/{notification}/status', [AdminNotificationsController::class, 'updateStatus'])->name('notifications.update-status');
        Route::post('/notifications/mark-all-read', [AdminNotificationsController::class, 'markAllRead'])->name('notifications.mark-all-read');
        Route::resource('notifications', AdminNotificationsController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::resource('notification-templates', NotificationTemplateController::class)->only(['store', 'update', 'destroy'])->names('notification-templates');
    });
});