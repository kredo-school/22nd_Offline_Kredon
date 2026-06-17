<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->prefix('settings')->name('settings.')->group(function () {
    Route::get('/',          [SettingController::class, 'index'])        ->name('index');
    
     Route::get('account',      [SettingController::class, 'account'])      ->name('account');
    Route::get('display',      [SettingController::class, 'display'])      ->name('display');
    Route::get('notification', [SettingController::class, 'notification']) ->name('notification');
    Route::get('comment',      [SettingController::class, 'comment'])      ->name('comment');
    Route::get('privacy',      [SettingController::class, 'privacy'])      ->name('privacy');
    Route::get('app',          [SettingController::class, 'app'])          ->name('app');

    Route::patch('account',      [SettingController::class, 'updateAccount'])      ->name('account.update');
    Route::patch('notification', [SettingController::class, 'updateNotification']) ->name('notification.update');
    Route::patch('privacy',      [SettingController::class, 'updatePrivacy'])      ->name('privacy.update');
});
