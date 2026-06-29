<?php

use App\Models\TouristBookmark;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

#User Controller
use App\Http\Controllers\NotificationsController as UserNotificationController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AllReviewController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\TouristSpotController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\TouristReviewController;
use App\Http\Controllers\NotificationsController;

#Admin Controller
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\MarketsController;
use App\Http\Controllers\Admin\AnalysisController;
use App\Http\Controllers\Admin\NotificationsController as AdminNotificationsController;
use App\Http\Controllers\Admin\NotificationTemplateController;
use App\Http\Controllers\Admin\SpotsController;
use App\Http\Controllers\Admin\SpotsController as AdminSpotsController;


// 誰でもアクセス可能
Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| 🌐 誰でも見られるページ（ログイン不要）
|--------------------------------------------------------------------------
*/
// --- 1階：学習スポット ---
Route::get('/', [StudyController::class, 'index'])->name('top');
Route::get('/spots/{id}', [StudyController::class, 'show'])->name('spots.show');

// --- 2階：観光スポット ---
Route::get('/tourist', [TouristSpotController::class, 'index'])->name('tourist_spots.index');
Route::get('/tourist_spots/{id}', [TouristSpotController::class, 'show'])->name('tourist_spots.show');

/*
|--------------------------------------------------------------------------
| 🔐 ログイン関連
|--------------------------------------------------------------------------
*/
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');

#Review
Route::middleware('auth')->group(function () {
    Route::get('/review', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/review/create', [App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/review/{id}/store', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    // Route::get('/review/{review}/edit', [App\Http\Controllers\ReviewController::class, 'edit'])->name('reviews.edit');
    Route::patch('/review/{review}', [App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/review/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
});

# SPOT検索API　（modal-Aimi)
Route::get('/reviews/search-locations', [AllReviewController::class, 'searchLocations'])->name('locations.search');
/*
|--------------------------------------------------------------------------
| 🛡️ ログインしている人だけが使える機能
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

    // 学習スポット
    Route::post('/spots', [SpotController::class, 'store'])->name('spots.store');
    Route::put('/spots/{id}', [SpotController::class, 'update'])->name('spots.update');
    Route::delete('/spots/{id}', [SpotController::class, 'destroy'])->name('spots.destroy');
    Route::post('/spots/photos/reorder', [SpotController::class, 'reorderPhotos'])->name('spots.photos.reorder');
    Route::post('/spots/{id}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::post('/spots/{spot}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/spots/{spot}/coupon', [SpotController::class, 'useCoupon'])->name('spots.coupon.use');

    // 観光スポット
    Route::post('/tourist_spots', [TouristSpotController::class, 'store'])->name('tourist_spots.store');
    Route::put('/tourist_spots/{id}', [TouristSpotController::class, 'update'])->name('tourist_spots.update');
    Route::delete('/tourist_spots/{id}', [TouristSpotController::class, 'destroy'])->name('tourist_spots.destroy');
    Route::post('/tourist_spots/{id}/bookmark', [TouristSpotController::class, 'toggleBookmark'])->name('tourist_bookmarks.toggle');
    Route::post('/tourist_spots/{tourist_spot}/reviews', [TouristSpotController::class, 'storeReview'])->name('tourist_reviews.store');
    Route::put('/tourist_reviews/{review}', [TouristSpotController::class, 'updateReview'])->name('tourist_reviews.update');
    Route::delete('/tourist_reviews/{review}', [TouristSpotController::class, 'destroyReview'])->name('tourist_reviews.destroy');

    // User
    #notification
    Route::post('/notifications/mark-all-read', [UserNotificationController::class, 'markAllRead'])
        ->name('notifications.mark-all-read');


    // All Review (Aimi)
    Route::get('/all_reviews', [App\Http\Controllers\AllReviewController::class, 'index'])->name('all_reviews.index');
    Route::get('/all_reviews/create', [App\Http\Controllers\AllReviewController::class, 'create'])->name('all_reviews.create');
    Route::post('/all_reviews/store', [App\Http\Controllers\AllReviewController::class, 'store'])->name('all_reviews.store');
    // Route::get('/review/{review}/edit', [App\Http\Controllers\AllReviewController::class, 'edit'])->name('reviews.edit');
    Route::patch('/all_reviews/{review}/update', [App\Http\Controllers\AllReviewController::class, 'update'])->name('all_reviews.update');
    Route::delete('/all_reviews/{review}/delete', [App\Http\Controllers\AllReviewController::class, 'destroy'])->name('all_reviews.destroy');


    //Admin
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {

            #Dashboard
            Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

            #Users
            Route::get('users', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('users.index');

            #Events
            Route::get('events', [App\Http\Controllers\Admin\EventsController::class, 'index'])->name('events.index');

            #Reviews
            Route::get('reviews', [App\Http\Controllers\Admin\ReviewsController::class, 'index'])->name('reviews.index');

            #Markets
            Route::get('markets', [App\Http\Controllers\Admin\MarketsController::class, 'index'])->name('markets.index');
            Route::get('markets/show/{id}', [App\Http\Controllers\Admin\MarketsController::class, 'show'])->name('markets.show');

            #Analysis
            Route::get('analysis', [App\Http\Controllers\Admin\AnalysisController::class, 'index'])->name('analysis.index');

            #Spots
            Route::get('spots', [App\Http\Controllers\Admin\SpotsController::class, 'index'])->name('spots.index');

            #Notification
            Route::patch('/notifications/{notification}/status', [NotificationsController::class, 'updateStatus'])
                ->name('notifications.update-status');

            Route::post('/notifications/mark-all-read', [NotificationsController::class, 'markAllRead'])
                ->name('notifications.mark-all-read');

            Route::resource('notifications', \App\Http\Controllers\Admin\NotificationsController::class)
                ->only(['index', 'store', 'edit', 'update', 'destroy']);

            Route::resource('notification-templates', NotificationTemplateController::class)
                ->only(['store', 'update', 'destroy'])
                ->names('notification-templates');
        });
    });
});
