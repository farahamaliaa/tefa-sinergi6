<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\ExtracurricularJournal;
use App\Models\ExtracurricularAttendance;
use App\Models\ExtracurricularSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ExtracurricularApiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $extracurriculars = collect();

        // If user is staff, show all extracurriculars
        if ($user->hasRole('staff')) {
            $extracurriculars = Extracurricular::with('extracurricularStudents')
                ->latest()
                ->get();
        } else {
            $employee = $user->employee;

            if ($employee) {
                $extracurriculars = Extracurricular::where('employee_id', $employee->id)
                    ->with('extracurricularStudents')
                    ->latest()
                    ->get();
            }
        }

        $data = $extracurriculars->map(function ($eskul) {
            return [
                'id' => $eskul->id,
                'name' => $eskul->name,
                'description' => $eskul->description,
                'image' => $eskul->image ? asset('storage/' . $eskul->image) : null,
                'student_count' => $eskul->extracurricularStudents->count(),
            ];
        });

        if ($data->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'User bukan pembina ekstrakurikuler',
                'code' => 200,
                'data' => []
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'code' => 200,
            'data' => $data
        ]);
    }


    public function students($extracurricularId)
    {
        $extracurricular = Extracurricular::with([
            'extracurricularStudents.student.user',
            'extracurricularStudents.student.classroomStudents.classroom'
        ])->find($extracurricularId);

        if (!$extracurricular) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ekstrakurikuler tidak ditemukan',
                'code' => 404
            ], 404);
        }

        $students = $extracurricular->extracurricularStudents->map(function ($es) {
            $student = $es->student;
            $classroom = $student->classroomStudents->first()?->classroom;

            return [
                'id' => $es->id,
                'student_id' => $student->id,
                'name' => $student->user->name ?? '-',
                'email' => $student->user->email ?? '-',
                'nisn' => $student->nisn,
                'nik' => $student->nik,
                'gender' => $student->gender?->label() ?? '-',
                'classroom' => $classroom?->name ?? '-',
                'image' => $student->image ? asset('storage/' . $student->image) : null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'code' => 200,
            'data' => [
                'extracurricular' => [
                    'id' => $extracurricular->id,
                    'name' => $extracurricular->name,
                ],
                'students' => $students
            ]
        ]);
    }

    /**
     * Get schedules of an extracurricular
     */
    public function schedules($extracurricularId)
    {
        $extracurricular = Extracurricular::with('schedules')->find($extracurricularId);

        if (!$extracurricular) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ekstrakurikuler tidak ditemukan',
                'code' => 404
            ], 404);
        }

        $schedules = $extracurricular->schedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'day' => $schedule->day,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'location' => $schedule->location_name ?? $schedule->location, // Handle legacy or column name change
                'latitude' => $schedule->latitude,
                'longitude' => $schedule->longitude,
                'radius' => $schedule->radius, // Include radius
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'code' => 200,
            'data' => [
                'extracurricular' => [
                    'id' => $extracurricular->id,
                    'name' => $extracurricular->name,
                ],
                'schedules' => $schedules
            ]
        ]);
    }

    /**
     * Get journals of an extracurricular
     */
    public function journals($extracurricularId, Request $request)
    {
        $extracurricular = Extracurricular::find($extracurricularId);

        if (!$extracurricular) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ekstrakurikuler tidak ditemukan',
                'code' => 404
            ], 404);
        }

        $journals = ExtracurricularJournal::where('extracurricular_id', $extracurricularId)
            ->when($request->input('month'), function ($query) use ($request) {
                $query->whereMonth('date', $request->input('month'));
            })
            ->when($request->input('year'), function ($query) use ($request) {
                $query->whereYear('date', $request->input('year'));
            })
            ->latest('date')
            ->get()
            ->map(function ($journal) {
                return [
                    'id' => $journal->id,
                    'title' => $journal->title,
                    'description' => $journal->description,
                    'date' => Carbon::parse($journal->date)->translatedFormat('d F'),
                    'year' => Carbon::parse($journal->date)->format('Y'),
                    'date_full' => $journal->date,
                    'location' => $journal->location,
                    'images' => $journal->images ? collect(json_decode($journal->images))->map(fn($img) => asset('storage/' . $img)) : [],
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'code' => 200,
            'data' => [
                'extracurricular' => [
                    'id' => $extracurricular->id,
                    'name' => $extracurricular->name,
                ],
                'journals' => $journals
            ]
        ]);
    }

    /**
     * Get journal detail
     */
    public function journalDetail($journalId)
    {
        $journal = ExtracurricularJournal::with('extracurricular')->find($journalId);

        if (!$journal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jurnal tidak ditemukan',
                'code' => 404
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'code' => 200,
            'data' => [
                'id' => $journal->id,
                'title' => $journal->title,
                'description' => $journal->description,
                'date' => Carbon::parse($journal->date)->translatedFormat('d F Y'),
                'location' => $journal->location,
                'images' => $journal->images ? collect(json_decode($journal->images))->map(fn($img) => asset('storage/' . $img)) : [],
                'extracurricular' => [
                    'id' => $journal->extracurricular->id,
                    'name' => $journal->extracurricular->name,
                ],
            ]
        ]);
    }


    /**
     * Update journal
     */
    public function updateJournal(Request $request, $journalId)
    {
        $journal = ExtracurricularJournal::find($journalId);

        if (!$journal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jurnal tidak ditemukan',
                'code' => 404
            ], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $journal->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Jurnal berhasil diperbarui',
            'code' => 200
        ]);
    }

    /**
     * Get attendance for today's schedule
     */
    public function attendance($extracurricularId, Request $request)
    {
        $extracurricular = Extracurricular::with('extracurricularStudents.student.user')
            ->find($extracurricularId);

        if (!$extracurricular) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ekstrakurikuler tidak ditemukan',
                'code' => 404
            ], 404);
        }

        $date = $request->date ?? Carbon::today()->format('Y-m-d');
        $dayName = Carbon::parse($date)->locale('en')->dayName; // e.g., Monday
        $dayName = strtolower($dayName);

        // Find schedule for this day
        $schedule = ExtracurricularSchedule::where('extracurricular_id', $extracurricularId)
            ->where('day', $dayName)
            ->first();

        // Check if schedule time has passed
        $isTimePassed = false;
        if ($schedule) {
            $scheduleEndTime = Carbon::parse($date . ' ' . $schedule->end_time);
            if (Carbon::now()->greaterThan($scheduleEndTime)) {
                $isTimePassed = true;
            }
        }

        // Find the journal for this extracurricular and date
        $journal = ExtracurricularJournal::where('extracurricular_id', $extracurricularId)
            ->where('date', $date)
            ->first();

        // If time passed and no journal, create one (optional, but needed for attendance)
        if ($isTimePassed && !$journal) {
            $journal = ExtracurricularJournal::create([
                'extracurricular_id' => $extracurricularId,
                'date' => $date,
                'title' => '',
                'description' => '',
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
            ]);
        }

        // Get attendance records for this journal if it exists
        $attendances = collect();
        if ($journal) {
            $attendances = ExtracurricularAttendance::where('extracurricular_journal_id', $journal->id)
                ->get()
                ->keyBy('extracurricular_student_id');
        }

        $students = $extracurricular->extracurricularStudents->map(function ($es) use ($attendances, $isTimePassed, $journal) {
            $attendance = $attendances->get($es->id);
            $status = $attendance?->status ?? null;

            // Auto-assign Alpha if time passed and no status
            if ($status === null && $isTimePassed) {
                // Persist Alpha
                if ($journal) {
                    ExtracurricularAttendance::create([
                        'extracurricular_journal_id' => $journal->id,
                        'extracurricular_student_id' => $es->id,
                        'student_id' => $es->student->id,
                        'status' => 'alpha',
                    ]);
                }
                $status = 'alpha';
            }

            return [
                'id' => $es->id,
                'student_id' => $es->student->id,
                'name' => $es->student->user->name ?? '-',
                'image' => $es->student->image ? asset('storage/' . $es->student->image) : null,
                'status' => $status,
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data',
            'code' => 200,
            'data' => [
                'extracurricular' => [
                    'id' => $extracurricular->id,
                    'name' => $extracurricular->name,
                ],
                'date' => $date,
                'students' => $students
            ]
        ]);
    }

    /**
     * Store journal and attendance
     */
    public function storeJournal(Request $request)
    {
        $request->validate([
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'schedule_id' => 'required|exists:extracurricular_schedules,id',
            'date' => 'required|date',
            'title' => 'required|string|max:255', // Added validation
            'description' => 'required|string',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required',
            'attendance.*.status' => 'required|in:present,permit,sick,alpha',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('journal_images', 'public');
        }

        $dataToUpdate = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ];
        if ($imagePath) {
            $dataToUpdate['image'] = $imagePath;
        }

        // Create or update journal
        $journal = ExtracurricularJournal::updateOrCreate(
            [
                'extracurricular_id' => $request->input('extracurricular_id'),
                'schedule_id' => $request->input('schedule_id'),
                'date' => $request->input('date'),
            ],
            $dataToUpdate
        );

        // Store attendance
        foreach ($request->input('attendance', []) as $att) {
            ExtracurricularAttendance::updateOrCreate(
                [
                    'extracurricular_journal_id' => $journal->id,
                    'extracurricular_student_id' => $att['student_id'],
                ],
                ['status' => $att['status']]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Jurnal berhasil disimpan',
            'code' => 200,
            'data' => $journal
        ]);
    }

    /**
     * Store attendance
     */
    public function storeAttendance(Request $request)
    {
        $request->validate([
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|string|in:present,permit,sick,alpha',
        ]);

        // Find existing journal
        $journal = ExtracurricularJournal::where('extracurricular_id', $request->input('extracurricular_id'))
            ->where('date', $request->input('date'))
            ->first();

        if (!$journal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Silahkan buat jurnal kegiatan terlebih dahulu sebelum mengisi absensi.',
                'code' => 404
            ], 404);
        }

        foreach ($request->input('attendance', []) as $esStudentId => $status) {
            ExtracurricularAttendance::updateOrCreate(
                [
                    'extracurricular_journal_id' => $journal->id,
                    'extracurricular_student_id' => $esStudentId,
                ],
                ['status' => $status]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Absensi berhasil disimpan',
            'code' => 200
        ]);
    }

    /**
     * Store new schedule
     */
    public function storeSchedule(Request $request)
    {
        $request->validate([
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'radius' => 'nullable|numeric', // Add validation
        ]);

        $schedule = ExtracurricularSchedule::create([
            'extracurricular_id' => $request->input('extracurricular_id'),
            'day' => $request->input('day'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'location_name' => $request->input('location'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'radius' => $request->input('radius', 100),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil ditambahkan',
            'code' => 201,
            'data' => ['id' => $schedule->id]
        ], 201);
    }

    /**
     * Delete schedule
     */
    public function deleteSchedule($scheduleId)
    {
        $schedule = ExtracurricularSchedule::find($scheduleId);

        if (!$schedule) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jadwal tidak ditemukan',
                'code' => 404
            ], 404);
        }

        $schedule->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil dihapus',
            'code' => 200
        ]);
    }

    /**
     * Get permissions for students in the extracurricular.
     */
    public function permissions($extracurricularId)
    {
        $extracurricular = Extracurricular::findOrFail($extracurricularId);

        // Get all student IDs enrolled in this extracurricular
        $studentIds = $extracurricular->extracurricularStudents()->pluck('student_id');

        // Get permissions for these students
        $permissions = \App\Models\StudentPermission::whereIn('student_id', $studentIds)
            ->with(['student.user', 'classroom'])
            ->latest()
            ->get()
            ->map(function ($perm) {
                return [
                    'id' => $perm->id,
                    'student_name' => $perm->student->user ? $perm->student->user->name : '-',
                    'class_name' => $perm->classroom ? $perm->classroom->name : '-',
                    'gender' => $perm->student->gender ?? '-',
                    'type' => $perm->permission_type, // sick, permit, etc.
                    'status' => $perm->status, // pending, approved_by, rejected
                    'date' => $perm->date,
                    'duration' => '1 Hari', // Simplification, usually calculated
                    'description' => $perm->proof, // Using proof as description/reason
                    'attachment_url' => $perm->proof_image ? asset('storage/' . $perm->proof_image) : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data perizinan',
            'code' => 200,
            'data' => [
                'permissions' => $permissions
            ]
        ]);
    }

    /**
     * Update permission status
     */
    public function updatePermissionStatus(Request $request, $permissionId)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,rejected,disetujui,ditolak',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'code' => 422
            ], 422);
        }

        $permission = \App\Models\StudentPermission::find($permissionId);

        if (!$permission) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data perizinan tidak ditemukan',
                'code' => 404
            ], 404);
        }

        // Normalize status
        $status = $request->input('status');
        if ($status == 'disetujui')
            $status = 'approved';
        if ($status == 'ditolak')
            $status = 'rejected';

        $permission->status = $status;
        $permission->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status perizinan berhasil diperbarui',
            'data' => $permission,
            'code' => 200
        ]);
    }
}
