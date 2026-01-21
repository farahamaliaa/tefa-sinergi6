<?php

namespace App\Http\Controllers\Api;

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
        
        // Filter permissions based on user role
        $query = StudentPermission::with(['student', 'submittedBy', 'approvedBy', 'classroom']);
        
        // If user is a teacher/wali kelas, only show their class permissions
        if ($user->employee) {
            $classroom = $user->employee->classroom;
            if ($classroom) {
                $query->where('classroom_id', $classroom->id);
            }
        }
        // If user is a parent, only show their children's permissions
        elseif ($user->parent) {
            $studentIds = $user->parent->students()->pluck('students.id');
            $query->whereIn('student_id', $studentIds);
        }
        
        $permissions = $query->latest()->get();
        return response()->json($permissions);
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

        // SECURITY: Always use authenticated user's ID to prevent IDOR
        $validated['submitted_by'] = auth()->id();
        $validated['status'] = 'pending';

        $permission = StudentPermission::create($validated);

        return response()->json($permission, 201);
    }

    public function approve($id)
    {
        $permission = StudentPermission::findOrFail($id);
        $permission->update([
            'status' => 'approved_by',
            'approved_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'Permission approved succesfully']);
    }

    public function reject($id)
    {
        $permission = StudentPermission::findOrFail($id);
        $permission->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'Permission rejected succesfully']);
    }    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
