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
     * Display attendance history page for a specific extracurricular.
     */
    public function historyPage(Request $request, Extracurricular $extracurricular)
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

        // Get filter parameters
        $date = $request->input('date');
        $status = $request->input('status');
        $search = $request->input('search');

        // Cleanup: Remove invalid auto-alphas that predate schedule or enrollment
        $invalidAttendanceIds = ExtracurricularAttendance::where('extracurricular_student_id', $enrollment->id)
            ->where('status', 'alpha')
            ->whereNull('extracurricular_journal_id')
            ->get()
            ->filter(function ($att) use ($extracurricular, $enrollment) {
                $attDate = Carbon::parse($att->date)->startOfDay();
                $dayName = strtolower($attDate->format('l'));
                $sched = $extracurricular->schedules->where('day', $dayName)->first();

                if (!$sched)
                    return true; // No schedule for this day anymore
    
                return $attDate->lt($sched->created_at->startOfDay()) ||
                    $attDate->lt($enrollment->created_at->startOfDay());
            })
            ->pluck('id');

        if ($invalidAttendanceIds->isNotEmpty()) {
            ExtracurricularAttendance::whereIn('id', $invalidAttendanceIds)->delete();
        }

        // Query attendances
        $query = ExtracurricularAttendance::with(['journal.schedule'])
            ->where('extracurricular_student_id', $enrollment->id);

        if ($date) {
            $query->where('date', $date);
        }

        if ($status) {
            $query->where('status', $status);
        }

        // Auto-sync Alpha for past schedules to ensure they are "terekap"
        // We look back at the last 30 days or since enrollment date
        $enrollDate = $enrollment->created_at->startOfDay();
        $startDate = now()->subDays(30)->startOfDay();

        // Start from the later of the two dates to avoid excess Alpha records
        if ($startDate->lt($enrollDate)) {
            $startDate = clone $enrollDate;
        }

        $endDate = now();

        $schedules = $extracurricular->schedules;
        $dayMaps = [
            'monday' => Carbon::MONDAY,
            'tuesday' => Carbon::TUESDAY,
            'wednesday' => Carbon::WEDNESDAY,
            'thursday' => Carbon::THURSDAY,
            'friday' => Carbon::FRIDAY,
            'saturday' => Carbon::SATURDAY,
            'sunday' => Carbon::SUNDAY,
        ];

        foreach ($schedules as $sched) {
            $dayInt = $dayMaps[strtolower($sched->day)] ?? null;
            if ($dayInt === null)
                continue;

            $currentDate = clone $startDate;
            $scheduleCreatedDate = $sched->created_at->startOfDay();

            // Move to the first occurrence of this day
            while ($currentDate->dayOfWeek !== $dayInt) {
                $currentDate->addDay();
            }

            while ($currentDate->lte($endDate)) {
                $dateStr = $currentDate->toDateString();

                // Check if schedule existed on this date
                if ($currentDate->lt($scheduleCreatedDate)) {
                    $currentDate->addWeek();
                    continue;
                }

                // Check if time passed for this date
                $timePassed = false;
                if ($currentDate->isPast() && !$currentDate->isToday()) {
                    $timePassed = true;
                } elseif ($currentDate->isToday()) {
                    $endTime = Carbon::parse($sched->end_time);
                    if (now()->gt($endTime)) {
                        $timePassed = true;
                    }
                }

                if ($timePassed) {
                    $exists = ExtracurricularAttendance::where('extracurricular_student_id', $enrollment->id)
                        ->where('date', $dateStr)
                        ->exists();

                    if (!$exists) {
                        // Check for approved permission
                        $permission = \App\Models\ExtracurricularPermission::where('extracurricular_student_id', $enrollment->id)
                            ->where('date', $dateStr)
                            ->where('status', 'approved')
                            ->first();

                        ExtracurricularAttendance::create([
                            'extracurricular_student_id' => $enrollment->id,
                            'date' => $dateStr,
                            'status' => $permission ? $permission->type : 'alpha',
                            'extracurricular_journal_id' => null, // Will be linked if journal created later
                        ]);
                    }
                }
                $currentDate->addWeek();
            }
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(10);

        // Check if there is a schedule today for the "Absen Sekarang" button logic
        $today = strtolower(now()->locale('en')->dayName);
        $todaySchedule = $extracurricular->schedules()
            ->where('day', $today)
            ->first();

        $hasAttendedToday = false;
        if ($todaySchedule) {
            $todayJournal = $extracurricular->journals()
                ->where('schedule_id', $todaySchedule->id)
                ->where('date', now()->toDateString())
                ->first();

            if ($todayJournal) {
                $hasAttendedToday = ExtracurricularAttendance::where('extracurricular_journal_id', $todayJournal->id)
                    ->where('extracurricular_student_id', $enrollment->id)
                    ->exists();
            }
        }

        return view('student.pages.extracurricular.attendance-history', compact(
            'extracurricular',
            'enrollment',
            'attendances',
            'todaySchedule',
            'hasAttendedToday'
        ));
    }

    /**
     * Display attendance check-in page for a specific extracurricular.
     */
    public function createAttendance(Extracurricular $extracurricular)
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
            return redirect()->route('student.extracurricular.attendance', $extracurricular->id)
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
            session()->flash('error', 'Anda tidak terdaftar di ekstrakurikuler ini');
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak terdaftar di ekstrakurikuler ini'
            ], 403);
        }

        // Get schedule
        $schedule = $extracurricular->schedules()->find($request->schedule_id);

        if (!$schedule || !$schedule->latitude || !$schedule->longitude) {
            session()->flash('error', 'Jadwal tidak valid atau lokasi belum ditentukan');
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
            $errorMessage = "Anda berada di luar jangkauan lokasi absensi. Jarak Anda: " . round($distance) . "m, Radius: {$radius}m";
            session()->flash('error', $errorMessage);
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 400);
        }

        // Check for existing journal today
        $todayJournal = $extracurricular->journals()
            ->where('schedule_id', $schedule->id)
            ->where('date', now()->toDateString())
            ->first();

        if ($todayJournal) {
            // Check if already attended
            $existingAttendance = ExtracurricularAttendance::where('extracurricular_journal_id', $todayJournal->id)
                ->where('extracurricular_student_id', $enrollment->id)
                ->first();

            if ($existingAttendance && $existingAttendance->status === 'hadir') {
                session()->flash('warning', 'Anda sudah melakukan absensi hari ini');
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
                    'status' => 'hadir',
                    'date' => now()->toDateString(),
                ]
            );
        } else {
            // Check if already attended (without journal)
            $existingAttendance = ExtracurricularAttendance::where('extracurricular_student_id', $enrollment->id)
                ->where('date', now()->toDateString())
                ->first();

            if ($existingAttendance && $existingAttendance->status === 'hadir') {
                session()->flash('warning', 'Anda sudah melakukan absensi hari ini');
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absensi hari ini'
                ], 400);
            }

            ExtracurricularAttendance::updateOrCreate(
                [
                    'extracurricular_journal_id' => null,
                    'extracurricular_student_id' => $enrollment->id,
                    'date' => now()->toDateString(),
                ],
                [
                    'status' => 'hadir',
                ]
            );
        }

        $successMessage = 'Absensi berhasil dicatat! Jarak Anda: ' . round($distance) . 'm';
        session()->flash('success', $successMessage);

        return response()->json([
            'success' => true,
            'message' => $successMessage
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
     * Display create permission page for a specific extracurricular.
     */
    public function createPermission(Extracurricular $extracurricular)
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

        // Get schedules
        $schedules = $extracurricular->schedules;

        return view('student.pages.extracurricular.create-permission', compact(
            'extracurricular',
            'enrollment',
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
            ->where('date', $request->date)
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

        return redirect()->route('student.extracurricular.permission', $extracurricular->id)->with('success', 'Pengajuan izin berhasil dikirim');
    }
}
