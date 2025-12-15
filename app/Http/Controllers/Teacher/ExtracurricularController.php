<?php

namespace App\Http\Controllers\Teacher;

use App\Contracts\Interfaces\ExtracurricularInterface;
use App\Contracts\Interfaces\ExtracurricularStudentInterface;
use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ExtracurricularController extends Controller
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
        
        $extracurriculars = Extracurricular::where('employee_id', $employee->id)
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            })
            ->with('extracurricularStudents')
            ->latest()
            ->get();

        return view('teacher.pages.ekstrakulikuler.index', compact('extracurriculars'));
    }

    public function studentsIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');
        
        if (!$extracurricularId) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular info
        $extracurricular = Extracurricular::find($extracurricularId);
        
        if (!$extracurricular) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
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

        
        return view('teacher.pages.extracurricular-students.index', compact('extracurricularStudents', 'extracurricular', 'classrooms'));
    }

    public function attendanceIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');
        
        if (!$extracurricularId) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular info
        $extracurricular = Extracurricular::find($extracurricularId);
        
        if (!$extracurricular) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular students
        $extracurricularStudents = $extracurricular->extracurricularStudents()
            ->with('student.user', 'student.classroomStudents.classroom')
            ->get();
        
        // TODO: Get attendance data for this extracurricular
        $attendances = [];
        
        return view('teacher.pages.extracurricular-attendance.index', compact('extracurricularStudents', 'extracurricular', 'attendances'));
    }

    public function permissionIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');
        
        if (!$extracurricularId) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular info
        $extracurricular = Extracurricular::find($extracurricularId);
        
        if (!$extracurricular) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular students
        $extracurricularStudents = $extracurricular->extracurricularStudents()
            ->with('student.user', 'student.classroomStudents.classroom')
            ->get();
        
        // TODO: Get permission data
        
        return view('teacher.pages.extracurricular-permission.index', compact('extracurricularStudents', 'extracurricular'));
    }

    public function journalIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');

        if (!$extracurricularId) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        $extracurricular = Extracurricular::find($extracurricularId);

        if (!$extracurricular) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        // Provide dummy empty datasets so the view can render without errors
        $journals = [];
        $histories = [];
        $teacherSchedules = [];

        return view(
            'teacher.pages.journals-extracurricular.index',
            compact('extracurricular', 'journals', 'histories', 'teacherSchedules')
        );
    }

}
