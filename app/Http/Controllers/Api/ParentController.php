<?php

namespace App\Http\Controllers\Api;

use App\Models\Parents;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\LessonSchedule;
use App\Models\StudentPermission;
use App\Models\User;
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

    public function getChildren(User $user)
    {
        $parent = Parents::where('user_id', $user->id)->firstOrFail();
        
        $children = $parent->students()->with(['classroomStudents.classroom.levelClass', 'classroomStudents.classroom.employee'])->get();
        
        $childrenData = $children->map(function ($student) {
            $currentClassroom = $student->classroomStudents->first();
            
            return [
                'id' => $student->id,
                'name' => $student->name,
                'nis' => $student->nis ?? null,
                'nisn' => $student->nisn ?? null,
                'gender' => $student->gender,
                'classroom' => $currentClassroom ? [
                    'id' => $currentClassroom->classroom->id,
                    'name' => $currentClassroom->classroom->name,
                    'level' => $currentClassroom->classroom->levelClass->name ?? null,
                    'homeroom_teacher' => $currentClassroom->classroom->employee->name ?? null,
                    'homeroom_teacher_id' => $currentClassroom->classroom->employee_id ?? null,
                ] : null,
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $childrenData,
        ]);
    }

    public function getChildLessons(User $user, Student $student)
    {
        $parent = Parents::where('user_id', $user->id)->firstOrFail();
        $isMyChild = $parent->students()->where('students.id', $student->id)->exists();
        
        if (!$isMyChild) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke data siswa ini',
            ], 403);
        }
        
        $classroomStudent = $student->classroomStudents()->with('classroom')->first();
        
        if (!$classroomStudent) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa belum terdaftar di kelas manapun',
            ], 404);
        }
        
        $classroom = $classroomStudent->classroom;
        
        $lessonSchedules = LessonSchedule::where('classroom_id', $classroom->id)
            ->with(['teacherSubject.subject', 'teacherSubject.employee'])
            ->orderBy('day')
            ->orderBy('lesson_hour_start')
            ->get();
        
        $schedulesByDay = $lessonSchedules->groupBy('day')->map(function ($daySchedules) {
            return $daySchedules->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'day' => $schedule->day,
                    'lesson_hour_start' => $schedule->lesson_hour_start,
                    'lesson_hour_end' => $schedule->lesson_hour_end,
                    'subject' => [
                        'id' => $schedule->teacherSubject->subject->id ?? null,
                        'name' => $schedule->teacherSubject->subject->name ?? null,
                    ],
                    'teacher' => [
                        'id' => $schedule->teacherSubject->employee->id ?? null,
                        'name' => $schedule->teacherSubject->employee->name ?? null,
                    ],
                ];
            });
        });
        
        return response()->json([
            'success' => true,
            'data' => [
                'student' => [
                    'id' => $student->id,
                    'name' => $student->name,
                ],
                'classroom' => [
                    'id' => $classroom->id,
                    'name' => $classroom->name,
                ],
                'schedules' => $schedulesByDay,
            ],
        ]);
    }

    public function createPermission(Request $request, User $user)
    {
        $parent = Parents::where('user_id', $user->id)->firstOrFail();
        
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'permission_type' => 'required|in:sick,permit,other',
            'proof' => 'nullable|string',
            'proof_image' => 'nullable|image|max:2048',
            'date' => 'required|date',
        ]);
        
        $isMyChild = $parent->students()->where('students.id', $validated['student_id'])->exists();
        
        if (!$isMyChild) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengajukan izin untuk siswa ini',
            ], 403);
        }
        
        $student = Student::find($validated['student_id']);
        
        $classroomStudent = $student->classroomStudents()->first();
        
        if (!$classroomStudent) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa belum terdaftar di kelas manapun',
            ], 404);
        }
        
        $proofImage = null;
        if ($request->hasFile('proof_image')) {
            $proofImage = $request->file('proof_image')->store('permissions', 'public');
        }
        
        $permission = StudentPermission::create([
            'student_id' => $validated['student_id'],
            'classroom_id' => $classroomStudent->classroom_id,
            'permission_type' => $validated['permission_type'],
            'proof' => $validated['proof'] ?? null,
            'proof_image' => $proofImage,
            'submitted_by' => $user->id,
            'status' => 'pending',
            'date' => $validated['date'],
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Permohonan izin berhasil diajukan dan menunggu persetujuan wali kelas',
            'data' => $permission->load(['student', 'submittedBy']),
        ], 201);
    }

    public function getPermissionHistory(User $user)
    {
        $parent = Parents::where('user_id', $user->id)->firstOrFail();
        
        $studentIds = $parent->students()->pluck('students.id');
        
        $permissions = StudentPermission::whereIn('student_id', $studentIds)
            ->with(['student', 'classroom', 'submittedBy', 'approvedBy'])
            ->latest()
            ->get()
            ->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'student' => [
                        'id' => $permission->student->id,
                        'name' => $permission->student->name,
                    ],
                    'classroom' => $permission->classroom ? [
                        'id' => $permission->classroom->id,
                        'name' => $permission->classroom->name,
                    ] : null,
                    'permission_type' => $permission->permission_type,
                    'permission_type_label' => match($permission->permission_type) {
                        'sick' => 'Sakit',
                        'permit' => 'Izin',
                        'other' => 'Lainnya',
                        default => $permission->permission_type,
                    },
                    'proof' => $permission->proof,
                    'status' => $permission->status,
                    'status_label' => match($permission->status) {
                        'pending' => 'Menunggu Persetujuan',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => $permission->status,
                    },
                    'date' => $permission->date,
                    'submitted_at' => $permission->created_at,
                    'approved_by' => $permission->approvedBy ? $permission->approvedBy->name : null,
                ];
            });
        
        return response()->json([
            'success' => true,
            'data' => $permissions,
        ]);
    }
}
