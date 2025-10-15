<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Parents;

class ParentController extends Controller
{
    public function index()
    {
        // ambil semua parent + relasi student
        $parents = Parents::with('students')->get();

        return view('school.pages.parent.index', compact('parents'));
    }

    public function show($id)
    {
        $parent = Parents::with('students')->findOrFail($id);
        return view('school.pages.parent.show', compact('parent'));
    }

    public function attachStudent(Request $request, $parentId)
    {
        $request->validate(['student_id' => 'required|integer|exists:students,id']);

        $parent = Parents::findOrFail($parentId);
        $parent->students()->attach($request->student_id);

        return redirect()->back()->with('success', 'Student berhasil ditambahkan ke parent');
    }

    public function detachStudent($parentId, $studentId)
    {
        $parent = Parents::findOrFail($parentId);
        $parent->students()->detach($studentId);

        return redirect()->back()->with('success', 'Student berhasil dihapus dari parent');
    }
}
