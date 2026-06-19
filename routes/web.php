<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WizardController;
use App\Http\Controllers\HealthcareController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\HospitalController as AdminHospitalController;
use App\Http\Controllers\ImageController;
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

Route::post('/hospitals/{hospitalId}/images', [ImageController::class, 'store'])->name('images.store');


// 管理者用グループルート
Route::prefix('admin/hospitals')->middleware(['auth'])->group(function () {
    // 一覧
    Route::get('/', [AdminHospitalController::class, 'index'])->name('admin.hospitals.index');
    // 作成フォーム
    Route::get('/create', [AdminHospitalController::class, 'create'])->name('admin.hospitals.create');
    // 保存処理
    Route::post('/', [AdminHospitalController::class, 'store'])->name('admin.hospitals.store');
    // 編集処理
    Route::get('/{id}/edit', [AdminHospitalController::class, 'edit'])->name('admin.hospitals.edit');
    // 更新処理
    Route::patch('/{id}', [AdminHospitalController::class, 'update'])->name('admin.hospitals.update'); 
    // 消去処理
    Route::delete('/{id}', [AdminHospitalController::class, 'destroy'])->name('admin.hospitals.destroy'); 

});

