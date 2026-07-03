<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WizardController;
use App\Http\Controllers\HealthcareController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HospitalBookmarkController;
use App\Http\Controllers\Admin\HospitalController as AdminHospitalController;
use App\Http\Controllers\HospitalImageController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// healthcare
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])
    ->name('locale.switch')
    ->whereIn('locale', ['ja', 'en']);

Route::get('/healthcare', [HealthcareController::class, 'index'])->name('healthcare.index');

Route::prefix('wizard')->group(function () {
    Route::get('/', [WizardController::class, 'start'])->name('wizard.start');

    Route::get('/step/{step}', [WizardController::class, 'show'])
        ->name('wizard.step');

    Route::post('/step/{step}', [WizardController::class, 'store'])
        ->name('wizard.step.store');

    Route::get('/result', [WizardController::class, 'result'])
        ->name('wizard.result');
});

Route::post('/hospitals/{hospitalId}/images', [HospitalImageController::class, 'store'])->name('hospital_images.store');

Route::middleware('auth')->group(function () {
    Route::post('/hospital-bookmarks/{hospital}', [HospitalBookmarkController::class, 'store'])->name('hospital_bookmarks.store');
    Route::delete('/hospital-bookmarks/{hospital}', [HospitalBookmarkController::class, 'destroy'])->name('hospital_bookmarks.destroy');
});

Route::prefix('admin/hospitals')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminHospitalController::class, 'index'])->name('admin.hospitals.index');
    Route::get('/create', [AdminHospitalController::class, 'create'])->name('admin.hospitals.create');
    Route::post('/', [AdminHospitalController::class, 'store'])->name('admin.hospitals.store');
    Route::get('/{id}/edit', [AdminHospitalController::class, 'edit'])->name('admin.hospitals.edit');
    Route::patch('/{id}', [AdminHospitalController::class, 'update'])->name('admin.hospitals.update');
    Route::delete('/{id}', [AdminHospitalController::class, 'destroy'])->name('admin.hospitals.destroy');
});
