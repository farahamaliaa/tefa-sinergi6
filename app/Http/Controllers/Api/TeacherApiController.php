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
use App\Helpers\ResponseHelper;
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
    ) {
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
            return ResponseHelper::unauthorized();
        }
        $employee = $this->employee->getByUser($user->id);
        if (!$employee) {
            return ResponseHelper::notFound('Data pegawai tidak ditemukan');
        }
        $classroom = $this->classroom->whereEmployeeId($employee->id);

        $pendingPermissions = 0;
        if ($classroom) {
            $pendingPermissions = StudentPermission::where('classroom_id', $classroom->id)
                ->where('status', 'pending')
                ->count();
        }

        $todaySchedules = $this->lessonSchedule->whereTeacher($user->id, today())->count();

        return ResponseHelper::success(
            new TeacherDashboardResource($user, $classroom, $pendingPermissions, $todaySchedules)
        );
    }

    /**
     * Get teacher profile details
     */
    public function profile(User $user)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }
        $user->load(['employee.teacherSubjects.subject', 'employee.classroom', 'employee.employeePosition']);

        return ResponseHelper::success(new TeacherProfileResource($user));
    }

    /**
     * Get weekly lesson schedule for teacher
     */
    public function weeklySchedule(User $user)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }
        $employee = $this->employee->getByUser($user->id);
        $teacherSubjects = $this->teacherSubject->getByTeacher($employee->id);

        $schedules = \App\Models\LessonSchedule::whereIn('teacher_subject_id', $teacherSubjects->pluck('id'))
            ->with(['classroom', 'teacherSubject.subject', 'start', 'end'])
            ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('lesson_hour_start')
            ->get();

        $groupedSchedules = $schedules->groupBy('day')->map(function ($daySchedules) {
            return WeeklyScheduleResource::collection($daySchedules);
        });

        return ResponseHelper::success($groupedSchedules);
    }

    /**
     * Get student attendance for homeroom class
     */
    public function classStudentAttendance(User $user, Request $request)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }
        $employee = $this->employee->getByUser($user->id);
        $classroom = $this->classroom->whereEmployeeId($employee->id);

        if (!$classroom) {
            return ResponseHelper::error('Anda bukan wali kelas', 403);
        }

        $attendances = $this->attendance->whereClassroomFiltered($classroom->id, $request);

        return ResponseHelper::success([
            'classroom' => [
                'id' => $classroom->id,
                'name' => $classroom->name,
            ],
            'attendances' => HistoryAttendanceResource::collection($attendances),
        ]);
    }

    /**
     * Get student permissions for homeroom class
     */
    public function classPermissions(User $user, Request $request)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }
        $employee = $this->employee->getByUser($user->id);
        $classroom = $this->classroom->whereEmployeeId($employee->id);

        if (!$classroom) {
            return ResponseHelper::error('Anda bukan wali kelas', 403);
        }

        $query = StudentPermission::where('classroom_id', $classroom->id)
            ->with(['student.user', 'classroom', 'submittedBy', 'approvedBy']);

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $permissions = $query->latest()->get();

        $statusCounts = [
            'pending' => StudentPermission::where('classroom_id', $classroom->id)->where('status', 'pending')->count(),
            'approved' => StudentPermission::where('classroom_id', $classroom->id)->where('status', 'approved')->count(),
            'rejected' => StudentPermission::where('classroom_id', $classroom->id)->where('status', 'rejected')->count(),
        ];

        return ResponseHelper::success([
            'classroom' => [
                'id' => $classroom->id,
                'name' => $classroom->name,
            ],
            'status_counts' => $statusCounts,
            'permissions' => TeacherPermissionResource::collection($permissions),
        ]);
    }

    /**
     * Approve student permission
     */
    public function approvePermission(User $user, StudentPermission $permission)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }
        $employee = $this->employee->getByUser($user->id);
        $classroom = $this->classroom->whereEmployeeId($employee->id);

        if (!$classroom || $classroom->id != $permission->classroom_id) {
            return ResponseHelper::error('Anda tidak memiliki akses untuk menyetujui izin ini', 403);
        }

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($permission, $user) {
                $permission->update([
                    'status' => 'approved',
                    'approved_by' => $user->id,
                ]);

                $activeCS = $permission->student->classroomStudents()
                    ->whereHas('classroom.schoolYear', function ($query) {
                        $query->where('active', true);
                    })->first();

                if ($activeCS) {
                    $attendance = \App\Models\Attendance::where('model_type', 'App\Models\ClassroomStudent')
                        ->where('model_id', $activeCS->id)
                        ->whereDate('created_at', $permission->date)
                        ->first();

                    $statusEnum = $permission->permission_type == 'sick'
                        ? \App\Enums\AttendanceEnum::SICK
                        : \App\Enums\AttendanceEnum::PERMIT;

                    if ($attendance) {
                        $attendance->update(['status' => $statusEnum]);
                    } else {
                        \App\Models\Attendance::create([
                            'model_type' => 'App\Models\ClassroomStudent',
                            'model_id' => $activeCS->id,
                            'status' => $statusEnum,
                            'point' => 0,
                            'created_at' => \Carbon\Carbon::parse($permission->date),
                            'proof' => $permission->proof_image,
                        ]);
                    }
                }
            });

            return ResponseHelper::success(
                new TeacherPermissionResource($permission->fresh(['student.user', 'classroom', 'submittedBy', 'approvedBy'])),
                'Izin berhasil disetujui dan absensi diperbarui'
            );
        } catch (\Exception $e) {
            return ResponseHelper::error('Gagal menyetujui izin: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Reject student permission
     */
    public function rejectPermission(User $user, StudentPermission $permission)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }
        $employee = $this->employee->getByUser($user->id);
        $classroom = $this->classroom->whereEmployeeId($employee->id);

        if (!$classroom || $classroom->id != $permission->classroom_id) {
            return ResponseHelper::error('Anda tidak memiliki akses untuk menolak izin ini', 403);
        }

        $permission->update([
            'status' => 'rejected',
            'approved_by' => $user->id,
        ]);

        return ResponseHelper::success(
            new TeacherPermissionResource($permission->fresh(['student.user', 'classroom', 'submittedBy', 'approvedBy'])),
            'Izin berhasil ditolak'
        );
    }

    public function class(User $user)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }
        $employee = $this->employee->getByUser($user->id);
        $classroom = $this->classroom->whereEmployeeId($employee->id);

        if ($classroom) {
            return ResponseHelper::success([
                'data_dashboard' => [
                    'class' => $classroom->name,
                    'count_student' => $classroom->classroomStudents()->latest()->count(),
                ],
                'class_student' => ClassroomStudentResource::collection($classroom->classroomStudents()->latest()->get()),
            ]);
        } else {
            return ResponseHelper::success([
                'data_dashboard' => [
                    'class' => '',
                    'count_student' => 0,
                ],
            ], 'Anda tidak memiliki kelas');
        }
    }

    public function teacher_attendance(User $user)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }
        $employee = $this->employee->getByUser($user->id);
        if (!$employee) {
            return ResponseHelper::notFound('Data pegawai tidak ditemukan');
        }
        $history_attendance = $this->attendance->whereUser($employee->id, 'App\Models\Employee');
        $single_attendance = $this->attendance->userToday('App\Models\Employee', $employee->id);
        $rule_rfid = $this->modelHasRfid->first('App\Models\Employee', $employee->id);
        $rule_day = $this->attendanceRule->whereDayRole(today()->format('l'), 'teacher');

        if ($rule_rfid) {
            return ResponseHelper::success([
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
            ]);
        } else if ($rule_day && $rule_day->is_holiday == true) {
            return ResponseHelper::success([
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
            ]);
        } else {
            return ResponseHelper::success([
                'message_attendance' => "Anda Belum memiliki RFID",
            ], 'Data Kosong');
        }

    }

    public function today_lesson_schedule(User $user)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }
        $teacherSchedules = $this->lessonSchedule->whereTeacher($user->id, today());

        if ($teacherSchedules->count() > 0) {
            return ResponseHelper::success([
                'lesson_schedule_dashboard' => LessonScheduleResource::collection($teacherSchedules->take(5)),
                'lesson_schedule_all' => LessonScheduleResource::collection($teacherSchedules),
            ]);
        } else {
            return ResponseHelper::success(null, 'Data kosong');
        }
    }

    public function today_history_journal(User $user)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }

        // Get employee first
        $employee = \App\Models\Employee::where('user_id', $user->id)->first();

        if (!$employee) {
            return ResponseHelper::success(null, 'Data pegawai tidak ditemukan');
        }

        // Get filled journals (All History)
        $historyJournal = $this->teacherJournal->getByTeacher($employee->id);
        $filledData = HistoryJournalResource::collection($historyJournal)->resolve();

        $teacherSubjectIds = \App\Models\TeacherSubject::where('employee_id', $employee->id)->pluck('id');

        // Get all lesson schedules with their journals
        $allSchedules = \App\Models\LessonSchedule::whereIn('teacher_subject_id', $teacherSubjectIds)
            ->with(['classroom', 'teacherSubject.subject', 'teacherJournals'])
            ->get();

        // Create unfilled schedules collection
        $unfilledSchedules = collect();
        $dayMapping = [
            'Monday' => 1,
            'monday' => 1,
            'Tuesday' => 2,
            'tuesday' => 2,
            'Wednesday' => 3,
            'wednesday' => 3,
            'Thursday' => 4,
            'thursday' => 4,
            'Friday' => 5,
            'friday' => 5,
            'Saturday' => 6,
            'saturday' => 6,
            'Sunday' => 0,
            'sunday' => 0
        ];

        // Check each schedule for missing journals in the past 30 days
        foreach ($allSchedules as $schedule) {
            $dayOfWeek = $dayMapping[$schedule->day] ?? null;
            if ($dayOfWeek === null)
                continue;

            $startDate = now()->subDays(30);
            $currentDate = $startDate->copy();

            while ($currentDate->lt(today())) {
                if ($currentDate->dayOfWeek === $dayOfWeek) {
                    // Check if journal exists for this date
                    $journalExists = $schedule->teacherJournals->contains(function ($journal) use ($currentDate) {
                        return \Carbon\Carbon::parse($journal->date)->isSameDay($currentDate);
                    });

                    if (!$journalExists) {
                        $unfilledSchedules->push([
                            'id' => $schedule->id,
                            'lesson_schedule_id' => $schedule->id,
                            'subject' => $schedule->teacherSubject->subject->name ?? '-',
                            'subject_name' => $schedule->teacherSubject->subject->name ?? '-',
                            'classroom' => $schedule->classroom->name ?? '-',
                            'class_name' => $schedule->classroom->name ?? '-',
                            'title' => null,
                            'description' => null,
                            'date' => $currentDate->translatedFormat('d F'),
                            'year' => $currentDate->format('Y'),
                            'date_full' => $currentDate->format('Y-m-d'),
                            'status' => 'not_filled',
                            'count_alpha' => null,
                            'count_sick' => null,
                            'count_permit' => null,
                            'count_present' => null,
                            'attendance' => null,
                        ]);
                    }
                }
                $currentDate->addDay();
            }
        }

        // Merge filled and unfilled
        $allHistory = collect($filledData)->merge($unfilledSchedules);

        // Sort by date (newest first)
        $sortedHistory = $allHistory->sortByDesc(function ($item) {
            return $item['date_full'] ?? $item['year'] . '-01-01';
        })->values();

        if ($sortedHistory->count() > 0) {
            return ResponseHelper::success(['data' => $sortedHistory]);
        }
        return ResponseHelper::success(null, 'Data kosong');
    }

    public function teacher_subject(User $user)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }
        $employee = $this->employee->getByUser($user->id);
        $teacherSubject = $this->teacherSubject->getByTeacher($employee->id);

        if ($teacherSubject->count() > 0) {
            return ResponseHelper::success(TeacherSubjectResource::collection($teacherSubject));
        } else {
            return ResponseHelper::success(null, 'Data Kosong');
        }
    }

    public function get_feedback(TeacherSubject $teacherSubject)
    {
        $employee = $this->employee->getByUser(auth()->id());
        if (!$employee || $teacherSubject->employee_id !== $employee->id) {
            return ResponseHelper::unauthorized();
        }

        $feedbacks = $this->feedback->getBySubject($teacherSubject->id);
        if ($feedbacks->count() > 0) {
            return ResponseHelper::success(FeedbackResource::collection($feedbacks));
        } else {
            return ResponseHelper::success(null, 'Data Kosong');
        }
    }

    public function studentDetail(User $user, \App\Models\Student $student)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }

        $employee = $this->employee->getByUser($user->id);
        $classroom = $this->classroom->whereEmployeeId($employee->id);

        $studentClassroom = $student->classroomStudents()->latest()->first();

        if (!$classroom || !$studentClassroom || $studentClassroom->classroom_id !== $classroom->id) {
            return ResponseHelper::error('Anda tidak memiliki akses ke data siswa ini', 403);
        }

        $student->load(['user', 'religion', 'classroomStudents.classroom', 'modelHasRfid']);
        $fullDomain = request()->root();

        return ResponseHelper::success([
            'id' => $student->id,
            'user_id' => $student->user_id,

            'name' => $student->user->name ?? null,
            'email' => $student->user->email ?? null,
            'nisn' => $student->nisn,
            'image' => $student->image ? asset($fullDomain . '/storage/' . $student->image) : null,
            'image_path' => $student->image,
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
        ]);
    }
}
