<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


#Admin Controller
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;

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

    });
});
    #正規管理者ルート
    // Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){

    //     Route::get('index', [AdminController::class, 'index'])->name('index');
    // });
});