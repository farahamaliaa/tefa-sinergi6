<?php

namespace App\Http\Controllers\Teacher;

use App\Contracts\Interfaces\AttendanceJournalInterface;
use App\Models\LessonSchedule;
use App\Models\TeacherJournal;
use App\Http\Controllers\Controller;
use App\Services\Teacher\TeacherJournalService;
use App\Http\Requests\StoreTeacherJournalRequest;
use App\Http\Requests\UpdateTeacherJournalRequest;
use App\Contracts\Interfaces\LessonScheduleInterface;
use App\Contracts\Interfaces\ClassroomStudentInterface;
use App\Contracts\Interfaces\Teachers\TeacherJournalInterface;
use App\Services\AttendanceJournalService;
use App\Contracts\Interfaces\LessonHourInterface; // Added LessonHourInterface
use Illuminate\Http\Request;

class TeacherJournalController extends Controller
{
    private AttendanceJournalService $serviceAttendance;
    private AttendanceJournalInterface $attendanceJournal;
    private TeacherJournalInterface $teacherJournal;
    private LessonScheduleInterface $lessonSchedule;
    private TeacherJournalService $service;
    private ClassroomStudentInterface $classroomStudent;
    private LessonHourInterface $lessonHour; // Added property for LessonHourInterface

    public function __construct(TeacherJournalInterface $teacherJournal, AttendanceJournalInterface $attendanceJournal, TeacherJournalService $service, LessonScheduleInterface $lessonSchedule, ClassroomStudentInterface $classroomStudent, AttendanceJournalService $serviceAttendance, LessonHourInterface $lessonHour)
    {
        $this->serviceAttendance = $serviceAttendance;
        $this->attendanceJournal = $attendanceJournal;
        $this->teacherJournal = $teacherJournal;
        $this->lessonSchedule = $lessonSchedule;
        $this->service = $service;
        $this->classroomStudent = $classroomStudent;
        $this->lessonHour = $lessonHour; // Initialize the LessonHourInterface property
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $teacherSchedules = $this->lessonSchedule->whereTeacher(auth()->user()->id, now());
        $filledHistories = $this->teacherJournal->histories(auth()->user()->id, $request);

        // Get unfilled schedules from the past 30 days
        $employee = \App\Models\Employee::where('user_id', auth()->user()->id)->first();
        $unfilledSchedules = collect();

        if ($employee) {
            $teacherSubjectIds = \App\Models\TeacherSubject::where('employee_id', $employee->id)->pluck('id');
            $allSchedules = \App\Models\LessonSchedule::whereIn('teacher_subject_id', $teacherSubjectIds)
                ->with(['classroom', 'teacherSubject.subject', 'teacherJournals'])
                ->get();

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

            foreach ($allSchedules as $schedule) {
                $dayOfWeek = $dayMapping[$schedule->day] ?? null;
                if ($dayOfWeek === null)
                    continue;

                $startDate = now()->subDays(30);
                $currentDate = $startDate->copy();

                while ($currentDate->lt(today())) {
                    if ($currentDate->dayOfWeek === $dayOfWeek) {
                        $journalExists = $schedule->teacherJournals->contains(function ($journal) use ($currentDate) {
                            return \Carbon\Carbon::parse($journal->date)->isSameDay($currentDate);
                        });

                        if (!$journalExists) {
                            // Create a fake object for unfilled schedule
                            $unfilled = new \stdClass();
                            $unfilled->id = null;
                            $unfilled->lesson_schedule_id = $schedule->id;
                            $unfilled->lessonSchedule = $schedule;
                            $unfilled->title = null;
                            $unfilled->description = null;
                            $unfilled->date = $currentDate->format('Y-m-d');
                            $unfilled->is_filled = false;
                            $unfilled->attendanceJournals = collect(); // Empty collection

                            $unfilledSchedules->push($unfilled);
                        }
                    }
                    $currentDate->addDay();
                }
            }
        }

        // Merge and sort by date (newest first)
        $histories = $filledHistories->toBase()->map(function ($journal) {
            $journal->is_filled = true;
            return $journal;
        })->merge($unfilledSchedules)->sortByDesc(function ($item) {
            return $item->date;
        })->values();

        return view('teacher.pages.journals.index', compact('teacherSchedules', 'histories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(LessonSchedule $lessonSchedule, Request $request)
    {
        $classroomStudents = $this->classroomStudent->where($lessonSchedule->classroom->id, $request);
        $studentsPaginator = $classroomStudents;
        return view('teacher.pages.journals.create', compact('classroomStudents', 'lessonSchedule', 'studentsPaginator'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherJournalRequest $request, LessonSchedule $lessonSchedule)
    {
        // Check if trying to fill journal for a different day - reject
        $todayDayName = strtolower(now()->format('l'));
        $scheduleDayName = strtolower($lessonSchedule->day);
        
        if ($todayDayName !== $scheduleDayName) {
            return redirect()->back()->with('error', 'Tidak dapat mengisi jurnal untuk hari yang sudah lewat');
        }

        try {
            $data = $this->service->store($request, $lessonSchedule);
            $teacherJournal = $this->teacherJournal->store($data);
            $this->serviceAttendance->storeJournal($request['attendance'], $teacherJournal);
            return to_route('teacher.journals.index')->with('success', 'Berhasil mengirim jurnal');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherJournal $journal)
    {
        $attendanceJournals = $journal->attendanceJournals()->paginate(10);
        return view('teacher.pages.journals.detail', compact('journal', 'attendanceJournals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherJournal $teacherJournal)
    {
        $classroomStudents = $this->attendanceJournal->getByTeacherJournal($teacherJournal->id);
        return view('teacher.pages.journals.update', compact('teacherJournal', 'classroomStudents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherJournalRequest $request, TeacherJournal $teacherJournal)
    {
        try {
            $data = $this->service->update($request, $teacherJournal->lessonSchedule);
            $this->teacherJournal->update($teacherJournal->id, $data);
            $this->serviceAttendance->updateJournal($request['attendance'], $teacherJournal);
            return to_route('teacher.journals.index')->with('success', 'Berhasil mengupdate jurnal');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherJournal $teacherJournal)
    {
        try {
            $this->teacherJournal->delete($teacherJournal->id);
            return redirect()->back()->with('success', 'Berhasi menghapus jurnal');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan' . $th->getMessage());
        }
    }
}
