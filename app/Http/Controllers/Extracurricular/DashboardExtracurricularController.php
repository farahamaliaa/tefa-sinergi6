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
        return view('extracurricular.pages.profile', compact('user', 'employee'));
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
}
