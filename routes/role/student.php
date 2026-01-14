<?php

use App\Http\Controllers\Student\AttendanceController;
use App\Http\Controllers\Student\DashboardStudentController;
use App\Http\Controllers\Student\ExtracurricularStudentController;
use App\Http\Controllers\Student\FeedbackController;
use App\Http\Controllers\Student\LessonScheduleController;
use App\Http\Controllers\Student\RepairStudentController;
use App\Http\Controllers\Student\ViolationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('student')->name('student.')->group(function () {
    Route::get('', [DashboardStudentController::class, 'index'])->name('dashboard');

    Route::get('lesson-schedule', [LessonScheduleController::class, 'index'])->name('lesson-schedule');

    Route::get('violations', [ViolationController::class, 'index'])->name('violations');
    Route::resource('repairs', RepairStudentController::class);
    Route::get('/class', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('feedback/{lessonSchedule}', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::put('feedback/update/{feedback}', [FeedbackController::class, 'update'])->name('feedback.update');
    Route::get('/all-feedback-schedule', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance');

    // Ekstrakurikuler
    Route::prefix('extracurricular')->name('extracurricular.')->group(function () {
        Route::get('/', [ExtracurricularStudentController::class, 'index'])->name('index');
        Route::get('/{extracurricular}/attendance', [ExtracurricularStudentController::class, 'attendancePage'])->name('attendance');
        Route::post('/{extracurricular}/attendance', [ExtracurricularStudentController::class, 'storeAttendance'])->name('attendance.store');
        Route::get('/{extracurricular}/schedule', [ExtracurricularStudentController::class, 'schedulePage'])->name('schedule');
        Route::get('/{extracurricular}/permission', [ExtracurricularStudentController::class, 'permissionPage'])->name('permission');
        Route::get('/{extracurricular}/permission/create', [ExtracurricularStudentController::class, 'createPermission'])->name('permission.create');
        Route::post('/{extracurricular}/permission', [ExtracurricularStudentController::class, 'storePermission'])->name('permission.store');
    });
});
