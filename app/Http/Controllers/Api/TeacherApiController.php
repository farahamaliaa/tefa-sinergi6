<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Contracts\Interfaces\AttendanceRuleInterface;
use App\Contracts\Interfaces\ClassroomInterface;
use App\Contracts\Interfaces\ClassroomStudentInterface;
use App\Contracts\Interfaces\EmployeeInterface;
use App\Contracts\Interfaces\FeedbackInterface;
use App\Contracts\Interfaces\LessonScheduleInterface;
use App\Contracts\Interfaces\ModelHasRfidInterface;
use App\Contracts\Interfaces\Teachers\TeacherJournalInterface;
use App\Contracts\Interfaces\TeacherSubjectInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassroomStudentResource;
use App\Http\Resources\FeedbackResource;
use App\Http\Resources\HistoryAttendanceResource;
use App\Http\Resources\HistoryJournalResource;
use App\Http\Resources\LessonScheduleResource;
use App\Http\Resources\StudentAttendanceResource;
use App\Http\Resources\TeacherDashboardResource;
use App\Http\Resources\TeacherPermissionResource;
use App\Http\Resources\TeacherProfileResource;
use App\Http\Resources\TeacherSubjectResource;
use App\Http\Resources\WeeklyScheduleResource;
use App\Models\StudentPermission;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class TeacherApiController extends Controller
{
    private EmployeeInterface $employee;
    private ClassroomInterface $classroom;
    private AttendanceInterface $attendance;
    private LessonScheduleInterface $lessonSchedule;
    private TeacherJournalInterface $teacherJournal;
    private TeacherSubjectInterface $teacherSubject;
    private FeedbackInterface $feedback;
    private ModelHasRfidInterface $modelHasRfid;
    private AttendanceRuleInterface $attendanceRule;
    private ClassroomStudentInterface $classroomStudent;

    public function __construct(
        EmployeeInterface $employee,
        ClassroomInterface $classroom,
        AttendanceInterface $attendance,
        LessonScheduleInterface $lessonSchedule,
        TeacherJournalInterface $teacherJournal,
        TeacherSubjectInterface $teacherSubject,
        FeedbackInterface $feedback,
        ModelHasRfidInterface $modelHasRfid,
        AttendanceRuleInterface $attendanceRule,
        ClassroomStudentInterface $classroomStudent,
    )
    {
        $this->employee = $employee;
        $this->classroom = $classroom;
        $this->attendance = $attendance;
        $this->lessonSchedule = $lessonSchedule;
        $this->teacherJournal = $teacherJournal;
        $this->teacherSubject = $teacherSubject;
        $this->feedback = $feedback;
        $this->modelHasRfid = $modelHasRfid;
        $this->attendanceRule = $attendanceRule;
        $this->classroomStudent = $classroomStudent;
    }

    /**
     * Get teacher dashboard summary
     */
    public function dashboard(User $user)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $employee = $this->employee->getByUser($user->id);
        $classroom = $this->classroom->whereEmployeeId($employee->id);
        
        // Count pending permissions for homeroom class
        $pendingPermissions = 0;
        if ($classroom) {
            $pendingPermissions = StudentPermission::where('classroom_id', $classroom->id)
                ->where('status', 'pending')
                ->count();
        }
        
        // Count today's lesson schedules
        $todaySchedules = $this->lessonSchedule->whereTeacher($user->id, today())->count();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'code' => 200,
            'data' => new TeacherDashboardResource($user, $classroom, $pendingPermissions, $todaySchedules),
        ], 200);
    }

    /**
     * Get teacher profile details
     */
    public function profile(User $user)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $user->load(['employee.teacherSubjects.subject', 'employee.classroom', 'employee.employeePosition']);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'code' => 200,
            'data' => new TeacherProfileResource($user),
        ], 200);
    }

    /**
     * Get weekly lesson schedule for teacher
     */
    public function weeklySchedule(User $user)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $employee = $this->employee->getByUser($user->id);
        $teacherSubjects = $this->teacherSubject->getByTeacher($employee->id);
        
        // Get all lesson schedules for teacher's subjects
        $schedules = \App\Models\LessonSchedule::whereIn('teacher_subject_id', $teacherSubjects->pluck('id'))
            ->with(['classroom', 'teacherSubject.subject', 'start', 'end'])
            ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('lesson_hour_start')
            ->get();
        
        // Group by day
        $groupedSchedules = $schedules->groupBy('day')->map(function ($daySchedules) {
            return WeeklyScheduleResource::collection($daySchedules);
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'code' => 200,
            'data' => $groupedSchedules,
        ], 200);
    }

    /**
     * Get student attendance for homeroom class
     */
    public function classStudentAttendance(User $user, Request $request)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $employee = $this->employee->getByUser($user->id);
        $classroom = $this->classroom->whereEmployeeId($employee->id);
        
        if (!$classroom) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda bukan wali kelas',
                'code' => 403,
            ], 403);
        }
        
        // Get attendance data for students in the classroom
        $attendances = $this->attendance->whereClassroomFiltered($classroom->id, $request);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'code' => 200,
            'data' => [
                'classroom' => [
                    'id' => $classroom->id,
                    'name' => $classroom->name,
                ],
                'attendances' => HistoryAttendanceResource::collection($attendances),
            ],
        ], 200);
    }

    /**
     * Get student permissions for homeroom class
     */
    public function classPermissions(User $user, Request $request)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $employee = $this->employee->getByUser($user->id);
        $classroom = $this->classroom->whereEmployeeId($employee->id);
        
        if (!$classroom) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda bukan wali kelas',
                'code' => 403,
            ], 403);
        }
        
        $query = StudentPermission::where('classroom_id', $classroom->id)
            ->with(['student.user', 'classroom', 'submittedBy', 'approvedBy']);
        
        // Filter by status if provided
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        $permissions = $query->latest()->get();
        
        // Count by status
        $statusCounts = [
            'pending' => StudentPermission::where('classroom_id', $classroom->id)->where('status', 'pending')->count(),
            'approved' => StudentPermission::where('classroom_id', $classroom->id)->where('status', 'approved')->count(),
            'rejected' => StudentPermission::where('classroom_id', $classroom->id)->where('status', 'rejected')->count(),
        ];
        
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'code' => 200,
            'data' => [
                'classroom' => [
                    'id' => $classroom->id,
                    'name' => $classroom->name,
                ],
                'status_counts' => $statusCounts,
                'permissions' => TeacherPermissionResource::collection($permissions),
            ],
        ], 200);
    }

    /**
     * Approve student permission
     */
    public function approvePermission(User $user, StudentPermission $permission)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $employee = $this->employee->getByUser($user->id);
        $classroom = $this->classroom->whereEmployeeId($employee->id);
        
        if (!$classroom || $classroom->id != $permission->classroom_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk menyetujui izin ini',
                'code' => 403,
            ], 403);
        }
        
        $permission->update([
            'status' => 'approved',
            'approved_by' => $user->id,
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Izin berhasil disetujui',
            'code' => 200,
            'data' => new TeacherPermissionResource($permission->fresh(['student.user', 'classroom', 'submittedBy', 'approvedBy'])),
        ], 200);
    }

    /**
     * Reject student permission
     */
    public function rejectPermission(User $user, StudentPermission $permission)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $employee = $this->employee->getByUser($user->id);
        $classroom = $this->classroom->whereEmployeeId($employee->id);
        
        if (!$classroom || $classroom->id != $permission->classroom_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk menolak izin ini',
                'code' => 403,
            ], 403);
        }
        
        $permission->update([
            'status' => 'rejected',
            'approved_by' => $user->id,
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Izin berhasil ditolak',
            'code' => 200,
            'data' => new TeacherPermissionResource($permission->fresh(['student.user', 'classroom', 'submittedBy', 'approvedBy'])),
        ], 200);
    }

    public function class(User $user)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $employee = $this->employee->getByUser($user->id);
        $classroom = $this->classroom->whereEmployeeId($employee->id);

        if ($classroom) {
            return response()->json(['status' => 'success', 'message' => "Data Berhasil di Tambahkan", 'code' => 200,
            'data_dashboard' => [
                'class' => $classroom->name,
                'count_student' => $classroom->classroomStudents()->latest()->count(),
            ],
            'class_student' => ClassroomStudentResource::collection($classroom->classroomStudents()->latest()->get()),
        ], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => "Anda tidak memiliki kelas", 'code' => 200,
            'data_dashboard' => [
                'class' => '',
                'count_student' => 0,
            ],
        ], 200);
        }
    }

    public function teacher_attendance(User $user)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $employee = $this->employee->getByUser($user->id);
        $history_attendance = $this->attendance->whereUser($employee->id, 'App\Models\Employee');
        $single_attendance = $this->attendance->userToday('App\Models\Employee', $employee->id);
        $rule_rfid = $this->modelHasRfid->first('App\Models\Employee', $employee->id);
        $rule_day = $this->attendanceRule->whereDayRole(today()->format('l'), 'teacher');

        if ($rule_rfid) {
            return response()->json(['status' => 'success', 'message' => "Berhasil mengambil data",'code' => 200,
                'attendance_now' => [
                    'day' => $single_attendance ? Carbon::parse($single_attendance->created_at)->translatedFormat('l') : now()->translatedFormat('l'),
                    'date' => $single_attendance ? Carbon::parse($single_attendance->created_at)->translatedFormat('d') : now()->translatedFormat('d'),
                    'month' => $single_attendance ? Carbon::parse($single_attendance->created_at)->translatedFormat('M') : now()->translatedFormat('M'),
                    'date_complate' => $single_attendance ? Carbon::parse($single_attendance->created_at)->translatedFormat('l, j F Y') : now()->translatedFormat('l, j F Y'),
                    'check_in' => $single_attendance ? ($single_attendance->checkin == null ? '-' : \Carbon\Carbon::parse($single_attendance->checkin)->format('H:i')) : '-',
                    'check_out' => $single_attendance ? ($single_attendance->checkout == null ? '-' : \Carbon\Carbon::parse($single_attendance->checkout)->format('H:i')) : '-',
                    'status' => $single_attendance ? $single_attendance->status->label() : '',
                ],
                'attendance_history' => $history_attendance->count() > 0 ? HistoryAttendanceResource::collection($history_attendance) : 'Data Kosong',
            ], 200);
        } else if ($rule_day->is_holiday ==  true) {
            return response()->json(['status' => 'success', 'message' => "Berhasil mengambil data",'code' => 200,
                'attendance_now' => [
                    'day' => now()->translatedFormat('l'),
                    'date' => now()->translatedFormat('d'),
                    'month' => now()->translatedFormat('M'),
                    'date_complate' => now()->translatedFormat('l, j F Y'),
                    'check_in' => '-',
                    'check_out' => '-',
                    'status' => 'Libur',
                ],
                'attendance_history' => $history_attendance->count() > 0 ? HistoryAttendanceResource::collection($history_attendance) : 'Data Kosong',
            ], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => "Data Kosong", 'code' => 200, 'message_attendance' => "Anda Belum memiliki RFID"], 200);
        }

    }

    public function today_lesson_schedule(User $user)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $teacherSchedules = $this->lessonSchedule->whereTeacher($user->id, today());

        if ($teacherSchedules->count() > 0) {
            return response()->json(['status' => 'success', 'message' => "Berhasil mengambil data",'code' => 200,
                'lesson_schedule_dashboard' => LessonScheduleResource::collection($teacherSchedules->take(5)),
                'lesson_schedule_all' => LessonScheduleResource::collection($teacherSchedules),
            ], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => "Data kosong",'code' => 200], 200);
        }
    }

    public function today_history_journal(User $user)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $historyJournal = $this->teacherJournal->getJournalToday($user->id);
        if ($historyJournal->count() > 0) {
            return response()->json(['status' => 'success', 'message' => "Berhasil mengambil data",'code' => 200,
                'data' => HistoryJournalResource::collection($historyJournal),
            ], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => "Data kosong",'code' => 200], 200);
        }
    }

    public function teacher_subject(User $user)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $employee = $this->employee->getByUser($user->id);
        $teacherSubject = $this->teacherSubject->getByTeacher($employee->id);

        if ($teacherSubject->count() > 0) {
            return response()->json(['status' => 'success', 'message' => "Berhasil mengambil data",'code' => 200,
                'data' => TeacherSubjectResource::collection($teacherSubject),
            ], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => "Data Kosong",'code' => 200], 200);
        }
    }

    public function get_feedback(TeacherSubject $teacherSubject)
    {
        // SECURITY: Verify that the authenticated user owns this subject
        $employee = $this->employee->getByUser(auth()->id());
        if (!$employee || $teacherSubject->employee_id !== $employee->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $feedbacks = $this->feedback->getBySubject($teacherSubject->id);
        if ($feedbacks->count() > 0) {
            return response()->json(['status' => 'success', 'message' => "Berhasil mengambil data",'code' => 200,
                'data' => FeedbackResource::collection($feedbacks),
            ], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => "Data Kosong",'code' => 200], 200);
        }
    }

    /**
     * Get detailed student information for mobile app
     * Returns all student data similar to edit student form
     */
    public function studentDetail(User $user, \App\Models\Student $student)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $employee = $this->employee->getByUser($user->id);
        $classroom = $this->classroom->whereEmployeeId($employee->id);
        
        // Verify the student belongs to teacher's homeroom class
        $studentClassroom = $student->classroomStudents()->latest()->first();
        
        if (!$classroom || !$studentClassroom || $studentClassroom->classroom_id !== $classroom->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses ke data siswa ini',
                'code' => 403,
            ], 403);
        }

        // Load relationships
        $student->load(['user', 'religion', 'classroomStudents.classroom', 'modelHasRfid']);
        $fullDomain = request()->root();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'code' => 200,
            'data' => [
                'id' => $student->id,
                'user_id' => $student->user_id,
                
                // Basic Information
                'name' => $student->user->name ?? null,
                'email' => $student->user->email ?? null,
                'nisn' => $student->nisn,
                'image' => $student->image ? asset($fullDomain . '/storage/' . $student->image) : null,
                'image_path' => $student->image,
                
                // Personal Information
                'gender' => $student->gender?->value,
                'gender_label' => $student->gender?->label(),
                'religion_id' => $student->religion_id,
                'religion_name' => $student->religion->name ?? null,
                'birth_date' => $student->birth_date,
                'birth_date_formatted' => $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d-m-Y') : null,
                'birth_place' => $student->birth_place,
                
                // Identity Documents
                'nik' => $student->nik,
                'number_kk' => $student->number_kk,
                'number_akta' => $student->number_akta,
                
                // Family Information
                'order_child' => $student->order_child,
                'count_siblings' => $student->count_siblings,
                
                // Address
                'address' => $student->address,
                
                // Academic Information
                'point' => $student->point ?? 0,
                'classroom' => $studentClassroom ? [
                    'id' => $studentClassroom->classroom->id,
                    'name' => $studentClassroom->classroom->name,
                ] : null,
                
                // RFID Information
                'has_rfid' => $student->modelHasRfid !== null,
                'rfid' => $student->modelHasRfid?->rfid ?? null,
                
                // Timestamps
                'created_at' => $student->created_at,
                'updated_at' => $student->updated_at,
            ],
        ], 200);
    }
}
