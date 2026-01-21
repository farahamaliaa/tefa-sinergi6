<?php

use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\DashboardTeacherController;
use App\Http\Controllers\Teacher\ExtracurricularController;
use App\Http\Controllers\Teacher\StudentFeedbackController;
use App\Http\Controllers\Teacher\TeacherJournalController;
use App\Http\Controllers\Teacher\TeacherStudentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('', [DashboardTeacherController::class, 'index'])->name('dashboard');

    Route::get('extracurricular', [ExtracurricularController::class, 'index'])->name('extracurricular.index');

    Route::prefix('extracurricular-students')->name('extracurricular-students.')->group(function () {
        Route::get('/', [ExtracurricularController::class, 'studentsIndex'])->name('index');
    });

    Route::prefix('extracurricular-attendance')->name('extracurricular-attendance.')->group(function () {
        Route::get('/', [ExtracurricularController::class, 'attendanceIndex'])->name('index');
    });

    Route::prefix('extracurricular-permission')->name('extracurricular-permission.')->group(function () {
        Route::get('/', [ExtracurricularController::class, 'permissionIndex'])->name('index');
        Route::post('/approve/{id}', [ExtracurricularController::class, 'permissionApprove'])->name('approve');
        Route::post('/reject/{id}', [ExtracurricularController::class, 'permissionReject'])->name('reject');
    });

    Route::resource('journals', TeacherJournalController::class)->except(['create', 'store', 'update', 'edit']);
    Route::resource('journals/Extracuricular', TeacherJournalController::class)->except(['create', 'store', 'update', 'edit']);
    Route::get('journals/update/{teacherJournal}', [TeacherJournalController::class, 'edit'])->name('journals.edit');
    Route::put('journals/update/{teacherJournal}', [TeacherJournalController::class, 'update'])->name('journals.update');

    Route::get('journals/create/{lessonSchedule}', [TeacherJournalController::class, 'create'])->name('journals.create');
    Route::post('journals/create/{lessonSchedule}', [TeacherJournalController::class, 'store'])->name('journals.store');
    Route::resource('list-student-class', TeacherStudentController::class);

    Route::get('student-feedback', [StudentFeedbackController::class, 'index'])->name('student-feedback.index');

    Route::get('attendance/history', [AttendanceController::class, 'index'])->name('attendance.history');

    Route::prefix('classroom-attendance')->name('classroom-attendance.')->group(function () {
        Route::get('/', [AttendanceController::class, 'classroomIndex'])->name('index');
    });

    Route::prefix('classroom-permission')->name('classroom-permission.')->group(function () {
        Route::get('/', [AttendanceController::class, 'permissionIndex'])->name('index');
        Route::post('/approve/{id}', [AttendanceController::class, 'approvePermission'])->name('approve');
        Route::post('/reject/{id}', [AttendanceController::class, 'rejectPermission'])->name('reject');
    });

    Route::prefix('extracurricular-journal')->name('extracurricular-journal.')->group(function () {
        Route::get('/', [ExtracurricularController::class, 'journalIndex'])->name('index');
        Route::get('/create', [ExtracurricularController::class, 'journalCreate'])->name('create');
        Route::post('/store', [ExtracurricularController::class, 'journalStore'])->name('store');
        Route::get('/detail/{id}', [ExtracurricularController::class, 'journalShow'])->name('show');
        Route::get('/edit/{id}', [ExtracurricularController::class, 'journalEdit'])->name('edit');
        Route::put('/update/{id}', [ExtracurricularController::class, 'journalUpdate'])->name('update');
        Route::delete('/destroy/{id}', [ExtracurricularController::class, 'journalDestroy'])->name('destroy');
    });

    Route::prefix('extracurricular-schedule')->name('extracurricular-schedule.')->group(function () {
        Route::get('/', [ExtracurricularController::class, 'scheduleIndex'])->name('index');
        Route::post('/store', [ExtracurricularController::class, 'scheduleStore'])->name('store');
        Route::delete('/destroy/{id}', [ExtracurricularController::class, 'scheduleDestroy'])->name('destroy');
    });
});
