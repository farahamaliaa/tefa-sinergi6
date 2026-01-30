<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\StudentPermission;
use Illuminate\Http\Request;

class StudentPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $query = StudentPermission::with(['student', 'submittedBy', 'approvedBy', 'classroom']);

        if ($user->employee) {
            $classroom = $user->employee->classroom;
            if ($classroom) {
                $query->where('classroom_id', $classroom->id);
            }
        } elseif ($user->parent) {
            $studentIds = $user->parent->students()->pluck('students.id');
            $query->whereIn('student_id', $studentIds);
        }

        $permissions = $query->latest()->get();
        return ResponseHelper::success($permissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'classroom_id' => 'nullable|uuid',
            'permission_type' => 'required|in:sick,permit,other',
            'proof' => 'nullable|string',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'submitted_by' => 'nullable|integer',
            'date' => 'required|date',
        ]);

        if ($request->hasFile('proof_image')) {
            $validated['proof_image'] = $request->file('proof_image')->store('permissions', 'public');
        }

        $validated['submitted_by'] = auth()->id();
        $validated['status'] = 'pending';

        $permission = StudentPermission::create($validated);

        return ResponseHelper::created($permission);
    }

    public function approve($id)
    {
        $user = auth()->user();
        $permission = StudentPermission::findOrFail($id);

        if ($user->employee && $user->employee->classroom) {
            if ($user->employee->classroom->id !== $permission->classroom_id) {
                return ResponseHelper::error('Anda tidak memiliki akses untuk menyetujui izin ini', 403);
            }
        }

        \DB::transaction(function () use ($permission) {
            $permission->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
            ]);

            $activeCS = $permission->student->classroomStudents()
                ->whereHas('classroom.schoolYear', fn($q) => $q->where('active', true))
                ->first();

            if ($activeCS) {
                $statusEnum = $permission->permission_type == 'sick'
                    ? \App\Enums\AttendanceEnum::SICK
                    : \App\Enums\AttendanceEnum::PERMIT;

                $duration = $permission->duration ?? 3;
                $startDate = \Carbon\Carbon::parse($permission->date);

                for ($i = 0; $i < $duration; $i++) {
                    $currentDate = $startDate->copy()->addDays($i);

                    $attendance = \App\Models\Attendance::where('model_type', 'App\Models\ClassroomStudent')
                        ->where('model_id', $activeCS->id)
                        ->whereDate('created_at', $currentDate)
                        ->first();

                    if ($attendance) {
                        $attendance->update(['status' => $statusEnum]);
                    } else {
                        \App\Models\Attendance::create([
                            'model_type' => 'App\Models\ClassroomStudent',
                            'model_id' => $activeCS->id,
                            'status' => $statusEnum,
                            'point' => 10,
                            'created_at' => $currentDate,
                            'proof' => $permission->proof_image,
                        ]);
                    }
                }
            }
        });

        return ResponseHelper::success(null, 'Permission approved successfully');
    }

    public function reject($id)
    {
        $user = auth()->user();
        $permission = StudentPermission::findOrFail($id);

        // Verify user has access to reject this permission
        if ($user->employee && $user->employee->classroom) {
            if ($user->employee->classroom->id !== $permission->classroom_id) {
                return ResponseHelper::error('Anda tidak memiliki akses untuk menolak izin ini', 403);
            }
        }

        $permission->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        return ResponseHelper::success(null, 'Permission rejected successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
