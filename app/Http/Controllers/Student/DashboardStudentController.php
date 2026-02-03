<?php

namespace App\Http\Controllers\Student;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Contracts\Interfaces\ClassroomStudentInterface;
use App\Http\Controllers\Controller;
use App\Models\ClassroomStudent;
use App\Models\LessonSchedule;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Traits\UploadTrait;
use App\Enums\UploadDiskEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardStudentController extends Controller
{
    use UploadTrait;
    private ClassroomStudentInterface $studentClass;
    private AttendanceInterface $attendance;
    private StudentService $service;

    public function __construct(ClassroomStudentInterface $studentClass, AttendanceInterface $attendance, StudentService $service)
    {
        $this->studentClass = $studentClass;
        $this->attendance = $attendance;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->student) {
            Auth::logout();
            return redirect('/login')->with('error', 'Akun Anda terdaftar sebagai user tetapi data siswa tidak ditemukan. Hubungi admin.');
        }

        $studentClasses = $this->studentClass->whereStudent(auth()->user()->student->id);
        if (!$studentClasses) {
            Auth::logout();
            return redirect('/login')->with('error', 'Akun anda belum ada dalam kelas');
        }
        $single_attendance = $this->attendance->userToday('App\Models\ClassroomStudent', $studentClasses->id);
        $history_attendance = $this->attendance->whereUser($studentClasses->id, 'App\Models\ClassroomStudent');
        $chartAttendance = $this->service->chartAttendance(auth()->user()->student->id);

        $today = strtolower(Carbon::now()->format('l'));

        $todaySchedules = LessonSchedule::where('classroom_id', $studentClasses->classroom_id)
            ->where('day', $today)
            ->with(['teacherSubject.subject', 'teacherSubject.employee.user', 'start', 'end'])
            ->orderBy('lesson_hour_start')
            ->get();

        return view('student.pages.dashboard.dashboard', compact('studentClasses', 'single_attendance', 'history_attendance', 'chartAttendance', 'todaySchedules'));
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
    public function profile()
    {
        $user = auth()->user();
        $student = $user->student;
        $religions = \App\Models\Religion::all();
        return view('student.pages.profile', compact('user', 'student', 'religions'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $student = $user->student;

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
                'gender' => 'required|in:male,female',
                'address' => 'nullable|string',
                'birth_date' => 'nullable|date',
                'birth_place' => 'nullable|string',
                'religion_id' => 'required|exists:religions,id',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ], [
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.max' => 'Nama lengkap maksimal :max karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'gender.required' => 'Jenis kelamin wajib dipilih.',
                'gender.in' => 'Jenis kelamin tidak valid.',
                'religion_id.required' => 'Agama wajib dipilih.',
                'religion_id.exists' => 'Agama tidak valid.',
                'image.image' => 'File harus berupa gambar.',
                'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
                'image.max' => 'Ukuran gambar maksimal 2MB.',
            ]);


            try {
                DB::transaction(function () use ($request, $user, $student) {
                    $dataUser = [
                        'name' => $request->name,
                        'email' => $request->email,
                    ];

                    $user->update($dataUser);

                    if ($student) {
                        $dataStudent = [
                            'gender' => $request->gender,
                            'address' => $request->address,
                            'birth_date' => $request->birth_date,
                            'birth_place' => $request->birth_place,
                            'religion_id' => $request->religion_id,
                        ];

                        if ($request->hasFile('image')) {
                            if ($student->image) {
                                $this->remove($student->image);
                            }
                            $dataStudent['image'] = $this->upload(UploadDiskEnum::STUDENT->value, $request->file('image'));
                        }

                        $student->update($dataStudent);
                    }
                });

                return redirect()->back()->with('success', 'Profil berhasil diperbarui');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
            }
        }
    }
}

