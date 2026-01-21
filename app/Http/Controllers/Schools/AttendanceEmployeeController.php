<?php

namespace App\Http\Controllers\Schools;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Exports\TeacherAttendanceExport;
use App\Http\Controllers\Controller;
use App\Services\School\AttendanceEmployeeService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceEmployeeController extends Controller
{
    private AttendanceInterface $attendance;
    private AttendanceEmployeeService $service;

    public function __construct(AttendanceInterface $attendance, AttendanceEmployeeService $service)
    {
        $this->attendance = $attendance;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $attendanceEmployeeChart = $this->service->ChartAttendanceEmployee($this->attendance, $request);
        $attendances = $this->attendance->whereModelAndNow('App\Models\Employee', $request);
        
        // Get selected month/year or use current
        $selectedMonth = $request->month ?? now()->month;
        $selectedYear = $request->year ?? now()->year;
        
        // Get weekly statistics
        $weeklyStats = $this->service->getWeeklyStatistics((int)$selectedMonth, (int)$selectedYear);
        
        // Month names for dropdown
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        return view('school.pages.statistic-presence.employee', compact(
            'attendances', 
            'attendanceEmployeeChart', 
            'weeklyStats', 
            'months', 
            'selectedMonth',
            'selectedYear'
        ));
    }

    /**
     * export kehadiran guru
     * @param Request $request untuk menampilkan data berdasarkan tanggal
     */
    public function export(Request $request)
    {
        return Excel::download(new TeacherAttendanceExport($request, $this->attendance), 'attendance-teacher.xlsx');
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
}
