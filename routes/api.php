<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Api\RfidApiController;
use App\Http\Controllers\AttendanceMasterController;
use App\Http\Controllers\Api\AttendanceRuleApiController;
use App\Http\Controllers\Api\LessonScheduleApiController;
use App\Http\Controllers\Api\LoginApiController;
use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\SchoolDetailController;
use App\Http\Controllers\Api\StafApiController;
use App\Http\Controllers\Api\StudentApiController;
use App\Http\Controllers\Api\StudentFeedbackController;
use App\Http\Controllers\Api\StudentPermissionController;
use App\Http\Controllers\Api\TeacherApiController;
use App\Http\Controllers\ClassroomStudentController;
use App\Http\Controllers\Schools\PermissionController;
use App\Models\ModelHasRfid;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes (only truly public endpoints)
Route::get('school/detail', [SchoolDetailController::class, 'index']);

// Routes for attendance hardware/device (require API key or move to protected)
Route::post('attendace/masterkey-check', [AttendanceMasterController::class, 'check'])->name('attendance-test.check');
Route::post('attendance/add', [AttendanceController::class, 'store'])->name('attendance.add');
Route::get('attendance/hours', [AttendanceRuleApiController::class, 'index'])->name('attendance.hour');




Route::post('login', [LoginApiController::class, 'login'])->middleware('throttle:5,1');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user-detail/{user}', [LoginApiController::class, 'user_detail']);

    // Profile Routes
    Route::get('profile/{user}', [\App\Http\Controllers\Api\ProfileApiController::class, 'getProfile']);
    Route::put('profile/{user}', [\App\Http\Controllers\Api\ProfileApiController::class, 'updateProfile']);
    Route::post('profile/{user}/password', [\App\Http\Controllers\Api\ProfileApiController::class, 'changePassword']);
    Route::post('profile/{user}/photo', [\App\Http\Controllers\Api\ProfileApiController::class, 'updatePhoto']);

    // Protected Attendance routes (admin only)
    Route::get('attendance/rfids', [RfidApiController::class, 'index'])->name('rfid.account');
    Route::get('attendance/list', [AttendanceController::class, 'listAttendance']);
    Route::delete('attendance/reset', [AttendanceController::class, 'reset']); // Changed to DELETE method
    Route::get('student/classroom/{classroom}', [ClassroomStudentController::class, 'getByClasroom']);

    Route::get('feedback-active', [PermissionController::class, 'is_active']);

    // Student Routes
    Route::get('student/dashboard/{user}', [StudentApiController::class, 'index']);
    Route::get('student/history-attendance/{user}', [StudentApiController::class, 'history_attendance']);
    Route::get('student/lesson-schedule/{user}', [StudentApiController::class, 'lessonSchedule']);
    Route::get('student/class-student/{user}', [StudentApiController::class, 'class_student']);
    Route::get('student/point-student/{user}', [StudentApiController::class, 'point_student']);
    Route::get('student/detail-profile/{user}', [StudentApiController::class, 'get_detail_profile']);
    Route::get('student/violation/{user}', [StudentApiController::class, 'violation']);
    Route::get('student/repair/{user}', [StudentApiController::class, 'repair']);
    Route::post('student/feedback/{lessonSchedule}', [StudentFeedbackController::class, 'store'])->name('feedback.store');
    Route::put('student/feedback/update/{feedback}', [StudentFeedbackController::class, 'update'])->name('feedback.update');

    // Staff Routes
    Route::post('staf/create-journal/{user}', [StafApiController::class, 'create_journal']);
    Route::get('staf/dashboard/{user}', [StafApiController::class, 'index']);
    Route::get('staf/history-journals/{user}', [StafApiController::class, 'history_journals']);
    Route::put('staf/update-journal/{journalId}', [StafApiController::class, 'update_journal']);
    Route::get('staf/overview-header', [StafApiController::class, 'overview_header']);
    Route::get('staf/max-point', [StafApiController::class, 'max_point']);
    Route::get('staf/list-violation', [StafApiController::class, 'list_violation']);
    Route::get('staf/list-repair', [StafApiController::class, 'list_repair']);
    Route::get('staf/list-point-student', [StafApiController::class, 'list_point_student']);
    Route::get('staf/popular-violations', [StafApiController::class, 'popular_violations']);
    Route::get('staf/student-permissions', [StafApiController::class, 'student_permissions']);

    Route::get('staf/statistic-violation', [StafApiController::class, 'statistic_violation']);

    // Absensi Staff
    Route::get('staf/attendance-config', [StafApiController::class, 'get_config']);
    Route::get('staf/attendance-history/{user}', [StafApiController::class, 'attendance_history']);
    Route::post('staf/check-in', [StafApiController::class, 'check_in']);
    Route::post('staf/check-out', [StafApiController::class, 'check_out']);

    // Teacher Routes - requires teacher role
    Route::middleware(['role:teacher'])->prefix('teacher')->group(function () {
        Route::get('class/{user}', [TeacherApiController::class, 'class']);
        Route::get('attendance/{user}', [TeacherApiController::class, 'teacher_attendance']);
        Route::get('lesson-schedule/{user}', [TeacherApiController::class, 'today_lesson_schedule']);
        Route::get('history-journal/{user}', [TeacherApiController::class, 'today_history_journal']);
        Route::get('subject/{user}', [TeacherApiController::class, 'teacher_subject']);
        Route::get('get-feedback/{teacherSubject}', [TeacherApiController::class, 'get_feedback']);

        // Mobile application routes
        Route::get('dashboard/{user}', [TeacherApiController::class, 'dashboard']);
        Route::get('profile/{user}', [TeacherApiController::class, 'profile']);
        Route::get('weekly-schedule/{user}', [TeacherApiController::class, 'weeklySchedule']);
        Route::get('class-student-attendance/{user}', [TeacherApiController::class, 'classStudentAttendance']);
        Route::get('class-permissions/{user}', [TeacherApiController::class, 'classPermissions']);
        Route::post('permissions/{permission}/approve/{user}', [TeacherApiController::class, 'approvePermission']);
        Route::post('permissions/{permission}/reject/{user}', [TeacherApiController::class, 'rejectPermission']);
        Route::get('student-detail/{user}/{student}', [TeacherApiController::class, 'studentDetail']);

        Route::post('store-journal/{lessonSchedule}', [LessonScheduleApiController::class, 'store']);
        Route::get('detail-journal/{lessonSchedule}', [LessonScheduleApiController::class, 'show']);
        Route::put('update-journal/{lessonSchedule}', [LessonScheduleApiController::class, 'update']);
    });

    // Extracurricular Routes
    Route::prefix('extracurricular')->group(function () {
        Route::get('list', [\App\Http\Controllers\Api\ExtracurricularApiController::class, 'index']);
        Route::get('{id}/students', [\App\Http\Controllers\Api\ExtracurricularApiController::class, 'students']);
        Route::get('{id}/schedules', [\App\Http\Controllers\Api\ExtracurricularApiController::class, 'schedules']);
        Route::get('{id}/attendance', [\App\Http\Controllers\Api\ExtracurricularApiController::class, 'attendance']);
        Route::get('{id}/permissions', [\App\Http\Controllers\Api\ExtracurricularApiController::class, 'permissions']);
        Route::post('permissions/{id}/status', [\App\Http\Controllers\Api\ExtracurricularApiController::class, 'updatePermissionStatus']);
        Route::post('attendance', [\App\Http\Controllers\Api\ExtracurricularApiController::class, 'storeAttendance']);
        Route::get('{id}/journals', [\App\Http\Controllers\Api\ExtracurricularApiController::class, 'journals']);
        Route::get('journal/{id}', [\App\Http\Controllers\Api\ExtracurricularApiController::class, 'journalDetail']);
        Route::post('journal', [\App\Http\Controllers\Api\ExtracurricularApiController::class, 'storeJournal']);
        Route::put('journal/{id}', [\App\Http\Controllers\Api\ExtracurricularApiController::class, 'updateJournal']);
        Route::post('schedule', [\App\Http\Controllers\Api\ExtracurricularApiController::class, 'storeSchedule']);
        Route::delete('schedule/{id}', [\App\Http\Controllers\Api\ExtracurricularApiController::class, 'deleteSchedule']);
    });

    // Permission Routes
    Route::get('/permissions', [StudentPermissionController::class, 'index']);
    Route::post('/students/{student_id}/permissions', [StudentPermissionController::class, 'store']);
    Route::post('/permissions/{id}/approve', [StudentPermissionController::class, 'approve']);
    Route::post('/permissions/{id}/reject', [StudentPermissionController::class, 'reject']);

    // Parent API routes - requires parent role
    Route::middleware(['role:parent'])->prefix('parent')->group(function () {
        // Dashboard & Profile
        Route::get('dashboard/{user}', [ParentController::class, 'dashboard']);
        Route::get('profile/{user}', [ParentController::class, 'profile']);

        // Children management
        Route::get('{user}/children', [ParentController::class, 'getChildren']);
        Route::get('{user}/children/{student}', [ParentController::class, 'childDetail']);
        Route::get('{user}/children/{student}/lessons', [ParentController::class, 'getChildLessons']);
        Route::get('{user}/children/{student}/attendance', [ParentController::class, 'childAttendance']);

        // Permission management
        Route::post('{user}/permissions', [ParentController::class, 'createPermission']);
        Route::get('{user}/permissions', [ParentController::class, 'getPermissionHistory']);
    });
});

