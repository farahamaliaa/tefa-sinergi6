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
}
