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
        $religions = \App\Models\Religion::all();
        return view('staff.pages.profile', compact('user', 'employee', 'religions'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $employee = $user->employee;

        // Check if this is a password update or profile update
        if ($request->filled('current_password') || $request->filled('password')) {
            // Password Update Logic
            $request->validate([
                'current_password' => 'required|string',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/',
                ],
            ], [
                'password.confirmed' => 'Konfirmasi password tidak cocok dengan password baru.',
                'password.min' => 'Password harus minimal 8 karakter.',
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*#?&).',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password lama tidak sesuai'])->withInput();
            }

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return redirect()->back()->with('success', 'Password berhasil diperbarui');
        } else {
            // Profile Info Update Logic
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone_number' => 'nullable|string|max:13',
                'gender' => 'required|in:male,female',
                'address' => 'nullable|string',
                'birth_date' => 'nullable|date',
                'birth_place' => 'nullable|string',
                'religion_id' => 'required|exists:religions,id',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            try {
                DB::transaction(function () use ($request, $user, $employee) {
                    $dataUser = [
                        'name' => $request->name,
                        'email' => $request->email,
                    ];

                    $user->update($dataUser);

                    if ($employee) {
                        $dataEmployee = [
                            'phone_number' => $request->phone_number,
                            'address' => $request->address,
                            'gender' => $request->gender,
                            'birth_date' => $request->birth_date,
                            'birth_place' => $request->birth_place,
                            'religion_id' => $request->religion_id,
                        ];

                        if ($request->hasFile('image')) {
                            if ($employee->image) {
                                $this->remove($employee->image);
                            }
                            $dataEmployee['image'] = $this->upload(UploadDiskEnum::STAFF->value, $request->file('image'));
                        }

                        $employee->update($dataEmployee);
                    }
                });

                return redirect()->back()->with('success', 'Profil berhasil diperbarui');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
            }
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
