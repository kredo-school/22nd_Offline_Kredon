<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Settings\TwoFactorController;

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
    Route::get('privacy/guide', [SettingController::class, 'privacyGuide'])->name('privacy.guide');
    Route::get('app',          [SettingController::class, 'app'])          ->name('app');

    Route::patch('account',      [SettingController::class, 'updateAccount'])      ->name('account.update');
    Route::patch('comment',      [SettingController::class, 'updateComment'])      ->name('comment.update');
    Route::patch('notification', [SettingController::class, 'updateNotification']) ->name('notification.update');
    Route::patch('privacy',      [SettingController::class, 'updatePrivacy'])      ->name('privacy.update');

    // ↓ この3行を追加
    Route::get('two-factor/setup',    [TwoFactorController::class, 'setup'])  ->name('two-factor.setup');
    Route::post('two-factor/confirm', [TwoFactorController::class, 'confirm'])->name('two-factor.confirm');
    Route::delete('two-factor',       [TwoFactorController::class, 'disable'])->name('two-factor.disable');
});
