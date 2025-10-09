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
        $permission = StudentPermission::with(['student', 'submittedBy', 'approvedBy'])->latest()->get();
        return response()->json($permission);
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
            'proof_image' => 'nullable|image|max:2048',
            'submitted_by' => 'nullable|integer',
            'date' => 'required|date',
        ]);

        if ($request->hasFile('proof_image')) {
            $validated['proof_image'] = $request->file('proof_image')->store('permissions', 'public');
        }

        // $validated['submitted_by'] = auth()->id();
        $validated['submitted_by'] = $request->input('submitted_by', 0);
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
