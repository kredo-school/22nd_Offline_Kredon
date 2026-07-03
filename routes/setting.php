<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Settings\AccountController;
use App\Http\Controllers\Settings\NotificationController;
use App\Http\Controllers\Settings\PrivacyController;
use App\Http\Controllers\Settings\AppController;
use App\Http\Controllers\Settings\CommentController;
use App\Http\Controllers\Settings\DisplayController;
use App\Http\Controllers\Settings\TwoFactorController;

Route::middleware('auth')->prefix('settings')->name  ('settings.')->group(function () {
    Route::get('/',[SettingController::class, 'index'])        ->name('index');

    // account
     Route::get('account',[AccountController::class, 'account'])      ->name('account');
     Route::patch('account',      [AccountController::class, 'updateAccount'])      ->name('account.update');
     Route::delete('account',    [AccountController::class, 'destroyAccount'])    ->name('account.destroy');

    // display
    Route::get('display', [DisplayController::class, 'display'])->name('display');
    Route::patch('display', [DisplayController::class, 'updateDisplay'])->name('display.update');

    // notification
    Route::get('notification', [NotificationController::class, 'notification'])->name('notification');
    Route::patch('notification', [NotificationController::class, 'updateNotification']) ->name('notification.update');
    Route::post('notification/reset', [NotificationController::class, 'resetNotification'])->name('notification.reset');

    // comment
    Route::get('comment',      [CommentController::class, 'comment'])      ->name('comment');
    Route::patch('comment',      [CommentController::class, 'updateComment'])      ->name('comment.update');
    Route::post('comment/blocks', [CommentController::class, 'storeBlock'])->name('comment.blocks.store');
    Route::delete('comment/blocks/{block}', [CommentController::class, 'destroyBlock'])->name('comment.blocks.destroy');
    Route::post('comment/keyword-mutes', [CommentController::class, 'storeKeywordMute'])->name('comment.keyword-mutes.store');
    Route::delete('comment/keyword-mutes/{keywordMute}', [CommentController::class, 'destroyKeywordMute'])->name('comment.keyword-mutes.destroy');
    Route::post('comment/ng-words', [CommentController::class, 'storeNgWord'])->name('comment.ng-words.store');
    Route::delete('comment/ng-words/{ngWord}', [CommentController::class, 'destroyNgWord'])->name('comment.ng-words.destroy');

    // privacy
    Route::get('privacy', [PrivacyController::class, 'privacy'])->name('privacy');
    Route::patch('privacy', [PrivacyController::class, 'updatePrivacy'])->name('privacy.update');

    Route::get('privacy/guide', [PrivacyController::class, 'privacyGuide'])->name('privacy.guide');
    

    // app
    Route::get('app', [AppController::class, 'app'])->name('app');
    Route::patch('app', [AppController::class, 'updateApp'])->name('app.update');
    Route::post('app/reset', [AppController::class, 'resetApp'])->name('app.reset');

    Route::get('two-factor/setup',    [TwoFactorController::class, 'setup'])  ->name('two-factor.setup');
    Route::post('two-factor/confirm', [TwoFactorController::class, 'confirm'])->name('two-factor.confirm');
    Route::delete('two-factor',       [TwoFactorController::class, 'disable'])->name('two-factor.disable');
});
