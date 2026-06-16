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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function(){

Route::group(['middleware' => 'auth'], function(){

    // とりあえず表示させるため、一時的に 'middleware' => 'admin' を消す
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){

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
        
        #Notification
        Route::get('notifications', [App\Http\Controllers\Admin\NotificationsController::class, 'index'])->name('notifications.index');

        

    });
});
    #正規管理者ルート
    // Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){

    //     Route::get('index', [AdminController::class, 'index'])->name('index');
    // });
});