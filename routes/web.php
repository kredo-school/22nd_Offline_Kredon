<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WizardController;
use App\Http\Controllers\HealthcareController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/healthcare', [HealthcareController::class, 'index'])->name('healthcare.index');

Route::prefix('wizard')->group(function () {

    Route::get('/step/{step}',
    [wizardController::class,'show'])
    ->name('wizard.step');

    Route::post('/step/{step}',
        [WizardController::class, 'store']);

    Route::get('/result',
        [WizardController::class, 'result'])
        ->name('wizard.result');
});

