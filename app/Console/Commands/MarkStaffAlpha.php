<?php

namespace App\Console\Commands;

use App\Enums\AttendanceEnum;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkStaffAlpha extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:mark-alpha {--date= : Tanggal untuk cek (default: hari ini)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menandai staff yang tidak absen sebagai ALPHA setelah jam check-in berakhir';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = $this->option('date') ? Carbon::parse($this->option('date')) : Carbon::today();
        
        $lateLimit = config('attendance.time.late_limit', '09:00');
        $checkLimit = Carbon::parse($date->format('Y-m-d') . ' ' . $lateLimit);
        
        if (now()->lt($checkLimit)) {
            $this->info("Belum melewati batas waktu check-in ({$lateLimit}). Proses dibatalkan.");
            return 0;
        }
        $employees = Employee::whereHas('user', function ($query) {
            $query->where('status', 'active');
        })->get();

        $markedCount = 0;

        foreach ($employees as $employee) {
            $hasAttendance = Attendance::where('model_id', $employee->id)
                ->where('model_type', 'App\Models\Employee')
                ->whereDate('created_at', $date)
                ->exists();

            if (!$hasAttendance) {
                Attendance::create([
                    'model_id' => $employee->id,
                    'model_type' => 'App\Models\Employee',
                    'status' => AttendanceEnum::ALPHA->value,
                    'created_at' => $date,
                    'updated_at' => now(),
                ]);

                $markedCount++;
                $this->line("Marked ALPHA: {$employee->user->name}");
            }
        }

        $this->info("Selesai! {$markedCount} staff ditandai sebagai ALPHA untuk tanggal {$date->format('Y-m-d')}.");

        return 0;
    }
}
