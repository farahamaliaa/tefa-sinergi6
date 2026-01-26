<?php

namespace App\Http\Controllers\Staff;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Contracts\Interfaces\ClassroomStudentInterface;
use App\Contracts\Interfaces\EmployeeJournalInterface;
use App\Contracts\Interfaces\SchoolPointInterface;
use App\Contracts\Interfaces\StudentInterface;
use App\Contracts\Interfaces\StudentRepairInterface;
use App\Contracts\Interfaces\StudentViolationInterface;
use App\Enums\AttendanceEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use App\Enums\UploadDiskEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardStaffController extends Controller
{
    use UploadTrait;
    private ClassroomStudentInterface $classroomStudent;
    private StudentViolationInterface $studentViolation;
    private EmployeeJournalInterface $employeeJournal;
    private StudentRepairInterface $studentRepair;
    private SchoolPointInterface $schoolPoint;
    private AttendanceInterface $attendance;
    private StudentInterface $student;

    public function __construct(ClassroomStudentInterface $classroomStudent, StudentViolationInterface $studentViolation, StudentRepairInterface $studentRepair, SchoolPointInterface $schoolPoint, StudentInterface $student, EmployeeJournalInterface $employeeJournal, AttendanceInterface $attendance)
    {
        $this->classroomStudent = $classroomStudent;
        $this->studentViolation = $studentViolation;
        $this->employeeJournal = $employeeJournal;
        $this->studentRepair = $studentRepair;
        $this->schoolPoint = $schoolPoint;
        $this->attendance = $attendance;
        $this->student = $student;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countViolation = $this->studentViolation->count('week');
        $countRepair = $this->studentRepair->count();
        $studentViolation = $this->studentViolation->countByStudent();
        $maxPoint = $this->schoolPoint->getMaxPoint();
        $studentHighPoint = $this->student->highestPoint($maxPoint);
        $employeeJournals = $this->employeeJournal->getEmployee(auth()->user()->id, 'take');

        return view('staff.pages.dashboard.dashboard', compact('countViolation', 'countRepair', 'studentViolation', 'studentHighPoint', 'employeeJournals'));
    }

    public function profile()
    {
        $user = auth()->user();
        $employee = $user->employee;
        return view('staff.pages.profile', compact('user', 'employee'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $employee = $user->employee;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:13',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password lama tidak sesuai'])->withInput();
            }
        }

        try {
            DB::transaction(function () use ($request, $user, $employee) {
                $dataUser = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'gender' => $request->gender,
                ];

                if ($request->hasFile('image')) {
                    if ($user->image) {
                        $this->remove($user->image);
                    }
                    $dataUser['image'] = $this->upload(UploadDiskEnum::TEACHER->value, $request->file('image'));
                }

                if ($request->filled('password')) {
                    $dataUser['password'] = Hash::make($request->password);
                }

                $user->update($dataUser);

                if ($employee) {
                    $employee->update([
                        'phone_number' => $request->phone_number,
                        'address' => $request->address,
                        'gender' => $request->gender,
                    ]);
                }
            });

            return redirect()->back()->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
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
    public function permission(Request $request)
    {
        $students = $this->classroomStudent->get();
        $data = $this->attendance->getSickAndPermit($request, [AttendanceEnum::SICK->value, AttendanceEnum::PERMIT->value]);
        return view('staff.pages.permission.index', compact('data', 'students'));
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
