<?php

namespace App\Http\Controllers\Api;

use App\Models\Parents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    //Get /api/parents
    public function index(Request $request)
    {
        if (!$request->expectsJson()) {
            return view('school.pages.parent.index');
        };

        return Parents::with('students')->get();
    }

    //Get /api/parents{id}
    public function show($id, Request $request)
    {
        $parent = Parents::with('students')->findOrFail($id);

        if ($request->expectsJson()) {
            return response()->json($parent);
        };

        return view('school.pages.parent.show', compact('parent'));
    }

    //post /api/parents{id}/students
    public function attachStudent(Request $request, $id)
    {
        $parent = Parents::findOrFail($id);

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $parent->students()->syncWithoutDetaching([$validated['student_id']]);

        return response()->json([
            'message' => 'Student linked to parent successfully',
            'data' => $parent->load('students'),
        ]);
    }

    public function detachStudent($id, $studentId)
    {
        $parent = Parents::findOrFail($id);
        $parent->students()->detach($studentId);

        return response()->json([
            'message' => 'Student Unliked from parent succesfully',
        ]);
    }
}
