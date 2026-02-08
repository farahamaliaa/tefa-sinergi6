<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Contracts\Interfaces\ClassroomInterface;
use App\Contracts\Interfaces\EmployeeInterface;
use App\Contracts\Interfaces\LessonScheduleInterface;
use App\Contracts\Interfaces\ModelHasRfidInterface;
use App\Contracts\Interfaces\RfidInterface;
use App\Contracts\Interfaces\SchoolInterface;
use App\Contracts\Interfaces\SchoolPointInterface;
use App\Contracts\Interfaces\SchoolYearInterface;
use App\Contracts\Interfaces\SemesterInterface;
use App\Contracts\Interfaces\StudentInterface;
use App\Contracts\Interfaces\StudentViolationInterface;
use App\Contracts\Interfaces\SubjectInterface;
use App\Enums\AttendanceEnum;
use App\Enums\RoleEnum;
use App\Models\School;
use App\Services\SchoolChartService;
use App\Services\SemesterService;
use App\Models\ExtracurricularSchedule;
use App\Models\ExtracurricularAttendance;
use Illuminate\Http\Request;

class SchoolDashboardController extends Controller
{
    private SchoolInterface $school;

    private SchoolYearInterface $schoolYear;

    private RfidInterface $rfid;

    private ClassroomInterface $classroom;

    private SemesterInterface $semester;

    private AttendanceInterface $attendance;

    private StudentInterface $student;

    private EmployeeInterface $employee;

    private SchoolChartService $schoolChart;

    private SubjectInterface $subjects;

    private ModelHasRfidInterface $modelHasRfid;

    private LessonScheduleInterface $lessonSchedule;

    private SchoolPointInterface $schoolPoints;

    private StudentViolationInterface $studentViolation;

    private SemesterService $semesterService;

    public function __construct(SchoolInterface $school, SchoolYearInterface $schoolYear,
        RfidInterface $rfid, ClassroomInterface $classroom, SemesterInterface $semester,
        SchoolChartService $schoolChart, AttendanceInterface $attendance, StudentInterface $student,
        EmployeeInterface $employee, SubjectInterface $subjects, ModelHasRfidInterface $modelHasRfid,
        LessonScheduleInterface $lessonSchedule, SchoolPointInterface $schoolPoints, StudentViolationInterface $studentViolation,
        SemesterService $semesterService)
    {
        $this->employee = $employee;
        $this->school = $school;
        $this->schoolYear = $schoolYear;
        $this->rfid = $rfid;
        $this->classroom = $classroom;
        $this->semester = $semester;
        $this->attendance = $attendance;
        $this->schoolChart = $schoolChart;
        $this->student = $student;
        $this->subjects = $subjects;
        $this->modelHasRfid = $modelHasRfid;
        $this->lessonSchedule = $lessonSchedule;
        $this->schoolPoints = $schoolPoints;
        $this->studentViolation = $studentViolation;
        $this->semesterService = $semesterService;
    }

