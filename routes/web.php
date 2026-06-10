<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WizardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/healthcare', function () {
    return view('healthcare.index');
});

Route::get('/wizard/result', [App\Http\Controllers\WizardController::class, 'result'])->name('wizard.result');