<?php

namespace App\Http\Controllers\Api;

use App\Models\Parents;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\LessonSchedule;
use App\Models\StudentPermission;
use App\Models\User;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Imports\ParentImport;
use App\Exports\ParentTemplateExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ParentController extends Controller
{
    public function index(Request $request)
    {
        $query = Parents::with(['user', 'students.user', 'students.classroomStudents.classroom']);

        if ($request->filled('name')) {
            $search = $request->name;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class')) {
            $classParam = $request->class;
            $query->whereHas('students.classroomStudents.classroom', function($q) use ($classParam) {
                $q->where('name', 'like', "%{$classParam}%");
            });
        }

        $parents = $query->get();

        if (!$request->expectsJson()) {
            $students = \App\Models\Student::with(['user', 'classroomStudents.classroom'])
                ->get()
                ->map(function($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->user->name ?? $s->name ?? 'Unknown',
                        'classroom' => $s->classroomStudents->first()?->classroom?->name ?? 'No Class'
                    ];
                });
            return view('school.pages.parent.index', compact('parents', 'students'));
        };

        return $parents;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required|string|max:20',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
        ]);

        $slug = \Illuminate\Support\Str::slug($request->name);
        $count = User::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $user = User::create([
            'name' => $request->name,
            'slug' => $slug,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'parent',
            'gender' => $request->gender,
        ]);

        $user->assignRole('parent'); 

        $parent = Parents::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ]);

        if($request->has('students')) {
            $parent->students()->attach($request->students);
        }

        if ($request->expectsJson()) {
             return ResponseHelper::created($parent, 'Berhasil menambahkan data orang tua');
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan data orang tua');
    }

    public function show($id, Request $request)
    {
        $parent = Parents::with('students')->findOrFail($id);

        if ($request->expectsJson()) {
            return ResponseHelper::success($parent);
        };

        return view('school.pages.parent.show', compact('parent'));
    }

    public function attachStudent(Request $request, $id)
    {
        $parent = Parents::findOrFail($id);

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $parent->students()->syncWithoutDetaching([$validated['student_id']]);

        return ResponseHelper::success([
            'message' => 'Student linked to parent successfully',
            'data' => $parent->load('students'),
        ]);
    }

    public function detachStudent($id, $studentId)
    {
        $parent = Parents::findOrFail($id);
        $parent->students()->detach($studentId);

        return ResponseHelper::success(null, 'Student Unliked from parent successfully');
    }

    public function getChildren(User $user)
    {
        $parent = Parents::where('user_id', $user->id)->firstOrFail();
        
        $children = $parent->students()->with([
            'user', 
            'classroomStudents.classroom.levelClass', 
            'classroomStudents.classroom.employee.user'
        ])->get();
        
        $childrenData = $children->map(function ($student) {
            $currentClassroom = $student->classroomStudents->first();
            $homeroomTeacher = $currentClassroom?->classroom?->employee;
            
            return [
                'id' => $student->id,
                'name' => $student->user->name ?? $student->name,   
                'nis' => $student->nis ?? null,
                'nisn' => $student->nisn ?? null,
                'gender' => $student->gender,
                'classroom' => $currentClassroom ? [
                    'id' => $currentClassroom->classroom->id,
                    'name' => $currentClassroom->classroom->name,
                    'level' => $currentClassroom->classroom->levelClass->name ?? null,
                    'homeroom_teacher' => $homeroomTeacher?->user?->name ?? $homeroomTeacher?->name ?? null,
                    'homeroom_teacher_id' => $homeroomTeacher?->id ?? null,
                ] : null,
            ];
        });
        
        return ResponseHelper::success($childrenData);
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
            ->with(['teacherSubject.subject', 'teacherSubject.employee.user', 'start', 'end'])
            ->orderBy('day')
            ->orderBy('lesson_hour_start')
            ->get();
        
        $daysMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $schedulesByDay = $lessonSchedules->groupBy('day')->map(function ($daySchedules, $dayKey) use ($daysMap) {
            return $daySchedules->map(function ($schedule) {
                $employee = $schedule->teacherSubject->employee;
                
                $startHour = $schedule->start ? $this->extractHourNumber($schedule->start->name) : $schedule->lesson_hour_start;
                $endHour = $schedule->end ? $this->extractHourNumber($schedule->end->name) : $schedule->lesson_hour_end;
                
                return [
                    'id' => $schedule->id,
                    'day' => $schedule->day,
                    'day_name' => $daysMap[$schedule->day] ?? $schedule->day,
                    'lesson_hour_start' => $startHour,
                    'lesson_hour_end' => $endHour,
                    'time' => ($schedule->start && $schedule->end) 
                        ? \Carbon\Carbon::parse($schedule->start->start)->format('H:i') . ' - ' . \Carbon\Carbon::parse($schedule->end->end)->format('H:i')
                        : null,
                    'subject' => [
                        'id' => $schedule->teacherSubject->subject->id ?? null,
                        'name' => $schedule->teacherSubject->subject->name ?? null,
                    ],
                    'teacher' => [
                        'id' => $employee->id ?? null,
                        'name' => $employee->user->name ?? $employee->name ?? null,
                    ],
                ];
            });
        });
        
        return ResponseHelper::success([
            'student' => [
                'id' => $student->id,
                'name' => $student->user->name ?? $student->name,
            ],
            'classroom' => [
                'id' => $classroom->id,
                'name' => $classroom->name,
            ],
            'schedules' => $schedulesByDay,
        ]);
    }

    public function createPermission(Request $request, User $user)
    {
        $parent = Parents::where('user_id', $user->id)->firstOrFail();
        
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'permission_type' => 'required|in:sick,permit,other',
            'proof' => 'nullable|string',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'date' => 'required|date',
        ]);
        
        $isMyChild = $parent->students()->where('students.id', $validated['student_id'])->exists();
        
        if (!$isMyChild) {
            return ResponseHelper::error('Anda tidak memiliki akses untuk mengajukan izin untuk siswa ini', 403);
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
        
        return ResponseHelper::created(
            $permission->load(['student', 'submittedBy']),
            'Permohonan izin berhasil diajukan dan menunggu persetujuan wali kelas'
        );
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
        
        return ResponseHelper::success($permissions);
    }

    /**
     * Get parent dashboard data for mobile app
     */
    public function dashboard(User $user)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $parent = Parents::where('user_id', $user->id)->first();
        
        if (!$parent) {
            return ResponseHelper::notFound('Data orang tua tidak ditemukan');
        }

        $children = $parent->students()->with(['user', 'classroomStudents.classroom'])->get();
        $childrenCount = $children->count();
        
        $studentIds = $children->pluck('id');
        $pendingPermissions = StudentPermission::whereIn('student_id', $studentIds)
            ->where('status', 'pending')
            ->count();

        return ResponseHelper::success([
            'parent_name' => $user->name,
            'children_count' => $childrenCount,
            'pending_permissions' => $pendingPermissions,
            'children_summary' => $children->map(function ($child) {
                $classroom = $child->classroomStudents->first()?->classroom;
                return [
                    'id' => $child->id,
                    'name' => $child->user->name ?? $child->name ?? null,
                    'classroom' => $classroom?->name,
                ];
            }),
        ]);
    }

    /**
     * Get parent profile for mobile app
     */
    public function profile(User $user)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $parent = Parents::where('user_id', $user->id)->first();
        $fullDomain = request()->root();

        return ResponseHelper::success([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $parent?->phone ?? null,
            'address' => $parent?->address ?? null,
            'image' => $user->image 
                ? asset($fullDomain . '/storage/' . $user->image) 
                : asset($fullDomain . '/public/admin_assets/dist/images/profile/user-1.jpg'),
        ]);
    }

    /**
     * Get detailed child information
     */
    public function childDetail(User $user, Student $student)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $parent = Parents::where('user_id', $user->id)->firstOrFail();
        $isMyChild = $parent->students()->where('students.id', $student->id)->exists();
        
        if (!$isMyChild) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke data siswa ini',
            ], 403);
        }

        $student->load(['user', 'religion', 'classroomStudents.classroom']);
        $classroomStudent = $student->classroomStudents->first();
        $fullDomain = request()->root();

        return ResponseHelper::success([
            'id' => $student->id,
            'user_id' => $student->user_id,
            'name' => optional($student->user)->name,
            'email' => optional($student->user)->email,
            'nisn' => $student->nisn,
            'nik' => $student->nik,
            'image' => $student->image 
                ? asset($fullDomain . '/storage/' . $student->image) 
                : null,
            'gender' => $student->gender?->value,
            'gender_label' => $student->gender ? $student->gender->label() : null,
            'religion_id' => $student->religion_id,
            'religion_name' => optional($student->religion)->name,
            'birth_date' => $student->birth_date,
            'birth_place' => $student->birth_place,
            'address' => $student->address,
            'point' => $student->point ?? 0,
            'classroom' => $classroomStudent ? [
                'id' => $classroomStudent->classroom->id,
                'name' => $classroomStudent->classroom->name,
            ] : null,
        ]);
    }

    /**
     * Get child attendance history
     */
    public function childAttendance(User $user, Student $student)
    {
        if ($user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $parent = Parents::where('user_id', $user->id)->firstOrFail();
        $isMyChild = $parent->students()->where('students.id', $student->id)->exists();
        
        if (!$isMyChild) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke data siswa ini',
            ], 403);
        }

        $classroomStudent = $student->classroomStudents()->first();
        
        if (!$classroomStudent) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa belum terdaftar di kelas manapun',
            ], 404);
        }

        $attendances = $classroomStudent->attendances()
            ->orderBy('created_at', 'desc')
            ->take(30)
            ->get()
            ->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'date' => $attendance->created_at->format('Y-m-d'),
                    'check_in' => $attendance->check_in,
                    'check_out' => $attendance->check_out,
                    'status' => $attendance->status,
                    'status_label' => match($attendance->status) {
                        'present' => 'Hadir',
                        'late' => 'Terlambat',
                        'absent' => 'Tidak Hadir',
                        'sick' => 'Sakit',
                        'permit' => 'Izin',
                        default => $attendance->status,
                    },
                ];
            });

        return ResponseHelper::success([
            'student' => [
                'id' => $student->id,
                'name' => $student->user->name ?? $student->name,
            ],
            'attendances' => $attendances,
        ]);
    }

    private function extractHourNumber($name)
    {
        if (!$name) {
            return '';
        }
        
        if (preg_match('/(\d+)/', $name, $matches)) {
            return $matches[1];
        }
        
        return $name;
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new ParentImport, $request->file('file'));
            
            if ($request->expectsJson()) {
                return ResponseHelper::success(null, 'Berhasil mengimport data orang tua');
            }

            return redirect()->back()->with('success', 'Berhasil mengimport data orang tua');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return ResponseHelper::error('Gagal mengimport data: ' . $e->getMessage(), 500);
            }

            return redirect()->back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new ParentTemplateExport, 'template-import-orang-tua.xlsx');
    }
}

