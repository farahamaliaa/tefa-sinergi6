<?php

namespace App\Console\Commands;

use App\Enums\AttendanceEnum;
use App\Enums\RoleEnum;
use App\Enums\StatusPermissionEnum;
use App\Models\Attendance;
use App\Models\AttendanceRule;
use App\Models\ClassroomStudent;
use App\Models\Employee;
use App\Models\SchoolYear;
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
    protected $signature = 'attendance:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process daily attendance status (Auto-Alpha for missing check-ins, apply approved permissions)';

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

        $studentRule = AttendanceRule::where('day', $dayName)->where('role', RoleEnum::STUDENT->value)->first();
        $teacherRule = AttendanceRule::where('day', $dayName)->where('role', RoleEnum::TEACHER->value)->first();

        if (!$studentRule && !$teacherRule) {
            $this->info("No attendance rules found for today ($dayName). Skipping.");
            Log::info("attendance:process skipped: No rules for $dayName.");
            return;
        }

        if ($studentRule) {
            $checkinEnd = Carbon::parse($studentRule->checkin_end);
            
            $this->info("Processing Students...");
            
            $activeStudents = ClassroomStudent::whereHas('classroom.schoolYear', function($q) {
                $q->where('active', 1);
            })->get();

            $studentCount = 0;
            $permissionCount = 0;

            foreach ($activeStudents as $student) {
                $attendance = Attendance::where('model_type', 'App\Models\ClassroomStudent')
                    ->where('model_id', $student->id)
                    ->whereDate('created_at', $dateString)
                    ->first();

                if (!$attendance) {
                    $permission = StudentPermission::where('student_id', $student->student_id)
                        ->where('classroom_id', $student->classroom_id)
                        ->whereDate('date', $dateString)
                        ->where('status', StatusPermissionEnum::APPROVED->value)
                        ->first();
                    
                    if ($permission) {
                        $attendanceStatus = $this->mapPermissionToAttendance($permission->permission_type);
                        
                        Attendance::create([
                            'model_type' => 'App\Models\ClassroomStudent',
                            'model_id' => $student->id,
                            'status' => $attendanceStatus,
                            'point' => 0,
                            'created_at' => $today,
                            'updated_at' => $today,
                        ]);
                        $permissionCount++;
                        Log::info("Created {$attendanceStatus->value} attendance for student {$student->id} based on approved permission.");
                    } else {
                        Attendance::create([
                            'model_type' => 'App\Models\ClassroomStudent',
                            'model_id' => $student->id,
                            'status' => AttendanceEnum::ALPHA,
                            'point' => 0,
                            'created_at' => $today,
                            'updated_at' => $today,
                        ]);
                        $studentCount++;
                    }
                }
            }
            $this->info("Processed $studentCount students as Alpha.");
            $this->info("Processed $permissionCount students with approved permissions.");
        }

        if ($teacherRule) {
             $this->info("Processing Teachers...");
             $teachers = Employee::whereHas('user', function($q){
                $q->role('teacher');
             })->get();

             $teacherCount = 0;
             foreach ($teachers as $teacher) {
                 $attendance = Attendance::where('model_type', 'App\Models\Employee')
                    ->where('model_id', $teacher->id)
                    ->whereDate('created_at', $dateString)
                    ->first();

                 if (!$attendance) {
                     Attendance::create([
                        'model_type' => 'App\Models\Employee',
                        'model_id' => $teacher->id,
                        'status' => AttendanceEnum::ALPHA,
                        'point' => 0,
                        'created_at' => $today,
                        'updated_at' => $today,
                    ]);
                    $teacherCount++;
                 }
             }
             $this->info("Processed $teacherCount teachers as Alpha.");
        }

        $this->info('Attendance processing complete.');
        Log::info('attendance:process completed.');
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
