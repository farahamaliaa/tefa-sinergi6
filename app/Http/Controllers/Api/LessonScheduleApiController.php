<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Interfaces\AttendanceJournalInterface;
use App\Contracts\Interfaces\ClassroomStudentInterface;
use App\Contracts\Interfaces\LessonScheduleInterface;
use App\Contracts\Interfaces\Teachers\TeacherJournalInterface;
use App\Helpers\ResponseHelper;
use App\Http\Resources\ClassroomStudentResource;
use App\Http\Resources\LessonScheduleResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherJournalRequest;
use App\Http\Requests\UpdateTeacherJournalRequest;
use App\Http\Resources\AttendanceJournalResource;
use App\Http\Resources\HistoryJournalResource;
use App\Models\LessonSchedule;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AttendanceJournalService;
use App\Services\Teacher\TeacherJournalService;

class LessonScheduleApiController extends Controller
{
    private LessonScheduleInterface $lessonSchedule;
    private ClassroomStudentInterface $classroomStudent;
    private TeacherJournalInterface $teacherJournal;
    private AttendanceJournalService $serviceAttendance;
    private TeacherJournalService $serviceJournal;
    private AttendanceJournalInterface $attendanceJournal;

    public function __construct(
        LessonScheduleInterface $lessonSchedule,
        ClassroomStudentInterface $classroomStudent,
        TeacherJournalInterface $teacherJournal,
        AttendanceJournalService $serviceAttendance,
        TeacherJournalService $serviceJournal,
        AttendanceJournalInterface $attendanceJournal,
    ) {
        $this->lessonSchedule = $lessonSchedule;
        $this->classroomStudent = $classroomStudent;
        $this->teacherJournal = $teacherJournal;
        $this->serviceAttendance = $serviceAttendance;
        $this->serviceJournal = $serviceJournal;
        $this->attendanceJournal = $attendanceJournal;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $lessonSchedules = $this->lessonSchedule->whereTeacher($user->id, now());
        return ResponseHelper::success(LessonScheduleResource::collection($lessonSchedules));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(LessonSchedule $lessonSchedule)
    {
        $classroomStudents = $this->classroomStudent->getByClassId($lessonSchedule->classroom->id);

        // Inject attendance status
        $studentIds = $classroomStudents->pluck('student_id')->toArray();
        $todayAttendances = \App\Models\Attendance::where('model_type', 'App\Models\Student')
            ->whereIn('model_id', $studentIds)
            ->whereDate('created_at', now())
            ->get()
            ->keyBy('model_id');

        foreach ($classroomStudents as $cs) {
            $att = $todayAttendances->get($cs->student_id);
            if ($att) {
                $cs->prefilled_status = $att->status->value;
            }
        }

        return ResponseHelper::success([
            'subject' => $lessonSchedule->teacherSubject->subject->name,
            'classroom' => $lessonSchedule->classroom->name,
            'classroom_students' => ClassroomStudentResource::collection($classroomStudents)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(LessonSchedule $lessonSchedule)
    {
        $classroomStudents = $this->classroomStudent->getByClassId($lessonSchedule->classroom->id);
        $teacherJournal = $this->teacherJournal->getByLessonSchedule($lessonSchedule->id);
        $attendanceJournals = $teacherJournal != null ? $this->attendanceJournal->getByTeacherJournal($teacherJournal->id) : null;

        if ($teacherJournal == null) {
            // Inject attendance status if journal not created yet
            $studentIds = $classroomStudents->pluck('student_id')->toArray();
            $todayAttendances = \App\Models\Attendance::where('model_type', 'App\Models\Student')
                ->whereIn('model_id', $studentIds)
                ->whereDate('created_at', now())
                ->get()
                ->keyBy('model_id');

            foreach ($classroomStudents as $cs) {
                $att = $todayAttendances->get($cs->student_id);
                if ($att) {
                    $cs->prefilled_status = $att->status->value;
                }
            }
        }

        return ResponseHelper::success([
            'title' => $teacherJournal != null ? $teacherJournal->title : null,
            'description' => $teacherJournal != null ? $teacherJournal->description : null,
            'date' => $teacherJournal != null ? $teacherJournal->date : null,
            'classroom_students' => $teacherJournal != null ? AttendanceJournalResource::collection($attendanceJournals) : ClassroomStudentResource::collection($classroomStudents)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonSchedule $lessonSchedule, StoreTeacherJournalRequest $request)
    {
        // Check if trying to fill journal for a different day - reject
        $todayDayName = strtolower(now()->format('l'));
        $scheduleDayName = strtolower($lessonSchedule->day);
        
        if ($todayDayName !== $scheduleDayName) {
            return ResponseHelper::error('Tidak dapat mengisi jurnal untuk hari yang sudah lewat', 403);
        }

        $data = $this->serviceJournal->store($request, $lessonSchedule);
        $teacherJournal = $this->teacherJournal->store($data);
        $this->serviceAttendance->storeJournal($request['attendance'], $teacherJournal);
        return ResponseHelper::success(null, 'Berhasil menambahkan jurnal');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonSchedule $lessonSchedule, UpdateTeacherJournalRequest $request)
    {
        $journal = $lessonSchedule->teacherJournals->first();
        if (!$journal) {
            return ResponseHelper::notFound('Jurnal belum dibuat untuk jadwal ini');
        }

        $data = $this->serviceJournal->update($request, $lessonSchedule);
        $this->teacherJournal->update($journal->id, $data);
        $this->serviceAttendance->updateJournal($request['attendance'], $journal);
        return ResponseHelper::success(null, 'Berhasil mengedit jurnal');
    }

    /**
     * Display the specified resource.
     */
    public function history(User $user, Request $request)
    {
        // Get filled journals
        $filledJournals = $this->teacherJournal->histories($user->id, $request);

        // Get all lesson schedules for this teacher that are in the past (before today)
        $employee = \App\Models\Employee::where('user_id', $user->id)->first();
        if (!$employee) {
            return ResponseHelper::success(HistoryJournalResource::collection($filledJournals));
        }

        $teacherSubjectIds = \App\Models\TeacherSubject::where('employee_id', $employee->id)->pluck('id');

        // Get all past lesson schedules (schedules where the day has passed)
        $allSchedules = \App\Models\LessonSchedule::whereIn('teacher_subject_id', $teacherSubjectIds)
            ->with([
                'classroom',
                'teacherSubject.subject',
                'teacherJournals' => function ($q) {
                    $q->whereDate('date', '<', today()); // Only past journals
                }
            ])
            ->get();

        // Create a collection for unfilled schedules (past schedules without journals)
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

        // Check each schedule for missing journals in the past
        foreach ($allSchedules as $schedule) {
            $dayOfWeek = $dayMapping[$schedule->day] ?? null;
            if ($dayOfWeek === null)
                continue;

            // Get all dates in the past month where this schedule should have had a journal
            $startDate = now()->subDays(30);
            $currentDate = $startDate->copy();

            while ($currentDate->lt(today())) {
                if ($currentDate->dayOfWeek === $dayOfWeek) {
                    // Check if journal exists for this date
                    $journalExists = $schedule->teacherJournals->contains(function ($journal) use ($currentDate) {
                        return \Carbon\Carbon::parse($journal->date)->isSameDay($currentDate);
                    });

                    if (!$journalExists) {
                        // Add unfilled schedule entry
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

        // Merge filled journals with unfilled schedules
        $filledData = HistoryJournalResource::collection($filledJournals)->resolve();
        $allHistory = collect($filledData)->merge($unfilledSchedules);

        // Sort by date (newest first)
        $sortedHistory = $allHistory->sortByDesc(function ($item) {
            return $item['date_full'] ?? $item['year'] . '-01-01';
        })->values();

        return ResponseHelper::success($sortedHistory);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
