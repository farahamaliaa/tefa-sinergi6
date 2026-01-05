<?php

namespace App\Http\Controllers\Staff;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Http\Controllers\Controller;
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
        return view('staff.pages.attendance-history.index', compact('attendances'));
    }

    public function checkIn(Request $request)
    {
        $employeeId = auth()->user()->employee->id;
        $today = now()->format('Y-m-d');

        // Check availability
        $existingAttendance = \App\Models\Attendance::where('model_id', $employeeId)
            ->where('model_type', 'App\Models\Employee')
            ->whereDate('created_at', $today)
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi hari ini.');
        }

        \App\Models\Attendance::create([
            'model_id' => $employeeId,
            'model_type' => 'App\Models\Employee',
            'status' => \App\Enums\AttendanceEnum::PRESENT->value,
            'checkin' => now()->format('H:i:s'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil tersimpan.');
    }
}
