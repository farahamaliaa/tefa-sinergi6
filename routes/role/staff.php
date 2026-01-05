<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeJournalController;
use App\Http\Controllers\Staff\StaffViolationController;
use App\Http\Controllers\Staff\StudentRepairController;
use App\Http\Controllers\Staff\StaffAttendanceController;
use App\Http\Controllers\Staff\StaffExtracurricularController;
use App\Http\Controllers\StudentViolationController;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\ModelHasRfidController;
use App\Http\Controllers\Staff\DashboardStaffController;
use App\Http\Controllers\Staff\StaffApprovalController;
use App\Http\Controllers\Staff\StaffPermissionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:staff'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/', [DashboardStaffController::class, 'index'])->name('dashboard');

    // Staff Permissions (Staff Biasa)
    Route::resource('permission', StaffPermissionController::class);

    // Staff Approval (Ketua TU)
    Route::prefix('approval')->name('approval.')->group(function () {
        Route::get('/', [StaffApprovalController::class, 'index'])->name('index');
        Route::post('/permission/approve/{id}', [StaffApprovalController::class, 'approve'])->name('permission.approve');
        Route::post('/permission/reject/{id}', [StaffApprovalController::class, 'reject'])->name('permission.reject');
    });

    // Manual Attendance (Staff Biasa)
    Route::post('attendance/check-in', [StaffAttendanceController::class, 'checkIn'])->name('attendance.check-in');
    // fitur buku tamu
    Route::resource('guestbook', GuestBookController::class);
    // fitur jurnal
    Route::resource('journal', EmployeeJournalController::class)->except('show');
    Route::get('journal/detail/{employeeJournal}', [EmployeeJournalController::class, 'detail'])->name('journal.detail');

    // fitur absensi
    Route::get('attendance', [StaffAttendanceController::class, 'index'])->name('attendance.index');

    // Extracurricular Students
    Route::prefix('extracurricular-students')->name('extracurricular-students.')->group(function () {
        Route::get('/', [StaffExtracurricularController::class, 'studentsIndex'])->name('index');
    });

    // Extracurricular Attendance
    Route::prefix('extracurricular-attendance')->name('extracurricular-attendance.')->group(function () {
        Route::get('/', [StaffExtracurricularController::class, 'attendanceIndex'])->name('index');
    });

    // Extracurricular Permission
    Route::prefix('extracurricular-permission')->name('extracurricular-permission.')->group(function () {
        Route::get('/', [StaffExtracurricularController::class, 'permissionIndex'])->name('index');
        Route::post('/approve/{id}', [StaffExtracurricularController::class, 'permissionApprove'])->name('approve');
        Route::post('/reject/{id}', [StaffExtracurricularController::class, 'permissionReject'])->name('reject');
    });

    // Extracurricular Journal
    Route::prefix('extracurricular-journal')->name('extracurricular-journal.')->group(function () {
        Route::get('/', [StaffExtracurricularController::class, 'journalIndex'])->name('index');
        Route::get('/create', [StaffExtracurricularController::class, 'journalCreate'])->name('create');
        Route::post('/store', [StaffExtracurricularController::class, 'journalStore'])->name('store');
        Route::get('/detail/{id}', [StaffExtracurricularController::class, 'journalShow'])->name('show');
        Route::get('/edit/{id}', [StaffExtracurricularController::class, 'journalEdit'])->name('edit');
        Route::put('/update/{id}', [StaffExtracurricularController::class, 'journalUpdate'])->name('update');
        Route::delete('/destroy/{id}', [StaffExtracurricularController::class, 'journalDestroy'])->name('destroy');
    });

    // Extracurricular Schedule
    Route::prefix('extracurricular-schedule')->name('extracurricular-schedule.')->group(function () {
        Route::get('/', [StaffExtracurricularController::class, 'scheduleIndex'])->name('index');
        Route::post('/store', [StaffExtracurricularController::class, 'scheduleStore'])->name('store');
        Route::delete('/destroy/{id}', [StaffExtracurricularController::class, 'scheduleDestroy'])->name('destroy');
    });
});

Route::middleware(['auth', 'role:staff|teacher', 'permission:view_violation'])->prefix('employee')->name('employee.')->group(function () {

    // fitur pelanggaran
    Route::prefix('violation')->name('violation.')->group(function () {
        Route::get('overview', [StaffViolationController::class, 'overview'])->name('overview');
        Route::get('student-point', [StaffViolationController::class, 'index'])->name('student-point.index');
        Route::get('student-point/{student}', [StaffViolationController::class, 'show_detail_student'])->name('student-point.detail');
        Route::get('class-point/{classroom}', [StaffViolationController::class, 'show'])->name('class-point.detail');
        Route::get('students', [StaffViolationController::class, 'list_student'])->name('students');
        Route::post('student', [StudentViolationController::class, 'store'])->name('students.store');
        Route::post('student-violation/{student}', [StudentViolationController::class, 'single_store'])->name('single.student-violation');
        Route::post('student-repair/{student}', [StudentRepairController::class, 'single_store'])->name('single.student-repair');
        Route::resource('student-repair', StudentRepairController::class);

        Route::prefix('student-repair')->name('student-repair.')->group(function () {
            Route::put('approve/{studentRepair}', [StudentRepairController::class, 'approved'])->name('approved');
            Route::put('reject/{studentRepair}', [StudentRepairController::class, 'reject'])->name('reject');
            Route::post('import', [StudentRepairController::class, 'import'])->name('import');
        });

        Route::post('student-violation/import', [StaffViolationController::class, 'import'])->name('student-violation.import');
    });

    Route::get('export-student-repair', [StudentRepairController::class, 'download_student'])->name('student-repair.download');
    Route::get('export-student-violation', [StaffViolationController::class, 'download_student'])->name('student-violation.download');

    Route::get('rfid-student-violation', function () {
        return view('staff.pages.single-violation.tab-rfid-violation');
    })->name('rfid-student-violation`');

    Route::get('detail-student-violation/{rfid}', [ModelHasRfidController::class, 'show'])->name('post-rfid.violation');
});
