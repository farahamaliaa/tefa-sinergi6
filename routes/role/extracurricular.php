<?php

use App\Http\Controllers\Extracurricular\DashboardExtracurricularController;
use App\Http\Controllers\Extracurricular\ExtracurricularManagementController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:extracurricular'])->prefix('extracurricular')->name('extracurricular.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardExtracurricularController::class, 'index'])->name('dashboard');

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
    });

    // Extracurricular Journal
    Route::prefix('journal')->name('journal.')->group(function () {
        Route::get('/', [ExtracurricularManagementController::class, 'journalIndex'])->name('index');
        Route::get('/create', [ExtracurricularManagementController::class, 'journalCreate'])->name('create');
        Route::get('/detail/{id}', [ExtracurricularManagementController::class, 'journalShow'])->name('show');
        Route::get('/edit/{id}', [ExtracurricularManagementController::class, 'journalEdit'])->name('edit');
    });
});
