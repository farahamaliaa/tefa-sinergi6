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
    
    // Extracurricular Students
    Route::prefix('extracurricular-students')->name('extracurricular-students.')->group(function () {
        Route::get('/', [ExtracurricularController::class, 'studentsIndex'])->name('index');
    });
    
    // Extracurricular Attendance
    Route::prefix('extracurricular-attendance')->name('extracurricular-attendance.')->group(function () {
        Route::get('/', [ExtracurricularController::class, 'attendanceIndex'])->name('index');
    });
    
    // Extracurricular Permission
    Route::prefix('extracurricular-permission')->name('extracurricular-permission.')->group(function () {
        Route::get('/', [ExtracurricularController::class, 'permissionIndex'])->name('index');
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
    });

    // Extracurricular Journal (teacher) - dummy page to open extracurricular journals
    Route::get('extracurricular-journal', [ExtracurricularController::class, 'journalIndex'])->name('extracurricular-journal.index');
});



