<?php

use App\Http\Controllers\Extracurricular\DashboardExtracurricularController;
use App\Http\Controllers\Extracurricular\ExtracurricularManagementController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:extracurricular|staff|teacher'])->prefix('extracurricular')->name('extracurricular.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardExtracurricularController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardExtracurricularController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardExtracurricularController::class, 'updateProfile'])->name('profile.update');

    // Extracurricular list
    Route::get('list', [ExtracurricularManagementController::class, 'index'])->name('list');

    // Extracurricular Students
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [ExtracurricularManagementController::class, 'studentsIndex'])->name('index');
    });

    // Extracurricular Attendance
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [ExtracurricularManagementController::class, 'attendanceIndex'])->name('index');
    });

    // Extracurricular Permission
    Route::prefix('permission')->name('permission.')->group(function () {
        Route::get('/', [ExtracurricularManagementController::class, 'permissionIndex'])->name('index');
        Route::post('/approve/{id}', [ExtracurricularManagementController::class, 'permissionApprove'])->name('approve');
        Route::post('/reject/{id}', [ExtracurricularManagementController::class, 'permissionReject'])->name('reject');
    });

    // Extracurricular Schedule
    Route::prefix('schedule')->name('schedule.')->group(function () {
        Route::get('/', [ExtracurricularManagementController::class, 'scheduleIndex'])->name('index');
        Route::post('/store', [ExtracurricularManagementController::class, 'scheduleStore'])->name('store');
        Route::put('/update/{id}', [ExtracurricularManagementController::class, 'scheduleUpdate'])->name('update');
        Route::delete('/destroy/{id}', [ExtracurricularManagementController::class, 'scheduleDestroy'])->name('destroy');
    });

    // Extracurricular Journal
    Route::prefix('journal')->name('journal.')->group(function () {
        Route::get('/', [ExtracurricularManagementController::class, 'journalIndex'])->name('index');
        Route::get('/create', [ExtracurricularManagementController::class, 'journalCreate'])->name('create');
        Route::post('/store', [ExtracurricularManagementController::class, 'journalStore'])->name('store');
        Route::get('/detail/{id}', [ExtracurricularManagementController::class, 'journalShow'])->name('show');
        Route::get('/edit/{id}', [ExtracurricularManagementController::class, 'journalEdit'])->name('edit');
        Route::put('/update/{id}', [ExtracurricularManagementController::class, 'journalUpdate'])->name('update');
        Route::delete('/destroy/{id}', [ExtracurricularManagementController::class, 'journalDestroy'])->name('destroy');
    });
});
