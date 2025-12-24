<?php

namespace App\Http\Controllers\Extracurricular;

use App\Contracts\Interfaces\ExtracurricularInterface;
use App\Contracts\Interfaces\ExtracurricularStudentInterface;
use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\Classroom;
use App\Models\LessonSchedule;
use App\Models\TeacherJournal;
use App\Models\ClassroomStudent;
use Illuminate\Http\Request;

class ExtracurricularManagementController extends Controller
{
    private ExtracurricularInterface $extracurricular;
    private ExtracurricularStudentInterface $extracurricularStudent;

    public function __construct(
        ExtracurricularInterface $extracurricular,
        ExtracurricularStudentInterface $extracurricularStudent
    ) {
        $this->extracurricular = $extracurricular;
        $this->extracurricularStudent = $extracurricularStudent;
    }

    public function index(Request $request)
    {
        $employee = auth()->user()->employee;
        
        if (!$employee) {
            $extracurriculars = collect([]);
            return view('extracurricular.pages.eskul.index', compact('extracurriculars'));
        }
        
        $extracurriculars = Extracurricular::where('employee_id', $employee->id)
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            })
            ->with('extracurricularStudents')
            ->latest()
            ->get();

        return view('extracurricular.pages.eskul.index', compact('extracurriculars'));
    }

    public function studentsIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');
        
        if (!$extracurricularId) {
            return redirect()->route('extracurricular.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular info
        $extracurricular = Extracurricular::find($extracurricularId);
        
        if (!$extracurricular) {
            return redirect()->route('extracurricular.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular students
        $extracurricularStudents = $extracurricular->extracurricularStudents()
            ->with('student.user', 'student.classroomStudents.classroom')
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('student.user', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%');
                });
            })
            ->get();
        $classrooms = Classroom::orderBy('name')->get();

        
        return view('extracurricular.pages.students.index', compact('extracurricularStudents', 'extracurricular', 'classrooms'));
    }

    public function attendanceIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');
        
        if (!$extracurricularId) {
            return redirect()->route('extracurricular.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular info
        $extracurricular = Extracurricular::find($extracurricularId);
        
        if (!$extracurricular) {
            return redirect()->route('extracurricular.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular students
        $extracurricularStudents = $extracurricular->extracurricularStudents()
            ->with('student.user', 'student.classroomStudents.classroom')
            ->get();
        
        $attendances = [];
        
        return view('extracurricular.pages.attendance.index', compact('extracurricularStudents', 'extracurricular', 'attendances'));
    }

    public function permissionIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');
        
        if (!$extracurricularId) {
            return redirect()->route('extracurricular.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular info
        $extracurricular = Extracurricular::find($extracurricularId);
        
        if (!$extracurricular) {
            return redirect()->route('extracurricular.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular students
        $extracurricularStudents = $extracurricular->extracurricularStudents()
            ->with('student.user', 'student.classroomStudents.classroom')
            ->get();
        
        
        return view('extracurricular.pages.permission.index', compact('extracurricularStudents', 'extracurricular'));
    }

    public function journalIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');

        if (!$extracurricularId) {
            return redirect()->route('extracurricular.dashboard')
                ->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        $extracurricular = Extracurricular::find($extracurricularId);

        if (!$extracurricular) {
            return redirect()->route('extracurricular.dashboard')
                ->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        $journals = [];
        $histories = [];
        $teacherSchedules = [];

        return view(
            'extracurricular.pages.journal.index',
            compact('extracurricular', 'journals', 'histories', 'teacherSchedules')
        );
    }

    public function journalCreate(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');
        $extracurricular = Extracurricular::find($extracurricularId);

        // Get a lesson schedule for view compatibility (mocked for now)
        $lessonSchedule = LessonSchedule::with('teacherSubject.subject', 'classroom')->first();
        
        if (!$lessonSchedule) {
            return redirect()->back()->with('error', 'Data jadwal tidak ditemukan');
        }

        $classroomStudents = ClassroomStudent::with('student.user')
            ->where('classroom_id', $lessonSchedule->classroom_id)
            ->paginate(10);
        $studentsPaginator = $classroomStudents;

        return view('extracurricular.pages.journal.create', compact(
            'classroomStudents',
            'lessonSchedule',
            'studentsPaginator',
            'extracurricular'
        ));
    }

    public function journalShow($id)
    {
        // Fetch the journal or fallback to first available
        $journal = TeacherJournal::with('lessonSchedule.teacherSubject.subject', 'lessonSchedule.classroom')
            ->find($id);

        if (!$journal) {
            $journal = TeacherJournal::with('lessonSchedule.teacherSubject.subject', 'lessonSchedule.classroom')
                ->first();
        }

        if (!$journal) {
            return redirect()->back()->with('error', 'Data jurnal tidak ditemukan');
        }

        $attendanceJournals = $journal->attendanceJournals()
            ->with('classroomStudent.student.user', 'classroomStudent.classroom')
            ->paginate(10);

        return view('extracurricular.pages.journal.detail', compact('journal', 'attendanceJournals'));
    }

    public function journalEdit($id)
    {
        // Fetch the journal or fallback to first available
        $journal = TeacherJournal::with('lessonSchedule.teacherSubject.subject', 'lessonSchedule.classroom')
            ->find($id);

        if (!$journal) {
            $journal = TeacherJournal::with('lessonSchedule.teacherSubject.subject', 'lessonSchedule.classroom')
                ->first();
        }

        if (!$journal) {
            return redirect()->back()->with('error', 'Data jurnal tidak ditemukan');
        }

        $lessonSchedule = $journal->lessonSchedule;

        return view('extracurricular.pages.journal.update', compact('journal', 'lessonSchedule'));
    }
}
