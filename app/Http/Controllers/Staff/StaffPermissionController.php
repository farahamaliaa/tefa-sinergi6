<?php

namespace App\Http\Controllers\Staff;

use App\Enums\PermissionTypeEnum;
use App\Enums\StatusPermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\EmployeePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffPermissionController extends Controller
{
    public function index()
    {
        $permissions = EmployeePermission::where('employee_id', auth()->user()->employee->id)
            ->latest()
            ->paginate(10);
            
        return view('staff.pages.permission.index', compact('permissions'));
    }

    public function create()
    {
        return view('staff.pages.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'permission_type' => 'required',
            'date' => 'required|date',
            'duration' => 'required|string',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'proof' => 'required|string',
        ]);

        $data = $request->all();
        $data['employee_id'] = auth()->user()->employee->id;
        $data['status'] = StatusPermissionEnum::PENDING->value;

        if ($request->hasFile('proof_image')) {
            $data['proof_image'] = $request->file('proof_image')->store('employee-permissions', 'public');
        }

        EmployeePermission::create($data);

        return redirect()->route('employee.permission.index')->with('success', 'Berhasil mengajukan izin.');
    }

    public function destroy($id)
    {
        $permission = EmployeePermission::findOrFail($id);
        
        if ($permission->employee_id != auth()->user()->employee->id) {
            abort(403);
        }

        if ($permission->status != StatusPermissionEnum::PENDING->value) {
            return redirect()->back()->with('error', 'Izin yang sudah diproses tidak dapat dihapus.');
        }

        if ($permission->proof_image) {
            Storage::disk('public')->delete($permission->proof_image);
        }

        $permission->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus pengajuan izin.');
    }
}
