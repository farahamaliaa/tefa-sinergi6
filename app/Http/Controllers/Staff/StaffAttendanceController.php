<?php

namespace App\Http\Controllers\Staff;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Enums\AttendanceEnum;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class StaffAttendanceController extends Controller
{
    private AttendanceInterface $attendance;

    public function __construct(AttendanceInterface $attendance)
    {
        $this->attendance = $attendance;
    }

    /**
     * Display attendance history for the staff
     */
    public function index()
    {
        $attendances = $this->attendance->whereUser(auth()->user()->employee->id, 'App\Models\Employee');
        $todayAttendance = Attendance::where('model_id', auth()->user()->employee->id)
            ->where('model_type', 'App\Models\Employee')
            ->whereDate('created_at', now()->format('Y-m-d'))
            ->first();
        
        $schoolConfig = config('attendance.school');
        $timeConfig = config('attendance.time');
        
        return view('staff.pages.attendance-history.index', compact('attendances', 'todayAttendance', 'schoolConfig', 'timeConfig'));
    }

    /**
     * Check-in with GPS validation
     */
    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $employeeId = auth()->user()->employee->id;
        $today = now()->format('Y-m-d');

        // Check if already checked in today
        $existingAttendance = Attendance::where('model_id', $employeeId)
            ->where('model_type', 'App\Models\Employee')
            ->whereDate('created_at', $today)
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absensi hari ini.'
            ], 422);
        }

        // Calculate distance to school
        $schoolLat = config('attendance.school.latitude');
        $schoolLng = config('attendance.school.longitude');
        $maxRadius = config('attendance.school.radius');

        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $schoolLat,
            $schoolLng
        );

        // Check if within radius
        if ($distance > $maxRadius) {
            return response()->json([
                'success' => false,
                'message' => 'Anda berada di luar area sekolah (' . round($distance) . 'm dari sekolah). Silakan pilih jenis izin.',
                'distance' => round($distance),
                'require_permission' => true
            ], 422);
        }

        // Determine status (on time or late)
        $now = now();
        $lateLimit = config('attendance.time.check_in_end');
        $status = $now->format('H:i') > $lateLimit ? AttendanceEnum::LATE : AttendanceEnum::PRESENT;

        // Create attendance record
        Attendance::create([
            'model_id' => $employeeId,
            'model_type' => 'App\Models\Employee',
            'status' => $status->value,
            'checkin' => $now->format('H:i:s'),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'location_address' => $request->address ?? null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil! Status: ' . $status->label(),
            'status' => $status->value,
            'distance' => round($distance)
        ]);
    }

    /**
     * Check-out with GPS validation
     */
    public function checkOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $employeeId = auth()->user()->employee->id;
        $today = now()->format('Y-m-d');

        // Find today's attendance
        $attendance = Attendance::where('model_id', $employeeId)
            ->where('model_type', 'App\Models\Employee')
            ->whereDate('created_at', $today)
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan check-in hari ini.'
            ], 422);
        }

        if ($attendance->checkout) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check-out hari ini.'
            ], 422);
        }

        // Update checkout time
        $attendance->update([
            'checkout' => now()->format('H:i:s'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-out berhasil!',
            'checkout_time' => now()->format('H:i')
        ]);
    }

    /**
     * Store attendance with permission (sick/permit/dinas) - no GPS required
     */
    public function storePermission(Request $request)
    {
        $request->validate([
            'status' => 'required|in:sick,permit,dinas',
            'proof' => 'nullable|string',
        ]);

        $employeeId = auth()->user()->employee->id;
        $today = now()->format('Y-m-d');

        // Check if already checked in today
        $existingAttendance = Attendance::where('model_id', $employeeId)
            ->where('model_type', 'App\Models\Employee')
            ->whereDate('created_at', $today)
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absensi hari ini.'
            ], 422);
        }

        // Map status string to enum
        $statusMap = [
            'sick' => AttendanceEnum::SICK,
            'permit' => AttendanceEnum::PERMIT,
            'dinas' => AttendanceEnum::DINAS,
        ];

        $status = $statusMap[$request->status];

        // Create attendance record
        Attendance::create([
            'model_id' => $employeeId,
            'model_type' => 'App\Models\Employee',
            'status' => $status->value,
            'checkin' => now()->format('H:i:s'),
            'proof' => $request->proof,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil! Status: ' . $status->label(),
            'status' => $status->value
        ]);
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     * @return float Distance in meters
     */
    private function calculateDistance($lat1, $lng1, $lat2, $lng2): float
    {
        $earthRadius = 6371000; // Earth's radius in meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