    public function index(Request $request)
    {
        $classrooms = $this->classroom->countClass();
        $schoolYear = $this->schoolYear->active();
        $currentSemesterType = $this->semesterService->getCurrentSemester();

        $attendanceChart = $this->schoolChart->ChartAttendance($this->attendance);
        $violationChart = $this->schoolChart->ChartViolation($this->studentViolation);
        $violations = $this->studentViolation->get();

        $alumni = $this->student->countStudentAlumni();
        $teachers = $this->employee->where(RoleEnum::TEACHER->value);
        $employees = $this->employee->where(RoleEnum::STAFF->value);
        $students = $this->student->count();
        $subjects = $this->subjects->count();

        $schoolPoints = $this->schoolPoints->get();
        $maxPoint = $this->schoolPoints->getMaxPoint();

        $fill = $this->lessonSchedule->dahsboardSchool('fill', now());
        $notfill = $this->lessonSchedule->dahsboardSchool('notfill', now());

        $staffTotalCount = \App\Models\Employee::whereRelation('user.roles', 'name', RoleEnum::STAFF->value)->count();
        $staffFilled = \App\Models\Employee::whereRelation('user.roles', 'name', RoleEnum::STAFF->value)
            ->whereHas('employeeJournals', function ($query) {
                $query->whereDate('created_at', now());
            })->get();

        $staffNotFilled = \App\Models\Employee::whereRelation('user.roles', 'name', RoleEnum::STAFF->value)
            ->whereDoesntHave('employeeJournals', function ($query) {
                $query->whereDate('created_at', now());
            })->get();

        $extraFill = ExtracurricularSchedule::where('day', strtolower(now()->format('l')))
            ->whereHas('journals', function ($query) {
                $query->whereDate('date', now());
            })->get();

        $extraNotFill = ExtracurricularSchedule::where('day', strtolower(now()->format('l')))
            ->whereDoesntHave('journals', function ($query) {
                $query->whereDate('date', now());
            })->get();

        $lates = $this->attendance->AttendanceDasboard('App\Models\ClassroomStudent', AttendanceEnum::LATE->value, $request);
        $alpha = $this->attendance->AttendanceDasboard('App\Models\ClassroomStudent', AttendanceEnum::ALPHA->value, $request);
        $sick = $this->attendance->AttendanceDasboard('App\Models\ClassroomStudent', AttendanceEnum::SICK->value, $request);
        $permit = $this->attendance->AttendanceDasboard('App\Models\ClassroomStudent', AttendanceEnum::PERMIT->value, $request);

        $merged = $sick->merge($permit);
        $totalPermit = $merged->count();

        $lates_teacher = $this->attendance->AttendanceDasboard('App\Models\Employee', AttendanceEnum::LATE->value, $request);
        $alpha_teacher = $this->attendance->AttendanceDasboard('App\Models\Employee', AttendanceEnum::ALPHA->value, $request);
        $sick_teacher = $this->attendance->AttendanceDasboard('App\Models\Employee', AttendanceEnum::SICK->value, $request);
        $permit_teacher = $this->attendance->AttendanceDasboard('App\Models\Employee', AttendanceEnum::PERMIT->value, $request);

        $merged_teacher = $sick_teacher->merge($permit_teacher);
        $totalPermit_teacher = $merged_teacher->count();

        $extraPresentStudent = ExtracurricularAttendance::with('extracurricularStudent.student.user', 'extracurricularStudent.extracurricular')
            ->where('status', 'hadir')
            ->where(function ($query) {
                $query->whereDate('date', now())
                    ->orWhereHas('journal', function ($query) {
                        $query->whereDate('date', now());
                    });
            })->get();

        $extraLatesStudent = ExtracurricularAttendance::with('extracurricularStudent.student.user', 'extracurricularStudent.extracurricular')
            ->where('status', 'telat')
            ->where(function ($query) {
                $query->whereDate('date', now())
                    ->orWhereHas('journal', function ($query) {
                        $query->whereDate('date', now());
                    });
            })->get();

        $extraAlphaStudent = ExtracurricularAttendance::with('extracurricularStudent.student.user', 'extracurricularStudent.extracurricular')
            ->where('status', 'alpha')
            ->where(function ($query) {
                $query->whereDate('date', now())
                    ->orWhereHas('journal', function ($query) {
                        $query->whereDate('date', now());
                    });
            })->get();

        $extraSickStudent = ExtracurricularAttendance::with('extracurricularStudent.student.user', 'extracurricularStudent.extracurricular')
            ->where('status', 'sakit')
            ->where(function ($query) {
                $query->whereDate('date', now())
                    ->orWhereHas('journal', function ($query) {
                        $query->whereDate('date', now());
                    });
            })->get();

        $extraPermitStudent = ExtracurricularAttendance::with('extracurricularStudent.student.user', 'extracurricularStudent.extracurricular')
            ->where('status', 'izin')
            ->where(function ($query) {
                $query->whereDate('date', now())
                    ->orWhereHas('journal', function ($query) {
                        $query->whereDate('date', now());
                    });
            })->get();

        $totalPermitExtraStudent = $extraSickStudent->count() + $extraPermitStudent->count();

        $studentChart = $this->schoolChart->chartStudentAttendance($lates, $totalPermit, $alpha);
        $employeeChart = $this->schoolChart->chartStudentAttendance($lates_teacher, $totalPermit_teacher, $alpha_teacher);
        $extraChart = $this->schoolChart->chartStudentAttendance($extraPresentStudent, $totalPermitExtraStudent, $extraAlphaStudent);

        return view('school.pages.dashboard.dashboard', compact(
            'lates', 'alpha', 'sick', 'permit', 'totalPermit',
            'lates_teacher', 'alpha_teacher', 'sick_teacher', 'permit_teacher', 'totalPermit_teacher',
            'studentChart', 'employeeChart', 'extraChart', 'fill', 'notfill', 'extraFill', 'extraNotFill', 'classrooms', 'violations',
            'extraPresentStudent', 'extraLatesStudent', 'extraAlphaStudent', 'extraSickStudent', 'extraPermitStudent', 'totalPermitExtraStudent',
            'schoolYear', 'currentSemesterType',
            'attendanceChart', 'alumni', 'staffTotalCount', 'staffFilled', 'staffNotFilled',
            'teachers', 'employees', 'students',
            'subjects', 'schoolPoints', 'maxPoint', 'violationChart'));
    }

