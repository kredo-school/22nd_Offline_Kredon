<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Settings\AccountController;
use App\Http\Controllers\Settings\NotificationController;
use App\Http\Controllers\Settings\PrivacyController;
use App\Http\Controllers\Settings\CommentController;
use App\Http\Controllers\Settings\TwoFactorController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->prefix('settings')->name('settings.')->group(function () {
    Route::get('/',[SettingController::class, 'index'])        ->name('index');
    
    // account
     Route::get('account',[AccountController::class, 'account'])      ->name('account');
     Route::patch('account',      [AccountController::class, 'updateAccount'])      ->name('account.update');

    // display
    Route::get('display',[SettingController::class, 'display'])->name('display');

    // notification
    Route::get('notification', [NotificationController::class, 'notification'])->name('notification');
    Route::patch('notification', [NotificationController::class, 'updateNotification']) ->name('notification.update');

    // comment
    Route::get('comment',      [CommentController::class, 'comment'])      ->name('comment');
    Route::patch('comment',      [CommentController::class, 'updateComment'])      ->name('comment.update');

    // privacy
    Route::get('privacy', [PrivacyController::class, 'privacy'])->name('privacy');
    Route::patch('privacy', [PrivacyController::class, 'updatePrivacy'])->name('privacy.update');

    Route::get('privacy/guide', [PrivacyController::class, 'privacyGuide'])->name('privacy.guide');
    

    // app
    Route::get('app',[SettingController::class, 'app'])->name('app');

    // ↓ この3行を追加
    Route::get('two-factor/setup',    [TwoFactorController::class, 'setup'])  ->name('two-factor.setup');
    Route::post('two-factor/confirm', [TwoFactorController::class, 'confirm'])->name('two-factor.confirm');
    Route::delete('two-factor',       [TwoFactorController::class, 'disable'])->name('two-factor.disable');
});
