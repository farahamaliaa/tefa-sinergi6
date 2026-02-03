<?php

namespace App\Console\Commands;

use App\Enums\AttendanceEnum;
use App\Enums\RoleEnum;
use App\Enums\StatusPermissionEnum;
use App\Models\Attendance;
use App\Models\AttendanceRule;
use App\Models\ClassroomStudent;
use App\Models\StudentPermission;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessAttendanceStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:process {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process daily student attendance status (Auto-Alpha for missing check-ins)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting attendance processing...');
        Log::info('attendance:process started.');

        $today = Carbon::now();
        $dayName = strtolower($today->format('l'));
        $dateString = $today->toDateString();
        $currentTime = $today->copy();

        $studentRule = AttendanceRule::where('day', $dayName)->where('role', RoleEnum::STUDENT->value)->first();

        if (!$studentRule) {
            $this->info('No student attendance rules for today. Skipping.');
            return;
        }

        $this->processStudentAttendance($studentRule, $today, $dateString, $currentTime);

        $this->info('Attendance processing complete.');
        Log::info('attendance:process completed.');
    }

    private function processStudentAttendance($studentRule, $today, $dateString, $currentTime)
    {
        $checkinEnd = Carbon::parse($studentRule->checkin_end);
        $maxLate = $studentRule->max_late ?? 0;
        $lateDeadline = $checkinEnd->copy()->addMinutes($maxLate);

        $processAfter = $lateDeadline->copy()->addMinutes(1);

        if ($currentTime->lessThan($processAfter) && !$this->option('force')) {
            $this->info("Student processing scheduled after {$processAfter->format('H:i')}. Current time: {$currentTime->format('H:i')}. Skipping.");
            return;
        }

        $this->info("Processing Student attendance...");

        $activeStudents = ClassroomStudent::whereHas('classroom.schoolYear', function ($q) {
            $q->where('active', 1);
        })->get();

        $studentAlphaCount = 0;
        $permissionCount = 0;
        $skippedCount = 0;

        foreach ($activeStudents as $student) {
            $attendance = Attendance::where('model_type', 'App\Models\ClassroomStudent')
                ->where('model_id', $student->id)
                ->whereDate('created_at', $dateString)
                ->first();

            $permission = StudentPermission::where('student_id', $student->student_id)
                ->where('classroom_id', $student->classroom_id) // Optional: remove if student can change class
                ->whereDate('date', $dateString)
                ->where('status', StatusPermissionEnum::APPROVED->value)
                ->first();

            if ($attendance) {
                // If record exists and is ALPHA, check if we need to update it with permission
                if ($attendance->status === AttendanceEnum::ALPHA->value) {
                    if ($permission) {
                        $attendanceStatus = $this->mapPermissionToAttendance($permission->permission_type);
                        $attendance->update([
                            'status' => $attendanceStatus,
                            // 'point' => 0, // Keep 0 or update based on rule? usually sick/permit is low penalty or 0
                        ]);
                        $permissionCount++;
                        $this->info("Updated Student {$student->id} from ALPHA to {$attendanceStatus->value}");
                    } else {
                        $skippedCount++; // Still Alpha, no permission
                    }
                } else {
                    $skippedCount++; // Already Present/Late/Sick/etc
                }
                continue;
            }

            // If no attendance record exists (CREATE NEW)
            if ($permission) {
                $attendanceStatus = $this->mapPermissionToAttendance($permission->permission_type);
                Attendance::create([
                    'model_type' => 'App\Models\ClassroomStudent',
                    'model_id' => $student->id,
                    'status' => $attendanceStatus,
                    'point' => 0,
                    'created_at' => $today,
                ]);
                $permissionCount++;
            } else {
                Attendance::create([
                    'model_type' => 'App\Models\ClassroomStudent',
                    'model_id' => $student->id,
                    'status' => AttendanceEnum::ALPHA,
                    'point' => 0,
                    'created_at' => $today,
                ]);
                $studentAlphaCount++;
            }
        }

        $this->info("Students: {$studentAlphaCount} Alpha, {$permissionCount} Permission, {$skippedCount} already recorded.");

        if ($studentAlphaCount > 0 || $permissionCount > 0) {
            $this->info("Sending student attendance recap...");
            $this->call('command:send-attendance-recap');
        }
    }

    private function mapPermissionToAttendance(string $permissionType): AttendanceEnum
    {
        return match ($permissionType) {
            'sick' => AttendanceEnum::SICK,
            'permit' => AttendanceEnum::PERMIT,
            'dinas' => AttendanceEnum::DINAS,
            default => AttendanceEnum::PERMIT,
        };
    }
}
