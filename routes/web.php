<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\HomeController;

Route::get('/', [StudyController::class, 'index']);

Auth::routes();

Route::get('/home' , [App\Http\Controllers\HomeController::class, 'index'])->name('home');
