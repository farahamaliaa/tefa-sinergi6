<?php

namespace App\Http\Controllers\Staff;

use App\Enums\StatusPermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\EmployeePermission;
use Illuminate\Http\Request;

class StaffApprovalController extends Controller
{
    public function index()
    {
        // Only show permissions from other employees (not self, if ever needed)
        // or just all permissions
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

        return redirect()->back()->with('success', 'Izin berhasil disetujui.');
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
