<?php

namespace App\Http\Controllers\Teacher;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Contracts\Interfaces\ClassroomStudentInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    private ClassroomStudentInterface $studentClass;
    private AttendanceInterface $attendance;

    public function __construct(AttendanceInterface $attendance, ClassroomStudentInterface $studentClass)
    {
        $this->attendance = $attendance;
        $this->studentClass = $studentClass;
    }

    public function index()
    {
        $attendances = $this->attendance->whereUser(auth()->user()->employee->id, 'App\Models\Employee');
        return view('teacher.pages.attendance-history.index', compact('attendances'));
    }

    public function classroomIndex(Request $request)
    {
        $classroomId = $request->get('classroom');
        
        if (!$classroomId) {
            return redirect()->route('teacher.dashboard')->with('error', 'Kelas tidak ditemukan');
        }
        
        // Get classroom info
        $classroom = \App\Models\Classroom::find($classroomId);
        
        if (!$classroom) {
            return redirect()->route('teacher.dashboard')->with('error', 'Kelas tidak ditemukan');
        }
        
        // Get classroom students
        $classroomStudents = $this->studentClass->where($classroomId, $request);
        
        // Get attendance data for this classroom with filters
        $attendances = $this->attendance->whereClassroomFiltered($classroomId, $request);
        
        return view('teacher.pages.classroom-attendance.index', compact('attendances', 'classroomStudents', 'classroom'));
    }

    public function permissionIndex(Request $request)
    {
        $classroomId = $request->get('classroom');
        
        if (!$classroomId) {
            return redirect()->route('teacher.dashboard')->with('error', 'Kelas tidak ditemukan');
        }
        
        // Get classroom info
        $classroom = \App\Models\Classroom::find($classroomId);
        
        if (!$classroom) {
            return redirect()->route('teacher.dashboard')->with('error', 'Kelas tidak ditemukan');
        }
        
        // Get classroom students
        $classroomStudents = $this->studentClass->where($classroomId, $request);
        
        // TODO: Get permission data for this classroom
        // This will depend on your StudentPermission model structure
        
        return view('teacher.pages.classroom-permission.index', compact('classroomStudents', 'classroom'));
    }
}
