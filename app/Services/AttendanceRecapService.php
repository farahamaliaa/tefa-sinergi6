<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Classroom;
use App\Models\Attendance;
use App\Models\StudentPermission;
use App\Models\ClassroomStudent;
use App\Enums\AttendanceEnum;
use App\Enums\StatusPermissionEnum;
use App\Enums\PermissionTypeEnum;

class AttendanceRecapService
{
    /**
     * Get attendance recap data for a specific classroom on a given date.
     */
    public function getRecapByClassroom(string $classroomId, ?Carbon $date = null): array
    {
        $date = $date ?? Carbon::today();
        
        $classroom = Classroom::with(['levelClass', 'classroomStudents.student.user'])
            ->find($classroomId);
        
        if (!$classroom) {
            return [];
        }

        // Get all students in this classroom
        $classroomStudents = $classroom->classroomStudents;
        
        $hadir = [];
        $tidakHadir = [];

        foreach ($classroomStudents as $cs) {
            $studentName = $cs->student->user->name ?? 'Unknown';
            
            // Get attendance for this student today
            $attendance = Attendance::where('model_type', 'App\Models\ClassroomStudent')
                ->where('model_id', $cs->id)
                ->whereDate('created_at', $date)
                ->first();

            // Get permission for this student today
            $permission = StudentPermission::where('student_id', $cs->student_id)
                ->whereDate('date', $date)
                ->first();

            if ($attendance) {
                $status = $attendance->status;
                $checkinTime = $attendance->checkin 
                    ? Carbon::parse($attendance->checkin)->format('H:i') 
                    : null;

                if (in_array($status, [AttendanceEnum::PRESENT, AttendanceEnum::LATE])) {
                    $hadir[] = [
                        'name' => $studentName,
                        'time' => $checkinTime,
                        'status' => $status->value,
                        'is_late' => $status === AttendanceEnum::LATE,
                    ];
                } else {
                    // ALPHA, SICK, PERMIT
                    $permissionStatus = $permission ? $permission->status : null;
                    $permissionType = $permission ? $permission->permission_type : null;
                    
                    $reason = $this->getReasonLabel($status, $permissionType, $permissionStatus);
                    
                    $tidakHadir[] = [
                        'name' => $studentName,
                        'reason' => $reason,
                        'status' => $status->value,
                        'permission_status' => $permissionStatus,
                    ];
                }
            } else {
                // No attendance record = check if there's a permission
                if ($permission) {
                    $reason = $this->getReasonLabel(null, $permission->permission_type, $permission->status);
                    $tidakHadir[] = [
                        'name' => $studentName,
                        'reason' => $reason,
                        'status' => 'permission',
                        'permission_status' => $permission->status,
                    ];
                } else {
                    // No attendance and no permission = likely hasn't scanned yet
                    $tidakHadir[] = [
                        'name' => $studentName,
                        'reason' => 'Belum Absen',
                        'status' => 'unknown',
                        'permission_status' => null,
                    ];
                }
            }
        }

        // Sort hadir by time
        usort($hadir, fn($a, $b) => strcmp($a['time'] ?? '', $b['time'] ?? ''));

        return [
            'classroom' => $classroom,
            'date' => $date,
            'hadir' => $hadir,
            'tidak_hadir' => $tidakHadir,
            'total_students' => count($classroomStudents),
            'total_hadir' => count($hadir),
            'total_tidak_hadir' => count($tidakHadir),
        ];
    }

    /**
     * Get human readable reason label.
     */
    private function getReasonLabel(?AttendanceEnum $attendanceStatus, ?string $permissionType, ?string $permissionStatus): string
    {
        if ($attendanceStatus === AttendanceEnum::ALPHA) {
            return 'Alpha';
        }
        
        if ($attendanceStatus === AttendanceEnum::SICK || $permissionType === PermissionTypeEnum::SICK->value) {
            $statusLabel = $this->getPermissionStatusLabel($permissionStatus);
            return "Sakit" . ($statusLabel ? " ($statusLabel)" : "");
        }
        
        if ($attendanceStatus === AttendanceEnum::PERMIT || $permissionType === PermissionTypeEnum::PERMIT->value) {
            $statusLabel = $this->getPermissionStatusLabel($permissionStatus);
            return "Izin" . ($statusLabel ? " ($statusLabel)" : "");
        }
        
        if ($permissionType === PermissionTypeEnum::OTHER->value) {
            $statusLabel = $this->getPermissionStatusLabel($permissionStatus);
            return "Lainnya" . ($statusLabel ? " ($statusLabel)" : "");
        }

        return 'Alpha';
    }

    /**
     * Get permission status label in Indonesian.
     */
    private function getPermissionStatusLabel(?string $status): string
    {
        return match($status) {
            StatusPermissionEnum::APPROVED->value => 'Approved',
            StatusPermissionEnum::PENDING->value => 'Pending',
            StatusPermissionEnum::REJECTED->value => 'Rejected',
            default => '',
        };
    }

    /**
     * Format the recap data as a WhatsApp message.
     */
    public function formatWhatsAppMessage(array $recap): string
    {
        $classroom = $recap['classroom'];
        $date = $recap['date'];
        
        $classroomName = $classroom->name ?? 'Unknown';
        $dateFormatted = $date->translatedFormat('j F Y');

        $message = "📋 *Rekap Kehadiran*\n";
        $message .= "🏫 Kelas: {$classroomName}\n";
        $message .= "🗓️ {$dateFormatted}\n\n";

        // Hadir section
        $message .= "✅ *Hadir ({$recap['total_hadir']}):*\n";
        if (empty($recap['hadir'])) {
            $message .= "- (Belum ada)\n";
        } else {
            foreach ($recap['hadir'] as $student) {
                $lateTag = $student['is_late'] ? ' ⚠️' : '';
                $time = $student['time'] ?? '-';
                $message .= "- {$student['name']} — {$time}{$lateTag}\n";
            }
        }

        $message .= "\n❌ *Tidak Hadir ({$recap['total_tidak_hadir']}):*\n";
        if (empty($recap['tidak_hadir'])) {
            $message .= "- (Semua hadir)\n";
        } else {
            foreach ($recap['tidak_hadir'] as $student) {
                $message .= "- {$student['name']} — {$student['reason']}\n";
            }
        }

        return $message;
    }
}
