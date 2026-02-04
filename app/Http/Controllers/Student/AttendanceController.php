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

        // Calculate Summary
        $allAttendances = $this->attendance->whereUser($studentClasses->id, 'App\Models\ClassroomStudent');
        $summary = [
            'hadir' => $allAttendances->where('status', \App\Enums\AttendanceEnum::PRESENT)->count(),
            'izin' => $allAttendances->where('status', \App\Enums\AttendanceEnum::PERMIT)->count(),
            'sakit' => $allAttendances->where('status', \App\Enums\AttendanceEnum::SICK)->count(),
            'alpha' => $allAttendances->where('status', \App\Enums\AttendanceEnum::ALPHA)->count(),
        ];

        return view('student.pages.attendance.index', compact('attendances', 'studentClasses', 'summary'));
    }
}
