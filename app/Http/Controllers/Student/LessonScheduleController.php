<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Interfaces\ClassroomStudentInterface;
use App\Models\LessonSchedule;
use App\Models\LessonHour;
use Illuminate\Support\Facades\Auth;

class LessonScheduleController extends Controller
{
    private ClassroomStudentInterface $studentClass;

    public function __construct(ClassroomStudentInterface $studentClass)
    {
        $this->studentClass = $studentClass;
    }

    /**
     * Display the lesson schedule for the student's classroom.
     */
    public function index()
    {
        $studentClasses = $this->studentClass->whereStudent(auth()->user()->student->id);
        
        if (!$studentClasses) {
            Auth::logout();
            return redirect('/login')->with('error', 'Akun anda belum terdaftar dalam kelas');
        }

        // Get classroom info
        $classroom = $studentClasses->classroom;

        // Get all lesson hours sorted
        $lessonHours = LessonHour::orderBy('start')->get();

        // Define days of the week
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $dayLabels = [
            'monday' => 'Senin',
            'tuesday' => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday' => 'Kamis',
            'friday' => 'Jumat',
            'saturday' => 'Sabtu',
        ];

        // Get all schedules for this classroom, organized by day
        $schedules = [];
        foreach ($days as $day) {
            $schedules[$day] = LessonSchedule::where('classroom_id', $studentClasses->classroom_id)
                ->where('day', $day)
                ->with(['teacherSubject.subject', 'teacherSubject.employee.user', 'start', 'end'])
                ->orderBy('lesson_hour_start')
                ->get();
        }

        // Get today's day for highlighting
        $today = strtolower(now()->locale('en')->dayName);

        return view('student.pages.lesson-schedule.index', compact(
            'classroom',
            'lessonHours',
            'days',
            'dayLabels',
            'schedules',
            'today'
        ));
    }
}
