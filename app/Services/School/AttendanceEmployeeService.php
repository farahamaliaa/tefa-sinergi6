<?php

namespace App\Services\School;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Enums\AttendanceEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceEmployeeService
{
    private AttendanceInterface $attendance;

    public function __construct(AttendanceInterface $attendance)
    {
        $this->attendance = $attendance;
    }

    public function ChartAttendanceEmployee(AttendanceInterface $attendance, Request $request)
    {
        $StartRequestday = Carbon::parse($request->start_date)->format('Y-m-d'). ' 00:00:00';
        $EndRequestday = Carbon::parse($request->end_date)->format('Y-m-d'). ' 23:59:59';

        $StartCurentdate = Carbon::today();
        $EndCurentdate = Carbon::tomorrow();

        $grafikDataCollection = [];

        $attendance_present = $this->attendance->AttendanceChartEmployee($StartRequestday ? $StartRequestday : $StartCurentdate, $EndRequestday ? $EndRequestday : $EndCurentdate, AttendanceEnum::PRESENT->value);
        $attendance_permit = $this->attendance->AttendanceChartEmployee($StartRequestday ? $StartRequestday : $StartCurentdate, $EndRequestday ? $EndRequestday : $EndCurentdate, AttendanceEnum::PERMIT->value);
        $attendance_sick = $this->attendance->AttendanceChartEmployee($StartRequestday ? $StartRequestday : $StartCurentdate, $EndRequestday ? $EndRequestday : $EndCurentdate, AttendanceEnum::SICK->value);
        $attendance_alpha = $this->attendance->AttendanceChartEmployee($StartRequestday ? $StartRequestday : $StartCurentdate, $EndRequestday ? $EndRequestday : $EndCurentdate, AttendanceEnum::ALPHA->value);

        $grafikDataCollection[] = [
            'attendance_present' => $attendance_present,
            'attendance_permit' => $attendance_permit,
            'attendance_sick' => $attendance_sick,
            'attendance_alpha' => $attendance_alpha
        ];

        $data  = array_values($grafikDataCollection);

        return $data;
    }

    /**
     * Get weekly attendance statistics for employees
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getWeeklyStatistics(int $month, int $year): array
    {
        $attendances = $this->attendance->getEmployeeAttendanceByWeek($month, $year);
        
        // Initialize weekly data structure (max 5 weeks in a month)
        $weeklyStats = [];
        for ($i = 1; $i <= 5; $i++) {
            $weeklyStats[$i] = [
                'week' => $i,
                'label' => 'Minggu ' . $i,
                'present' => 0,
                'late' => 0,
                'permit' => 0, // izin + sakit
                'alpha' => 0,
                'total' => 0,
            ];
        }

        // Get first day of the month
        $firstDayOfMonth = Carbon::create($year, $month, 1);
        
        foreach ($attendances as $attendance) {
            $attendanceDate = Carbon::parse($attendance->created_at);
            
            // Calculate week number within the month (1-5)
            $weekOfMonth = (int) ceil($attendanceDate->day / 7);
            if ($weekOfMonth > 5) $weekOfMonth = 5;
            
            $status = $attendance->status->value ?? $attendance->status;
            
            switch ($status) {
                case 'present':
                    $weeklyStats[$weekOfMonth]['present']++;
                    break;
                case 'late':
                    $weeklyStats[$weekOfMonth]['late']++;
                    break;
                case 'permit':
                case 'sick':
                    $weeklyStats[$weekOfMonth]['permit']++;
                    break;
                case 'alpha':
                    $weeklyStats[$weekOfMonth]['alpha']++;
                    break;
            }
            $weeklyStats[$weekOfMonth]['total']++;
        }

        // Calculate percentages
        foreach ($weeklyStats as &$week) {
            if ($week['total'] > 0) {
                $week['present_pct'] = round(($week['present'] / $week['total']) * 100);
                $week['late_pct'] = round(($week['late'] / $week['total']) * 100);
                $week['permit_pct'] = round(($week['permit'] / $week['total']) * 100);
                $week['alpha_pct'] = round(($week['alpha'] / $week['total']) * 100);
            } else {
                $week['present_pct'] = 0;
                $week['late_pct'] = 0;
                $week['permit_pct'] = 0;
                $week['alpha_pct'] = 0;
            }
        }

        return array_values($weeklyStats);
    }
}
