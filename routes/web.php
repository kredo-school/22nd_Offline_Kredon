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
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventParticipantController;
use App\Http\Controllers\GroupChatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AllReviewController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\TouristSpotController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\TouristReviewController;
use App\Http\Controllers\MarketCommentController;

use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\WizardController;
use App\Http\Controllers\HealthcareController;
use App\Http\Controllers\HospitalBookmarkController;
use App\Http\Controllers\HospitalImageController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InterestedController;
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
use App\Http\Controllers\Admin\HospitalController as AdminHospitalController;

require __DIR__ . '/setting.php';

Route::get('/', [StudyController::class, 'index'])->name('top');
Route::get('/spots/{id}', [StudyController::class, 'show'])->name('spots.show');
Route::get('/tourist', [TouristSpotController::class, 'index'])->name('tourist_spots.index');
Route::get('/tourist_spots/{id}', [TouristSpotController::class, 'show'])->name('tourist_spots.show');

Auth::routes();

// homepage
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// hospital
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])
    ->name('locale.switch')
    ->whereIn('locale', ['ja', 'en']);

Route::middleware(\App\Http\Middleware\SetHealthcareLocale::class)->group(function () {
    Route::get('/healthcare', [HealthcareController::class, 'index'])->name('healthcare.index');

    Route::prefix('wizard')->group(function () {
        Route::get('/', [WizardController::class, 'start'])->name('wizard.start');
        Route::get('/step/{step}', [WizardController::class, 'show'])->name('wizard.step');
        Route::post('/step/{step}', [WizardController::class, 'store'])->name('wizard.step.store');
        Route::get('/result', [WizardController::class, 'result'])->name('wizard.result');
    });
});

Route::post('/hospitals/{hospitalId}/images', [HospitalImageController::class, 'store'])->name('hospital_images.store');

