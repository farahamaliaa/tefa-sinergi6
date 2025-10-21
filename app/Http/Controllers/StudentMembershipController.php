<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Extracurricular;
use App\Models\StudentMembership;

class StudentMembershipController extends Controller
{

  public function index(Request $request)
  {
    $query = StudentMembership::query();

    // filter by student_id (opsional)
    if ($request->has('student_id')) {
      $query->where('student_id', $request->student_id);
    }

    // filter by type (opsional)
    if ($request->has('type')) {
      $query->where('memberable_type', $request->type);
    }

    $memberships = $query->get();
    return response()->json($memberships);
    }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'student_id' => 'required|exists:students,id',
      'memberable_id' => 'required',
      'memberable_type' => 'required|in:classroom,extracurricular',
    ]);

    $modelType = match ($request->memberable_type) {
      'classroom' => Classroom::class,
      'extracurricular' => Extracurricular::class,
    };

    $membership = StudentMembership::create([
      'student_id' => $request->student_id,
      'memberable_id' => $request->memberable_id,
      'memberable_type' => $modelType,
    ]);

    // return back()->with('success', 'Keanggotaan siswa berhasil ditambahkan.');
    return response()->json([
      'message' => 'Membership created successfully',
      'data' => $membership,
    ], 201);
  }
}
