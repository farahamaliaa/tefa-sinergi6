<?php

namespace App\Http\Controllers\Teacher;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Contracts\Interfaces\ClassroomStudentInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherStudentController extends Controller
{
    private ClassroomStudentInterface $classroomStudent;
    private ClassroomInterface $classroom;

    public function __construct(ClassroomStudentInterface $classroomStudent, ClassroomInterface $classroom)
    {
        $this->classroomStudent = $classroomStudent;
        $this->classroom = $classroom;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classroom = $this->classroom->whereEmployeeId(auth()->user()->employee->id);
        $classroomStudents = $this->classroomStudent->where($classroom->id, $request);
        
        // Get lesson schedules for this classroom
        $lessonSchedules = $classroom->lessonSchedule()
            ->with('teacherSubject.subject', 'teacherSubject.employee.user', 'start', 'end')
            ->orderBy('day')
            ->orderBy('lesson_hour_start')
            ->get()
            ->groupBy('day');
        
        return view('teacher.pages.teacher-student.index', compact('classroomStudents', 'classroom', 'lessonSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
