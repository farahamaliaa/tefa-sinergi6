<?php

namespace App\Http\Controllers\Teacher;

use App\Contracts\Interfaces\AttendanceJournalInterface;
use App\Contracts\Interfaces\ClassroomStudentInterface;
use App\Contracts\Interfaces\LessonHourInterface;
use App\Contracts\Interfaces\LessonScheduleInterface;
use App\Contracts\Interfaces\Teachers\TeacherJournalInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherJournalRequest;
use App\Http\Requests\UpdateTeacherJournalRequest;
use Illuminate\Http\Request;
use App\Models\LessonSchedule;
use App\Models\TeacherJournal;
use App\Services\AttendanceJournalService;
use App\Services\Teacher\TeacherJournalService;
use App\Models\SchoolYear;
use App\Services\SemesterService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class TeacherJournalController extends Controller
{
    private AttendanceJournalService $serviceAttendance;

    private AttendanceJournalInterface $attendanceJournal;

    private TeacherJournalInterface $teacherJournal;

    private LessonScheduleInterface $lessonSchedule;

    private TeacherJournalService $service;

    private ClassroomStudentInterface $classroomStudent;

    private LessonHourInterface $lessonHour;

    private SemesterService $semesterService;

    public function __construct(TeacherJournalInterface $teacherJournal, AttendanceJournalInterface $attendanceJournal, TeacherJournalService $service, LessonScheduleInterface $lessonSchedule, ClassroomStudentInterface $classroomStudent, AttendanceJournalService $serviceAttendance, LessonHourInterface $lessonHour, SemesterService $semesterService)
    {
        $this->serviceAttendance = $serviceAttendance;
        $this->attendanceJournal = $attendanceJournal;
        $this->teacherJournal = $teacherJournal;
        $this->lessonSchedule = $lessonSchedule;
        $this->service = $service;
        $this->classroomStudent = $classroomStudent;
        $this->lessonHour = $lessonHour;
        $this->semesterService = $semesterService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $teacherSchedules = $this->lessonSchedule->whereTeacher(auth()->user()->id, now());
        $filledHistories = $this->teacherJournal->histories(auth()->user()->id, $request);

        $filledJournalDates = TeacherJournal::query()
            ->whereRelation('lessonSchedule.teacherSubject.employee.user', 'id', auth()->user()->id)
            ->whereHas('lessonSchedule.classroom.schoolYear', function ($query) {
                $query->where('active', true);
            })
            ->get(['lesson_schedule_id', 'date']);

        $filledLookup = [];
        foreach ($filledJournalDates as $j) {
            $d = Carbon::parse($j->date)->format('Y-m-d');
            $filledLookup[$j->lesson_schedule_id . '_' . $d] = true;
        }

        $allSchedules = $this->lessonSchedule->getByTeacher(auth()->user()->id);

        $activeSchoolYear = SchoolYear::where('active', true)->first();
        $startDate = $activeSchoolYear ? $activeSchoolYear->created_at : now(); 
        
        if ($request->date) {
            $startDate = Carbon::parse($request->date);
            $endDate = Carbon::parse($request->date);
        } else {
            $endDate = now()->subDay();
        }

        $missingJournals = collect();

        if ($startDate->lte($endDate) && !$request->search) {
            $period = CarbonPeriod::create($startDate, $endDate);
            \Log::info("Journal Debug: period Start={$startDate->toDateString()}, End={$endDate->toDateString()}");

            foreach ($period as $date) {
                \Log::info("Journal Debug: iteration date=" . $date->toDateString());
                $dayName = strtolower($date->format('l'));
                
                if (isset($allSchedules[$dayName])) {
                    foreach ($allSchedules[$dayName] as $schedule) {
                        // Safeguard: Only show missing journals for dates on or after the schedule was created
                        if ($date->lt(Carbon::parse($schedule->created_at)->startOfDay())) {
                            continue;
                        }

                        $key = $schedule->id . '_' . $date->format('Y-m-d');
                        
                        if (!isset($filledLookup[$key])) {
                            $fake = new TeacherJournal();
                            $fake->id = 'missing_' . $key;
                            $fake->lesson_schedule_id = $schedule->id;
                            $fake->date = $date->format('Y-m-d H:i:s');
                            $fake->is_filled = false;
                            
                            $fake->setRelation('lessonSchedule', $schedule);
                            $fake->setRelation('attendanceJournals', collect());
                            
                            $missingJournals->push($fake);
                        }
                    }
                }
            }
        }

        $histories = $filledHistories->toBase()->map(function ($journal) {
            $journal->is_filled = true;
            return $journal;
        })->merge($missingJournals);
        
        if ($request->filter === 'terlama') {
             $histories = $histories->sortBy(function ($item) {
                return Carbon::parse($item->date)->timestamp;
            });
        } else {
            $histories = $histories->sortByDesc(function ($item) {
                return Carbon::parse($item->date)->timestamp;
            });
        }
        
        $histories = $histories->values();

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
            return redirect()->back()->with('error', 'Terjadi kesalahan'.$th->getMessage());
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
            return redirect()->back()->with('error', 'Terjadi kesalahan'.$th->getMessage());
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
            return redirect()->back()->with('error', 'Terjadi kesalahan'.$th->getMessage());
        }
    }
}
