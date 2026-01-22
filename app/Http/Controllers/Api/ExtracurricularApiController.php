<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
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
            return ResponseHelper::error('Unauthorized', 401);
        }

        $extracurriculars = collect();

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
             return ResponseHelper::success([], 'User bukan pembina ekstrakurikuler');
        }

        return ResponseHelper::success($data);
    }


    public function students($extracurricularId)
    {
        $extracurricular = Extracurricular::with([
            'extracurricularStudents.student.user',
            'extracurricularStudents.student.classroomStudents.classroom'
        ])->find($extracurricularId);

        if (!$extracurricular) {
            return ResponseHelper::notFound('Ekstrakurikuler tidak ditemukan');
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
                'location' => $schedule->location,
                'latitude' => $schedule->latitude,
                'longitude' => $schedule->longitude,
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
            ->when($request->month, function ($query) use ($request) {
                $query->whereMonth('date', $request->month);
            })
            ->when($request->year, function ($query) use ($request) {
                $query->whereYear('date', $request->year);
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
            'title' => $request->title,
            'description' => $request->description,
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

        $journal = ExtracurricularJournal::where('extracurricular_id', $extracurricularId)
            ->whereDate('date', $date)
            ->first();

        $attendances = collect();
        if ($journal) {
            $attendances = ExtracurricularAttendance::where('extracurricular_journal_id', $journal->id)
                ->get()
                ->keyBy('extracurricular_student_id');
        }

        $students = $extracurricular->extracurricularStudents->map(function ($es) use ($attendances) {
            $attendance = $attendances->get($es->id);
            return [
                'id' => $es->id,
                'student_id' => $es->student->id,
                'name' => $es->student->user->name ?? '-',
                'image' => $es->student->image ? asset('storage/' . $es->student->image) : null,
                'status' => $attendance?->status ?? null,
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

        $dataToUpdate = ['description' => $request->description];
        if ($imagePath) {
            $dataToUpdate['image'] = $imagePath;
        }

        $journal = ExtracurricularJournal::updateOrCreate(
            [
                'extracurricular_id' => $request->extracurricular_id,
                'schedule_id' => $request->schedule_id,
                'date' => $request->date,
            ],
            $dataToUpdate
        );

        foreach ($request->attendance as $att) {
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

        $journal = ExtracurricularJournal::where('extracurricular_id', $request->extracurricular_id)
            ->whereDate('date', $request->date)
            ->first();

        if (!$journal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Silahkan buat jurnal kegiatan terlebih dahulu sebelum mengisi absensi.',
                'code' => 404
            ], 404);
        }

        foreach ($request->attendance as $esStudentId => $status) {
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
        ]);

        $schedule = ExtracurricularSchedule::create([
            'extracurricular_id' => $request->extracurricular_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
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
        
        $studentIds = $extracurricular->extracurricularStudents()->pluck('student_id');

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
                    'type' => $perm->permission_type,
                    'status' => $perm->status,
                    'date' => $perm->date,
                    'duration' => '1 Hari',
                    'description' => $perm->proof,
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
    public function updatePermissionStatus(\Illuminate\Http\Request $request, $permissionId)
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

        $status = $request->status;
        if ($status == 'disetujui') $status = 'approved';
        if ($status == 'ditolak') $status = 'rejected';

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
