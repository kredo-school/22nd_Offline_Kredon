<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


#Admin Controller
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\MarketsController;
use App\Http\Controllers\Admin\AnalysisController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\NotificationTemplateController;

use App\Http\Controllers\Admin\SpotsController;

#User Controller
use App\Http\Controllers\NotificationsController as UserNotificationController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {

    // User
        #notification
    Route::post('/notifications/mark-all-read', [NotificationsController::class, 'markAllRead'])
        ->name('notifications.mark-all-read');




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
            // 固定パスのルートは resource より前に置く(順序が重要)
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
