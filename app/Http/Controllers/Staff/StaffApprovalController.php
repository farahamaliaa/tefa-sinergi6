<?php

namespace App\Http\Controllers\Staff;

use App\Enums\AttendanceEnum;
use App\Enums\PermissionTypeEnum;
use App\Enums\StatusPermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\EmployeePermission;
use Illuminate\Http\Request;

class StaffApprovalController extends Controller
{
    public function index()
    {
        $permissions = EmployeePermission::with('employee.user')
            ->latest()
            ->paginate(10);
            
        return view('staff.pages.approval.permission', compact('permissions'));
    }

    public function approve(Request $request, $id)
    {
        $permission = EmployeePermission::findOrFail($id);
        $permission->update([
            'status' => StatusPermissionEnum::APPROVED->value,
            'approved_by' => auth()->id()
        ]);

        $statusMap = [
            PermissionTypeEnum::SICK->value => AttendanceEnum::SICK,
            PermissionTypeEnum::PERMIT->value => AttendanceEnum::PERMIT,
            PermissionTypeEnum::DINAS->value => AttendanceEnum::DINAS,
            PermissionTypeEnum::OTHER->value => AttendanceEnum::PERMIT,
        ];

        $attendanceStatus = $statusMap[$permission->permission_type->value] ?? AttendanceEnum::PERMIT;

        $existingAttendance = Attendance::where('model_id', $permission->employee_id)
            ->where('model_type', 'App\Models\Employee')
            ->whereDate('created_at', $permission->date)
            ->first();

        if (!$existingAttendance) {
            $attendanceData = [
                'model_id' => $permission->employee_id,
                'model_type' => 'App\Models\Employee',
                'status' => $attendanceStatus->value,
                'proof' => $permission->proof,
                'created_at' => $permission->date,
                'updated_at' => now(),
            ];

            if ($permission->permission_type->value === PermissionTypeEnum::DINAS->value) {
                $attendanceData['checkin'] = '08:00:00';
            }

            Attendance::create($attendanceData);
        }

        return redirect()->back()->with('success', 'Izin berhasil disetujui dan absensi tercatat.');
    }

    public function reject(Request $request, $id)
    {
        $permission = EmployeePermission::findOrFail($id);
        $permission->update([
            'status' => StatusPermissionEnum::REJECTED->value,
            'approved_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Izin berhasil ditolak.');
    }
}

