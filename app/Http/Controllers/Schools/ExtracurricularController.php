<?php

namespace App\Http\Controllers\Schools;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Http\Controllers\Controller;
use App\Contracts\Interfaces\EmployeeInterface;
use App\Contracts\Interfaces\ExtracurricularInterface;
use App\Contracts\Interfaces\ExtracurricularStudentInterface;
use App\Contracts\Interfaces\SchoolYearInterface;
use App\Models\Extracurricular;
use App\Models\Employee;
use App\Http\Requests\StoreExtracurricularRequest;
use App\Http\Requests\UpdateExtracurricularRequest;
use App\Services\ExtracurricularService;
use App\Models\User;
use Illuminate\Http\Request;

class ExtracurricularController extends Controller
{
    private ExtracurricularInterface $extracurricular;
    private ExtracurricularService $service;
    private EmployeeInterface $employee;
    private SchoolYearInterface $schoolYear;
    private ExtracurricularStudentInterface $extracurricularStudent;
    private ClassroomInterface $classroom;

    public function __construct(ExtracurricularInterface $extracurricular, ExtracurricularService $service, EmployeeInterface $employee, SchoolYearInterface $schoolYear, ExtracurricularStudentInterface $extracurricularStudent, ClassroomInterface $classroom)
    {
        $this->extracurricular = $extracurricular;
        $this->service = $service;
        $this->employee = $employee;
        $this->schoolYear = $schoolYear;
        $this->extracurricularStudent = $extracurricularStudent;
        $this->classroom = $classroom;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get users with role 'teacher', 'staff', or 'extracurricular' and their employee data
        $employees = User::role(['teacher', 'staff', 'extracurricular'])
            ->with('employee')
            ->orderBy('name')
            ->get();
        $extracurriculars = $this->extracurricular->extracurricularGet($request);
        return view('school.pages.extracurricular.index', compact('extracurriculars', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Get or create employee for a user
     */
    private function getOrCreateEmployee(User $user): Employee
    {
        if ($user->employee) {
            return $user->employee;
        }

        // Create a new employee record with minimal data
        return Employee::create([
            'user_id' => $user->id,
            'nip' => 'EXT-' . strtoupper(substr(md5($user->id), 0, 10)),
            'birth_date' => now()->subYears(25)->format('Y-m-d'),
            'birth_place' => '-',
            'gender' => 'male',
            'nik' => str_pad(rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT),
            'phone_number' => '-',
            'address' => '-',
            'status' => 'teacher', // Using teacher as default
            'active' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExtracurricularRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $employee = $this->getOrCreateEmployee($user);

        $this->extracurricular->store([
            'name' => $request->name,
            'employee_id' => $employee->id,
        ]);
        return redirect()->back()->with('success', 'Berhasil menambahkan ekstrakulikuler');
    }

    /**
     * Display the specified resource.
     */
    public function show(Extracurricular $extracurricular, Request $request)
    {
        $schoolYear = $this->schoolYear->active();
        $extracurricularStudents = $this->extracurricularStudent->where($extracurricular->id, $request);
        $classrooms = $this->classroom->where($request, $schoolYear->id);
        // Get users with role 'teacher', 'staff', or 'extracurricular' and their employee data
        $employees = User::role(['teacher', 'staff', 'extracurricular'])
            ->with('employee')
            ->orderBy('name')
            ->get();

        $journals = $extracurricular->journals()
            ->with('schedule', 'attendances')
            ->orderBy('date', 'desc')
            ->get();

        return view('school.pages.extracurricular.detail', compact('extracurricular', 'schoolYear', 'extracurricularStudents', 'classrooms', 'employees', 'journals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Extracurricular $extracurricular)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExtracurricularRequest $request, Extracurricular $extracurricular)
    {
        $user = User::findOrFail($request->user_id);
        $employee = $this->getOrCreateEmployee($user);

        $this->extracurricular->update($extracurricular->id, [
            'name' => $request->name,
            'employee_id' => $employee->id,
        ]);
        return redirect()->back()->with('success', 'Berhasil memperbarui ekstrakulikuler');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Extracurricular $extracurricular)
    {
        $this->extracurricular->delete($extracurricular->id);
        return redirect()->back()->with('success', 'Berhasil menghapus ekstrakulikuler');
    }

    public function statistic(Request $request)
    {
        $extracurriculars = $this->extracurricular->extracurricularGet($request);
        return view('school.pages.statistic-presence.extracurricular', compact('extracurriculars'));
    }

    /**
     * Store a new schedule for the extracurricular.
     */
    public function storeSchedule(Request $request, Extracurricular $extracurricular)
    {
        $request->validate([
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // Store schedule
        $extracurricular->schedules()->create([
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan');
    }

    /**
     * Delete a schedule.
     */
    public function destroySchedule($scheduleId)
    {
        $schedule = \App\Models\ExtracurricularSchedule::findOrFail($scheduleId);
        $schedule->delete();

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus');
    }

    /**
     * Show a journal detail.
     */
    public function journalShow(Extracurricular $extracurricular, $journal)
    {
        $journal = \App\Models\ExtracurricularJournal::with(
            'extracurricular',
            'schedule',
            'attendances.extracurricularStudent.student.user'
        )->findOrFail($journal);

        return view('school.pages.extracurricular.journal-detail', compact('extracurricular', 'journal'));
    }
}
