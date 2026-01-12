<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\ExtracurricularAttendance;
use App\Models\ExtracurricularStudent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExtracurricularStudentController extends Controller
{
    /**
     * Display list of extracurricular activities for the current student.
     */
    public function index()
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Data siswa tidak ditemukan');
        }

        // Get all extracurriculars the student is enrolled in
        $enrollments = ExtracurricularStudent::with([
            'extracurricular.schedules',
            'extracurricular.employee.user'
        ])
            ->where('student_id', $student->id)
            ->get();

        $today = strtolower(now()->locale('en')->dayName);

        return view('student.pages.extracurricular.index', compact('enrollments', 'today'));
    }

    /**
     * Display attendance page for a specific extracurricular.
     */
    public function attendancePage(Extracurricular $extracurricular)
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Data siswa tidak ditemukan');
        }

        // Check if student is enrolled in this extracurricular
        $enrollment = ExtracurricularStudent::where('student_id', $student->id)
            ->where('extracurricular_id', $extracurricular->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.extracurricular.index')
                ->with('error', 'Anda tidak terdaftar di ekstrakurikuler ini');
        }

        // Get today's schedule
        $today = strtolower(now()->locale('en')->dayName);
        $todaySchedule = $extracurricular->schedules()
            ->where('day', $today)
            ->first();

        if (!$todaySchedule) {
            return redirect()->route('student.extracurricular.index')
                ->with('error', 'Tidak ada jadwal ekstrakurikuler hari ini');
        }

        return view('student.pages.extracurricular.attendance', compact(
            'extracurricular',
            'enrollment',
            'todaySchedule'
        ));
    }

    /**
     * Display schedule page for a specific extracurricular.
     */
    public function schedulePage(Extracurricular $extracurricular)
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Data siswa tidak ditemukan');
        }

        // Check if student is enrolled in this extracurricular
        $enrollment = ExtracurricularStudent::where('student_id', $student->id)
            ->where('extracurricular_id', $extracurricular->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.extracurricular.index')
                ->with('error', 'Anda tidak terdaftar di ekstrakurikuler ini');
        }

        // Get all schedules for this extracurricular
        $schedules = $extracurricular->schedules()->orderBy('day')->get();

        return view('student.pages.extracurricular.schedule', compact(
            'extracurricular',
            'enrollment',
            'schedules'
        ));
    }

    /**
     * Store attendance with location verification.
     */
    public function storeAttendance(Request $request, Extracurricular $extracurricular)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'schedule_id' => 'required|exists:extracurricular_schedules,id',
        ]);

        $user = auth()->user();
        $student = $user->student;

        // Get enrollment
        $enrollment = ExtracurricularStudent::where('student_id', $student->id)
            ->where('extracurricular_id', $extracurricular->id)
            ->first();

        if (!$enrollment) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak terdaftar di ekstrakurikuler ini'
            ], 403);
        }

        // Get schedule
        $schedule = $extracurricular->schedules()->find($request->schedule_id);

        if (!$schedule || !$schedule->latitude || !$schedule->longitude) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak valid atau lokasi belum ditentukan'
            ], 400);
        }

        // Calculate distance using Haversine formula
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $schedule->latitude,
            $schedule->longitude
        );

        $radius = $schedule->radius ?? 100;

        if ($distance > $radius) {
            return response()->json([
                'success' => false,
                'message' => "Anda berada di luar jangkauan lokasi absensi. Jarak Anda: " . round($distance) . "m, Radius: {$radius}m"
            ], 400);
        }

        // Check for existing journal today
        $todayJournal = $extracurricular->journals()
            ->where('schedule_id', $schedule->id)
            ->whereDate('date', now()->toDateString())
            ->first();

        if ($todayJournal) {
            // Check if already attended
            $existingAttendance = ExtracurricularAttendance::where('extracurricular_journal_id', $todayJournal->id)
                ->where('extracurricular_student_id', $enrollment->id)
                ->first();

            if ($existingAttendance && $existingAttendance->status === 'hadir') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absensi hari ini'
                ], 400);
            }

            // Update or create attendance
            ExtracurricularAttendance::updateOrCreate(
                [
                    'extracurricular_journal_id' => $todayJournal->id,
                    'extracurricular_student_id' => $enrollment->id,
                ],
                [
                    'status' => 'hadir'
                ]
            );
        } else {
            // Create a simple journal entry for attendance tracking
            $journal = $extracurricular->journals()->create([
                'schedule_id' => $schedule->id,
                'date' => now()->toDateString(),
                'description' => 'Absensi mandiri siswa',
                'image' => null, // Will be filled by pembina later
            ]);

            ExtracurricularAttendance::create([
                'extracurricular_journal_id' => $journal->id,
                'extracurricular_student_id' => $enrollment->id,
                'status' => 'hadir',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil dicatat! Jarak Anda: ' . round($distance) . 'm'
        ]);
    }

    /**
     * Calculate distance between two coordinates using Haversine formula.
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Earth's radius in meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Display permission request page for a specific extracurricular.
     */
    public function permissionPage(Extracurricular $extracurricular)
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Data siswa tidak ditemukan');
        }

        $enrollment = ExtracurricularStudent::where('student_id', $student->id)
            ->where('extracurricular_id', $extracurricular->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.extracurricular.index')
                ->with('error', 'Anda tidak terdaftar di ekstrakurikuler ini');
        }

        // Get my previous permissions
        $permissions = \App\Models\ExtracurricularPermission::where('extracurricular_student_id', $enrollment->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get schedules
        $schedules = $extracurricular->schedules;

        return view('student.pages.extracurricular.permission', compact(
            'extracurricular',
            'enrollment',
            'permissions',
            'schedules'
        ));
    }

    /**
     * Store a new permission request.
     */
    public function storePermission(Request $request, Extracurricular $extracurricular)
    {
        $request->validate([
            'schedule_id' => 'required|exists:extracurricular_schedules,id',
            'date' => 'required|date|after_or_equal:today',
            'type' => 'required|in:izin,sakit',
            'reason' => 'required|string|max:500',
            'attachment' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $student = $user->student;

        $enrollment = ExtracurricularStudent::where('student_id', $student->id)
            ->where('extracurricular_id', $extracurricular->id)
            ->first();

        if (!$enrollment) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar di ekstrakurikuler ini');
        }

        // Check for existing permission on same date
        $existing = \App\Models\ExtracurricularPermission::where('extracurricular_student_id', $enrollment->id)
            ->where('schedule_id', $request->schedule_id)
            ->whereDate('date', $request->date)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan izin untuk jadwal dan tanggal ini');
        }

        // Handle attachment upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('extracurricular/permissions', 'public');
        }

        \App\Models\ExtracurricularPermission::create([
            'extracurricular_id' => $extracurricular->id,
            'extracurricular_student_id' => $enrollment->id,
            'schedule_id' => $request->schedule_id,
            'date' => $request->date,
            'type' => $request->type,
            'reason' => $request->reason,
            'attachment' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pengajuan izin berhasil dikirim');
    }
}
