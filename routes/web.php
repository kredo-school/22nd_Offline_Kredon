<?php

use App\Models\TouristBookmark;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

#User Controller
use App\Http\Controllers\NotificationsController as UserNotificationController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GameController;


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

require __DIR__.'/setting.php';

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
// Route::get('/home', [HomeController::class, 'index'])->name('home');

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


#Market
Route::get('/market', [MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('/market/create', [MarketplaceController::class, 'create'])->name('marketplace.create');
Route::post('/market/store', [MarketplaceController::class, 'store'])->name('marketplace.store');
Route::get('/market/{item}', [MarketplaceController::class, 'show'])->name('marketplace.show');


Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
Route::get('/event/{event}', [EventController::class, 'show'])->name('event.show');

Route::middleware('auth')->group(function () {

    // ユーザーとのチャット開始
    Route::get(
        '/chat/user/{user}',
        [ChatController::class, 'index']
    )
        ->name('chat.index');

    // メッセージ送信
    Route::post(
        '/chat/send',
        [ChatController::class, 'store']
    )
        ->name('chat.store');

    // チャットルーム表示
    Route::get(
        '/chat/room/{chat}',
        [ChatController::class, 'show']
    )
        ->name('chat.show');

    // チャットルーム送信
    Route::post(
        '/chat/room/{chat}/send',
        [ChatController::class, 'send']
    )
        ->name('chat.send');

    Route::get(
        '/messages',
        [ChatController::class, 'list']
    )
        ->name('chat.list');
    Route::get('/game', [GameController::class, 'home'])
        ->name('game.home');
    Route::get('/game/select', [GameController::class, 'select'])
        ->name('game.select');

    Route::get('/game/stage/easy', [GameController::class, 'easy'])
        ->name('game.easy');

    Route::get('/game/stage/normal', [GameController::class, 'normal'])
        ->name('game.normal');

    Route::get('/game/stage/hard', [GameController::class, 'hard'])
        ->name('game.hard');

    Route::get('/game/stage/oni', [GameController::class, 'oni'])
        ->name('game.oni');
    Route::get(
        '/game/stage1-1',
        [GameController::class, 'stage11']
    )
        ->name('game.stage11');
    Route::get('/battle', [GameController::class, 'battle'])
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
    Route::get('/game/stage2-2', function () {
        return view('game.stage2-2');
    })->name('game.stage2-2');
    Route::get('/game/stage2-3', function () {
        return view('game.stage2-3');
    })->name('game.stage2-3');
    Route::get('/game/stage2-boss', function () {
        return view('game.stage2-boss');
    })->name('game.stage2-boss');


    Route::get('/game/stage3-1', function () {
        return view('game.stage3-1');
    })->name('game.stage3-1');
    Route::get('/game/stage3-2', function () {
        return view('game.stage3-2');
    })->name('game.stage3-2');
    Route::get('/game/stage3-3', function () {
        return view('game.stage3-3');
    })->name('game.stage3-3');
    Route::get('/game/stage3-boss', function () {
        return view('game.stage3-boss');
    })->name('game.stage3-boss');
    Route::get('/game/stageoni', function () {
        return view('game.stageoni'); // views/game/gameoni.blade.php を指します
    })->name('game.stageoni');
    Route::get('/game/result', function () {
        return view('game.result');
    })->name('game.result');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
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
    Route::post('/spots/{id}/5', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
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

    // ユーザー通知
    // Route::post('/notifications/mark-all-read', [NotificationsController::class, 'markAllRead'])->name('notifications.mark-all-read');
});


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
        Route::patch('users/{id}/role', [App\Http\Controllers\Admin\UsersController::class, 'updateRole'])->name('users.update-role');
        Route::patch('users/{id}/status', [App\Http\Controllers\Admin\UsersController::class, 'updateStatus'])->name('users.update-status');

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
        Route::patch('/spots/{type}/{id}/status', [\App\Http\Controllers\Admin\SpotsController::class, 'updateStatus'])
            ->name('spots.updateStatus');

        #Notification
        Route::patch('/notifications/{notification}/status', [ App\Http\Controllers\Admin\NotificationsController::class, 'updateStatus'])
            ->name('notifications.update-status');

        Route::post('/notifications/mark-all-read', [ App\Http\Controllers\Admin\NotificationsController::class, 'markAllRead'])
            ->name('notifications.mark-all-read');

        Route::resource('notifications', \App\Http\Controllers\Admin\NotificationsController::class)
            ->only(['index', 'store', 'edit', 'update', 'destroy']);

        Route::resource('notification-templates', NotificationTemplateController::class)
            ->only(['store', 'update', 'destroy'])
            ->names('notification-templates');
    });
});