Route::middleware('auth')->group(function () {
    Route::post('/hospital-bookmarks/{hospital}', [HospitalBookmarkController::class, 'store'])->name('hospital_bookmarks.store');
    Route::delete('/hospital-bookmarks/{hospital}', [HospitalBookmarkController::class, 'destroy'])->name('hospital_bookmarks.destroy');

    #Review
    Route::get('/review', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/review/create', [ReviewController::class, 'create'])->name('reviews.create');
    // Route::post('/review/{id}/store', [ReviewController::class, 'store'])->name('reviews.store');
    Route::patch('/review/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

#Spot検索（modal-aimi)
Route::get('/reviews/search-locations', [AllReviewController::class, 'searchLocations'])->name('locations.search');

Route::get('/market', [MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('/market/create', [MarketplaceController::class, 'create'])->name('marketplace.create');
Route::post('/market/store', [MarketplaceController::class, 'store'])->name('marketplace.store');
Route::get('/market/{item}', [MarketplaceController::class, 'show'])->name('marketplace.show');


Route::post('/market/{item}/available', [MarketplaceController::class, 'available'])
    ->name('market.available')
    ->middleware('auth');

Route::post('/market/{item}/sold', [MarketplaceController::class, 'sold'])
    ->name('market.sold')
    ->middleware('auth');
Route::resource('event', EventController::class);
Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
Route::get('/event/{event}', [EventController::class, 'show'])->name('event.show');

Route::middleware('auth')->group(function () {
    Route::get('/chat/user/{user}', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/room/{chat}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/room/{chat}/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/messages', [ChatController::class, 'list'])->name('chat.list');


    Route::post(
        '/market/{item}/comment',
        [MarketCommentController::class, 'store']
    )->name('market.comment.store');

    Route::delete(
        '/market/comment/{comment}',
        [MarketCommentController::class, 'destroy']
    )->name('market.comment.destroy');
    Route::post(
        '/report/item/{item}',
        [ReportController::class, 'reportItem']
    )
        ->name('report.market.item');

    Route::post(
        '/report/comment/{comment}',
        [ReportController::class, 'reportMarketComment']
    )
        ->name('report.market.comment');
    Route::get('/market/{item}/edit', [MarketplaceController::class, 'edit'])
        ->name('marketplace.edit');

    Route::put('/market/{item}', [MarketplaceController::class, 'update'])
        ->name('marketplace.update');

    // メッセージ送信
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.store');

    // チャットルーム表示
    Route::get('/chat/room/{chat}', [ChatController::class, 'show'])->name('chat.show');

    // チャットルーム送信
    Route::post('/chat/room/{chat}/send', [ChatController::class, 'send'])->name('chat.send');

    Route::get('/messages', [ChatController::class, 'list'])->name('chat.list');

    #Game
    Route::get('/game', [GameController::class, 'home'])->name('game.home');
    Route::get('/game/select', [GameController::class, 'select'])->name('game.select');

    Route::get('/game/stage/easy', [GameController::class, 'easy'])->name('game.easy');
    Route::get('/game/stage/normal', [GameController::class, 'normal'])->name('game.normal');
    Route::get('/game/stage/hard', [GameController::class, 'hard'])->name('game.hard');

    Route::get('/game/stage/oni', [GameController::class, 'oni'])->name('game.oni');
    Route::get('/game/stage1-1',  [GameController::class, 'stage11'])->name('game.stage11');
    Route::get('/battle', [GameController::class, 'battle'])->name('game.battle');
    // routes/web.php
    Route::get('/game/stage2', function () {
        return view('game.game2'); // views/game/game2.blade.php を指します    })->name('game.stage2');
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

        #Event
        Route::post('/event/{event}/comment', [CommentController::class, 'store'])
            ->name('comment.store')
            ->middleware('auth');
        Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])
            ->name('comment.destroy');
        Route::post(
            '/event/{event}/join',
            [EventParticipantController::class, 'join']
        )->name('event.join');

        Route::delete('/event/{event}/leave', [EventParticipantController::class, 'leave'])->name('event.leave');
        Route::get(
            '/event/{event}/participants',
            [EventController::class, 'participants']
        )
            ->name('event.participants');
        Route::get(
            '/private-chat/{user}',
            [ChatController::class, 'private']
        )
            ->name('chat.private');
        Route::get(
            '/group-chat/{event}',
            [ChatController::class, 'group']
        )
            ->name('chat.group');
        Route::middleware('auth')->group(function () {

            Route::get(
                '/group-chat/{event}',
                [GroupChatController::class, 'show']
            )->name('group.chat');

            Route::post(
                '/group-chat/{event}/send',
                [GroupChatController::class, 'send']
            )->name('group.chat.send');
            Route::get(
                '/group-chat/{event}/fetch',
                [GroupChatController::class, 'fetch']
            )->name('group.chat.fetch');
            Route::get(
                '/group-chat/{event}/members',
                [GroupChatController::class, 'members']
            )->name('group.chat.members');
            Route::get(
                '/group-chat/{event}/members',
                [GroupChatController::class, 'members']
            )->name('group.chat.members');
        });
        Route::post(
            '/report/message/{message}',
            [ReportController::class, 'reportMessage']
        )->name('report.message');

        Route::post(
            '/report/group/{message}',
            [ReportController::class, 'reportGroup']
        )->name('report.group');
        Route::post('/market/{item}/interested', [InterestedController::class, 'toggle'])
            ->name('market.interested')
            ->middleware('auth');
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

        /*
|--------------------------------------------------------------------------
| 🛡️ ログインしている人だけが使える機能
|--------------------------------------------------------------------------
*/
        Route::get('/game', [GameController::class, 'home'])->name('game.home');
        Route::get('/game/select', [GameController::class, 'select'])->name('game.select');
        Route::get('/game/stage/easy', [GameController::class, 'easy'])->name('game.easy');
        Route::get('/game/stage/normal', [GameController::class, 'normal'])->name('game.normal');
        Route::get('/game/stage/hard', [GameController::class, 'hard'])->name('game.hard');
        Route::get('/game/stage/oni', [GameController::class, 'oni'])->name('game.oni');
        Route::get('/game/stage1-1', [GameController::class, 'stage11'])->name('game.stage11');
        Route::get('/battle', [GameController::class, 'battle'])->name('game.battle');
        Route::get('/game/stage2', fn() => view('game.game2'))->name('game.stage2');
        Route::get('/game/stage3', fn() => view('game.game3'))->name('game.stage3');
        Route::get('/game/boss', fn() => view('game.boss'))->name('game.boss');
        Route::get('/game/stage2-1', fn() => view('game.stage2-1'))->name('game.stage2-1');
        Route::get('/game/stage2-2', fn() => view('game.stage2-2'))->name('game.stage2-2');
        Route::get('/game/stage2-3', fn() => view('game.stage2-3'))->name('game.stage2-3');
        Route::get('/game/stage2-boss', fn() => view('game.stage2-boss'))->name('game.stage2-boss');
        Route::get('/game/stage3-1', fn() => view('game.stage3-1'))->name('game.stage3-1');
        Route::get('/game/stage3-2', fn() => view('game.stage3-2'))->name('game.stage3-2');
        Route::get('/game/stage3-3', fn() => view('game.stage3-3'))->name('game.stage3-3');
        Route::get('/game/stage3-boss', fn() => view('game.stage3-boss'))->name('game.stage3-boss');
        Route::get('/game/stageoni', fn() => view('game.stageoni'))->name('game.stageoni');
        Route::get('/game/result', fn() => view('game.result'))->name('game.result');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

        // working, tourism posts
        Route::post('/spots', [SpotController::class, 'store'])->name('spots.store');
        Route::put('/spots/{id}', [SpotController::class, 'update'])->name('spots.update');
        Route::delete('/spots/{id}', [SpotController::class, 'destroy'])->name('spots.destroy');
        Route::post('/spots/photos/reorder', [SpotController::class, 'reorderPhotos'])->name('spots.photos.reorder');
        Route::post('/spots/{id}/5', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
        Route::post('/spots/{spot}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::post('/spots/{spot}/coupon', [SpotController::class, 'useCoupon'])->name('spots.coupon.use');

        Route::post('/tourist_spots', [TouristSpotController::class, 'store'])->name('tourist_spots.store');
        Route::put('/tourist_spots/{id}', [TouristSpotController::class, 'update'])->name('tourist_spots.update');
        Route::delete('/tourist_spots/{id}', [TouristSpotController::class, 'destroy'])->name('tourist_spots.destroy');
        Route::post('/tourist_spots/{id}/bookmark', [TouristSpotController::class, 'toggleBookmark'])->name('tourist_bookmarks.toggle');
        Route::post('/tourist_spots/{tourist_spot}/reviews', [TouristSpotController::class, 'storeReview'])->name('tourist_reviews.store');
        Route::put('/tourist_reviews/{review}', [TouristSpotController::class, 'updateReview'])->name('tourist_reviews.update');
        Route::delete('/tourist_reviews/{review}', [TouristSpotController::class, 'destroyReview'])->name('tourist_reviews.destroy');

        // ユーザー側の通知受けとり
        Route::post('/notifications/mark-all-read', [UserNotificationController::class, 'markAllRead'])
            ->name('notifications.mark-all-read');
    });

    Route::get('/all_reviews', [AllReviewController::class, 'index'])->name('all_reviews.index');
    Route::get('/all_reviews/create', [AllReviewController::class, 'create'])->name('all_reviews.create');
    Route::post('/all_reviews/store', [AllReviewController::class, 'store'])->name('all_reviews.store');
    Route::patch('/all_reviews/{review}/update', [AllReviewController::class, 'update'])->name('all_reviews.update');
    Route::delete('/all_reviews/{review}/delete', [AllReviewController::class, 'destroy'])->name('all_reviews.destroy');
});

Route::middleware('auth')->prefix('admin/hospitals')->name('admin.hospitals.')->group(function () {
    Route::get('/', [AdminHospitalController::class, 'index'])->name('index');
    Route::get('/create', [AdminHospitalController::class, 'create'])->name('create');
    Route::post('/', [AdminHospitalController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [AdminHospitalController::class, 'edit'])->name('edit');
    Route::patch('/{id}', [AdminHospitalController::class, 'update'])->name('update');
    Route::delete('/{id}', [AdminHospitalController::class, 'destroy'])->name('destroy');
});

// Admin Controller
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        #User
        Route::get('users', [UsersController::class, 'index'])->name('users.index');
        Route::patch('users/{id}/role', [UsersController::class, 'updateRole'])->name('users.update-role');
        Route::patch('users/{id}/status', [UsersController::class, 'updateStatus'])->name('users.update-status');

        #Event
        Route::get('events', [EventsController::class, 'index'])->name('events.index');
        Route::post('events', [\App\Http\Controllers\Admin\EventsController::class, 'store'])->name('events.store');

        #Review
        Route::get('reviews', [\App\Http\Controllers\Admin\ReviewsController::class, 'index'])->name('reviews.index');
        Route::patch('reviews/{source}/{id}/status', [\App\Http\Controllers\Admin\ReviewsController::class, 'updateStatus'])->name('reviews.status');        #market
        Route::get('markets', [MarketsController::class, 'index'])->name('markets.index');
        Route::get('markets/show/{id}', [MarketsController::class, 'show'])->name('markets.show');
        Route::get('analysis', [AnalysisController::class, 'index'])->name('analysis.index');
        Route::get('spots', [SpotsController::class, 'index'])->name('spots.index');

        #Notification
        Route::patch('/notifications/{notification}/status', [App\Http\Controllers\Admin\NotificationsController::class, 'updateStatus'])
            ->name('notifications.update-status');
        Route::post('/notifications/mark-all-read', [App\Http\Controllers\Admin\NotificationsController::class, 'markAllRead'])
            ->name('notifications.mark-all-read');
        Route::resource('notifications', \App\Http\Controllers\Admin\NotificationsController::class)
            ->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::resource('notification-templates', NotificationTemplateController::class)
            ->only(['store', 'update', 'destroy'])
            ->names('notification-templates');
    });
});