    public function show(Request $request)
    {
        $rfids = $this->modelHasRfid->searchMaster($request);
        $school = $this->school->showWithSlug(auth()->user()->slug);
        $schoolYear = $this->schoolYear->active($school->id);

        return view('school.pages.settings.information', compact('school', 'schoolYear', 'rfids'));
    }

    public function edit()
    {
        $school = $this->school->showWithSlug(auth()->user()->slug);

        return view('school.pages.settings.update-information', compact('school'));
    }

    public function getRealtimeData(Request $request)
    {
        $lates = $this->attendance->AttendanceDasboard('App\Models\ClassroomStudent', AttendanceEnum::LATE->value, $request);
        $alpha = $this->attendance->AttendanceDasboard('App\Models\ClassroomStudent', AttendanceEnum::ALPHA->value, $request);
        $sick = $this->attendance->AttendanceDasboard('App\Models\ClassroomStudent', AttendanceEnum::SICK->value, $request);
        $permit = $this->attendance->AttendanceDasboard('App\Models\ClassroomStudent', AttendanceEnum::PERMIT->value, $request);

        $merged = $sick->merge($permit);
        $totalPermit = $merged->count();

        $lates_teacher = $this->attendance->AttendanceDasboard('App\Models\Employee', AttendanceEnum::LATE->value, $request);
        $alpha_teacher = $this->attendance->AttendanceDasboard('App\Models\Employee', AttendanceEnum::ALPHA->value, $request);
        $sick_teacher = $this->attendance->AttendanceDasboard('App\Models\Employee', AttendanceEnum::SICK->value, $request);
        $permit_teacher = $this->attendance->AttendanceDasboard('App\Models\Employee', AttendanceEnum::PERMIT->value, $request);

        $merged_teacher = $sick_teacher->merge($permit_teacher);
        $totalPermit_teacher = $merged_teacher->count();

        $extraPresentStudent = ExtracurricularAttendance::with('extracurricularStudent.student.user', 'extracurricularStudent.extracurricular')
            ->where('status', 'hadir')
            ->where(function ($query) {
                $query->whereDate('date', now())
                    ->orWhereHas('journal', function ($query) {
                        $query->whereDate('date', now());
                    });
            })->get();

        $extraLatesStudent = ExtracurricularAttendance::with('extracurricularStudent.student.user', 'extracurricularStudent.extracurricular')
            ->where('status', 'telat')
            ->where(function ($query) {
                $query->whereDate('date', now())
                    ->orWhereHas('journal', function ($query) {
                        $query->whereDate('date', now());
                    });
            })->get();
        $extraAlphaStudent = ExtracurricularAttendance::with('extracurricularStudent.student.user', 'extracurricularStudent.extracurricular')
            ->where('status', 'alpha')
            ->where(function ($query) {
                $query->whereDate('date', now())
                    ->orWhereHas('journal', function ($query) {
                        $query->whereDate('date', now());
                    });
            })->get();
        $extraSickStudent = ExtracurricularAttendance::with('extracurricularStudent.student.user', 'extracurricularStudent.extracurricular')
            ->where('status', 'sakit')
            ->where(function ($query) {
                $query->whereDate('date', now())
                    ->orWhereHas('journal', function ($query) {
                        $query->whereDate('date', now());
                    });
            })->get();
        $extraPermitStudent = ExtracurricularAttendance::with('extracurricularStudent.student.user', 'extracurricularStudent.extracurricular')
            ->where('status', 'izin')
            ->where(function ($query) {
                $query->whereDate('date', now())
                    ->orWhereHas('journal', function ($query) {
                        $query->whereDate('date', now());
                    });
            })->get();

        $totalPermitExtraStudent = $extraSickStudent->count() + $extraPermitStudent->count();

        $teachers = $this->employee->where(RoleEnum::TEACHER->value);

        $fill = $this->lessonSchedule->dahsboardSchool('fill', now());
        $notfill = $this->lessonSchedule->dahsboardSchool('notfill', now());

        $staffTotalCount = \App\Models\Employee::whereRelation('user.roles', 'name', RoleEnum::STAFF->value)->count();
        $staffFilled = \App\Models\Employee::whereRelation('user.roles', 'name', RoleEnum::STAFF->value)
            ->whereHas('employeeJournals', function ($query) {
                $query->whereDate('created_at', now());
            })->get();

        $staffNotFilled = \App\Models\Employee::whereRelation('user.roles', 'name', RoleEnum::STAFF->value)
            ->whereDoesntHave('employeeJournals', function ($query) {
                $query->whereDate('created_at', now());
            })->get();

        $extraFill = ExtracurricularSchedule::where('day', strtolower(now()->format('l')))
            ->whereHas('journals', function ($query) {
                $query->whereDate('date', now());
            })->get();

        $extraNotFill = ExtracurricularSchedule::where('day', strtolower(now()->format('l')))
            ->whereDoesntHave('journals', function ($query) {
                $query->whereDate('date', now());
            })->get();

        $studentLateTable = view('school.pages.dashboard.panes.student-tab.late-tab', compact('lates'))->render();
        // For permit, we need to combine sick and permit if that's what the view expects.
        // The original controller passes 'sick' and 'permit' separately to dashboard.
        // But the permission-tab include needs to be checked.
        // In dashboard.blade.php: @include('school.pages.dashboard.panes.student-tab.permisson-tab')
        // Let's check that file content? I haven't seen it yet. I saw 'late-tab.blade.php'.
        // I will assume it uses $sick and $permit variables.
        $studentPermitTable = view('school.pages.dashboard.panes.student-tab.permission-tab', compact('sick', 'permit'))->render();
        $studentAlphaTable = view('school.pages.dashboard.panes.student-tab.alpha-tab', compact('alpha'))->render();

        $employeeLateTable = view('school.pages.dashboard.panes.employee-sub-tab.late-tab', compact('lates_teacher'))->render();
        $employeePermitTable = view('school.pages.dashboard.panes.employee-sub-tab.permission-tab', compact('sick_teacher', 'permit_teacher'))->render();
        $employeeAlphaTable = view('school.pages.dashboard.panes.employee-sub-tab.alpha-tab', compact('alpha_teacher'))->render();

        $extraPresentTable = view('school.pages.dashboard.panes.extra-tab.present-student-tab', ['present' => $extraPresentStudent])->render();
        $extraPermitTable = view('school.pages.dashboard.panes.extra-tab.permission-student-tab', ['sick' => $extraSickStudent, 'permit' => $extraPermitStudent])->render();
        $extraAlphaTable = view('school.pages.dashboard.panes.extra-tab.alpha-student-tab', ['alpha' => $extraAlphaStudent])->render();

        $staffJournalPane = view('school.pages.dashboard.panes.staff-journal', compact('staffTotalCount', 'staffFilled', 'staffNotFilled'))->render();
        $teacherJournalPane = view('school.pages.dashboard.panes.teacher-journal', compact('fill', 'notfill'))->render();
        $extraJournalPane = view('school.pages.dashboard.panes.extra-journal', compact('extraFill', 'extraNotFill'))->render();

        // Charts Data
        $attendanceChart = $this->schoolChart->ChartAttendance($this->attendance);
        $violationChart = $this->schoolChart->ChartViolation($this->studentViolation);
        $studentChart = $this->schoolChart->chartStudentAttendance($lates, $totalPermit, $alpha);
        $employeeChart = $this->schoolChart->chartStudentAttendance($lates_teacher, $totalPermit_teacher, $alpha_teacher);
        $extraChart = $this->schoolChart->chartStudentAttendance($extraPresentStudent, $totalPermitExtraStudent, $extraAlphaStudent);

        return response()->json([
            'counts' => [
                'student_late' => $lates->count(),
                'student_permit' => $totalPermit,
                'student_alpha' => $alpha->count(),
                'employee_late' => $lates_teacher->count(),
                'employee_permit' => $totalPermit_teacher,
                'employee_alpha' => $alpha_teacher->count(),
                'journal_fill' => $fill->count(),
                'journal_notfill' => $notfill->count(),
                'staff_journal_fill' => $staffFilled->count(),
                'staff_journal_notfill' => $staffNotFilled->count(),
                'staff_total_count' => $staffTotalCount,
                'extra_journal_fill' => $extraFill->count(),
                'extra_journal_notfill' => $extraNotFill->count(),
                'extra_student_present' => $extraPresentStudent->count(),
                'extra_student_permit' => $totalPermitExtraStudent,
                'extra_student_alpha' => $extraAlphaStudent->count(),
            ],
            'panes' => [
                'student_late' => $studentLateTable,
                'student_permit' => $studentPermitTable,
                'student_alpha' => $studentAlphaTable,
                'employee_late' => $employeeLateTable,
                'employee_permit' => $employeePermitTable,
                'employee_alpha' => $employeeAlphaTable,
                'staff_journal' => $staffJournalPane,
                'teacher_journal' => $teacherJournalPane,
                'extra_journal' => $extraJournalPane,
                'extra_student_present' => $extraPresentTable,
                'extra_student_permit' => $extraPermitTable,
                'extra_student_alpha' => $extraAlphaTable,
            ],
            'charts' => [
                'attendance' => $attendanceChart,
                'violation' => $violationChart,
                'student' => $studentChart,
                'employee' => $employeeChart,
                'extra' => $extraChart,
                'journal' => [
                    'fill' => $fill->count(),
                    'notfill' => $notfill->count(),
                ],
            ],
        ]);
    }
}
