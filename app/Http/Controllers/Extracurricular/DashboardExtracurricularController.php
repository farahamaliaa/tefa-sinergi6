<?php

namespace App\Http\Controllers\Extracurricular;

use App\Contracts\Interfaces\ExtracurricularInterface;
use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use App\Enums\UploadDiskEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Religion;

class DashboardExtracurricularController extends Controller
{
    use UploadTrait;
    private ExtracurricularInterface $extracurricular;

    public function __construct(ExtracurricularInterface $extracurricular)
    {
        $this->extracurricular = $extracurricular;
    }


    public function index()
    {
        $employee = auth()->user()->employee;
        
        if (!$employee) {
            $extracurriculars = collect([]);
            $recentJournals = collect([]);
            return view('extracurricular.pages.dashboard.index', compact('extracurriculars', 'recentJournals'))
                ->with('error', 'Akun Anda belum terhubung dengan data pegawai. Silakan hubungi administrator.');
        }
        
        $extracurriculars = Extracurricular::where('employee_id', $employee->id)
            ->with('extracurricularStudents')
            ->latest()
            ->get();

        // Get recent journals from all extracurriculars
        $extracurricularIds = $extracurriculars->pluck('id');
        $recentJournals = \App\Models\ExtracurricularJournal::whereIn('extracurricular_id', $extracurricularIds)
            ->with('extracurricular', 'schedule', 'attendances')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        // Get schedules organized by day for the tabs
        $schedules = \App\Models\ExtracurricularSchedule::whereIn('extracurricular_id', $extracurricularIds)
            ->with('extracurricular')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function($item) {
                // Ensure day keys are consistent (e.g. 'monday', 'tuesday')
                return strtolower($item->day); 
            });

        return view('extracurricular.pages.dashboard.index', compact('extracurriculars', 'recentJournals', 'schedules'));
    }

    public function profile()
    {
        $user = auth()->user();
        $employee = $user->employee;
        $religions = Religion::all();
        return view('extracurricular.pages.profile', compact('user', 'employee', 'religions'));
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
                'current_password.required' => 'Password lama wajib diisi.',
                'password.required' => 'Password baru wajib diisi.',
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
                'birth_place' => 'nullable|string|max:255',
                'religion_id' => 'required|exists:religions,id',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ], [
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.max' => 'Nama lengkap maksimal :max karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'phone_number.max' => 'Nomor telepon maksimal :max karakter.',
                'gender.required' => 'Jenis kelamin wajib dipilih.',
                'gender.in' => 'Jenis kelamin tidak valid.',
                'religion_id.required' => 'Agama wajib dipilih.',
                'religion_id.exists' => 'Agama tidak valid.',
                'image.image' => 'File harus berupa gambar.',
                'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
                'image.max' => 'Ukuran gambar maksimal 2MB.',
            ]);

            try {
                DB::transaction(function () use ($request, $user, &$employee) {
                    $dataUser = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'gender' => $request->gender,
                    ];

                    $user->update($dataUser);

                    $dataEmployee = [
                        'phone_number' => $request->phone_number,
                        'address' => $request->address,
                        'gender' => $request->gender,
                        'birth_date' => $request->birth_date,
                        'birth_place' => $request->birth_place,
                        'religion_id' => $request->religion_id,
                    ];

                    if ($request->hasFile('image')) {
                        if ($employee && $employee->image) {
                            $this->remove($employee->image);
                        }
                        $dataEmployee['image'] = $this->upload(UploadDiskEnum::TEACHER->value, $request->file('image'));
                    }

                    if ($employee) {
                        $employee->update($dataEmployee);
                    } else {
                        // Create new employee if not exists
                        $dataEmployee['user_id'] = $user->id;
                        $dataEmployee['status'] = 'Pembina Ekskul';
                        $employee = \App\Models\Employee::create($dataEmployee);
                    }
                });

                return redirect()->back()->with('success', 'Profil berhasil diperbarui');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
            }
        }
    }

}
