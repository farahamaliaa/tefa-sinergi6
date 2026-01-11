<?php

namespace App\Http\Controllers\Student;

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

    public function index(Request $request)
    {
        $studentClasses = $this->studentClass->whereStudent(auth()->user()->student->id);
        $attendances = $this->attendance->whereUserFiltered($studentClasses->id, 'App\Models\ClassroomStudent', $request);
        return view('student.pages.attendance.index', compact('attendances', 'studentClasses'));
    }
}
