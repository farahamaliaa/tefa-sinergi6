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

        // Both staff and teacher should only see extracurriculars where they are the pembina
        $employee = $user->employee;

        if ($employee) {
            $extracurriculars = Extracurricular::where('employee_id', $employee->id)
                ->with('extracurricularStudents')
                ->latest()
                ->get();
        } else {
            // Fallback: Try to find employee by user_id manually if relation not loaded
            $manualEmployee = \App\Models\Employee::where('user_id', $user->id)->first();
            if ($manualEmployee) {
                $extracurriculars = Extracurricular::where('employee_id', $manualEmployee->id)
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

        return ResponseHelper::success([
            'extracurricular' => [
                'id' => $extracurricular->id,
                'name' => $extracurricular->name,
            ],
            'students' => $students
        ]);
    }

    /**
     * Get schedules of an extracurricular
     */
    public function schedules($extracurricularId)
    {
        $extracurricular = Extracurricular::with('schedules')->find($extracurricularId);

        if (!$extracurricular) {
            return ResponseHelper::notFound('Ekstrakurikuler tidak ditemukan');
        }

        $schedules = $extracurricular->schedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'day' => $schedule->day,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'location' => $schedule->location_name ?? $schedule->location,
                'latitude' => $schedule->latitude,
                'longitude' => $schedule->longitude,
                'radius' => $schedule->radius,
            ];
        });

        return ResponseHelper::success([
            'extracurricular' => [
                'id' => $extracurricular->id,
                'name' => $extracurricular->name,
            ],
            'schedules' => $schedules
        ]);
    }

    /**
     * Get journals of an extracurricular
     */
    public function journals($extracurricularId, Request $request)
    {
        $extracurricular = Extracurricular::find($extracurricularId);

        if (!$extracurricular) {
            return ResponseHelper::notFound('Ekstrakurikuler tidak ditemukan');
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

        return ResponseHelper::success([
            'extracurricular' => [
                'id' => $extracurricular->id,
                'name' => $extracurricular->name,
            ],
            'journals' => $journals
        ]);
    }

    /**
     * Get journal detail
     */
    public function journalDetail($journalId)
    {
        $journal = ExtracurricularJournal::with('extracurricular')->find($journalId);

        if (!$journal) {
            return ResponseHelper::notFound('Jurnal tidak ditemukan');
        }

        return ResponseHelper::success([
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
        ]);
    }


    /**
     * Update journal
     */
    public function updateJournal(Request $request, $journalId)
    {
        $journal = ExtracurricularJournal::find($journalId);

        if (!$journal) {
            return ResponseHelper::notFound('Jurnal tidak ditemukan');
        }

        $user = auth()->user();
        $employee = $user->employee ?? \App\Models\Employee::where('user_id', $user->id)->first();
        $extracurricular = $journal->extracurricular;

        if (!$employee || $extracurricular->employee_id !== $employee->id) {
            return ResponseHelper::unauthorized();
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $journal->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return ResponseHelper::success(null, 'Jurnal berhasil diperbarui');
    }

    /**
     * Get attendance for today's schedule
     */
    public function attendance($extracurricularId, Request $request)
    {
        $extracurricular = Extracurricular::with('extracurricularStudents.student.user')
            ->find($extracurricularId);

        if (!$extracurricular) {
            return ResponseHelper::notFound('Ekstrakurikuler tidak ditemukan');
        }

        $date = $request->date ?? Carbon::today()->format('Y-m-d');
        $dateCarbon = Carbon::parse($date);
        $dayName = strtolower($dateCarbon->format('l'));

        $schedule = ExtracurricularSchedule::where('extracurricular_id', $extracurricularId)
            ->where('day', $dayName)
            ->first();

        $isTimePassed = false;
        if ($schedule) {
            if ($dateCarbon->isPast() && !$dateCarbon->isToday()) {
                $isTimePassed = true;
            } elseif ($dateCarbon->isToday()) {
                // Parse end_time to Carbon today
                $endTime = Carbon::parse($schedule->end_time);
                if (Carbon::now()->gt($endTime)) {
                    $isTimePassed = true;
                }
            }
        }

        $journal = ExtracurricularJournal::where('extracurricular_id', $extracurricularId)
            ->where('date', $date)
            ->first();

        // LOGIC REMOVED: No auto-create journal if time passed
        // LOGIC REMOVED: No auto-create alpha if time passed

        $attendances = collect();
        if ($journal) {
            $attendances = ExtracurricularAttendance::where('extracurricular_journal_id', $journal->id)
                ->get()
                ->keyBy('extracurricular_student_id');
        }

        $students = $extracurricular->extracurricularStudents->map(function ($es) use ($attendances) {
            $attendance = $attendances->get($es->id);
            $status = $attendance?->status ?? null;

            // LOGIC REMOVED: No auto-create alpha if journal exists

            return [
                'id' => $es->id,
                'student_id' => $es->student->id,
                'name' => $es->student->user->name ?? '-',
                'image' => $es->student->image ? asset('storage/' . $es->student->image) : null,
                'status' => $status,
            ];
        });

        return ResponseHelper::success([
            'extracurricular' => [
                'id' => $extracurricular->id,
                'name' => $extracurricular->name,
            ],
            'date' => $date,
            'students' => $students
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
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

        $journal = ExtracurricularJournal::updateOrCreate(
            [
                'extracurricular_id' => $request->input('extracurricular_id'),
                'schedule_id' => $request->input('schedule_id'),
                'date' => $request->input('date'),
            ],
            $dataToUpdate
        );

        return ResponseHelper::success($journal, 'Jurnal berhasil disimpan');
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
            ->where('date', $request->date)
            ->first();

        if (!$journal) {
            // Allow storing attendance even if journal doesn't exist yet
            // return ResponseHelper::notFound('Silahkan buat jurnal kegiatan terlebih dahulu sebelum mengisi absensi.');
        }

        foreach ($request->input('attendance', []) as $esStudentId => $status) {
            // Find specific attendance record by date and student
            $attRecord = ExtracurricularAttendance::where('extracurricular_student_id', $esStudentId)
                ->where('date', $request->date)
                ->first();

            if ($attRecord) {
                // Update existing
                $attRecord->update([
                    'status' => $status,
                    'extracurricular_journal_id' => $journal?->id // Update link if journal now exists
                ]);
            } else {
                // Create new standalone
                ExtracurricularAttendance::create([
                    'extracurricular_student_id' => $esStudentId,
                    'extracurricular_journal_id' => $journal?->id, // Can be null
                    'status' => $status,
                    'date' => $request->date
                ]);
            }
        }

        return ResponseHelper::success(null, 'Absensi berhasil disimpan');
    }

    /**
     * Store new schedule
     */
    public function storeSchedule(Request $request)
    {
        $user = auth()->user();
        $employee = $user->employee ?? \App\Models\Employee::where('user_id', $user->id)->first();
        $extracurricular = Extracurricular::find($request->input('extracurricular_id'));

        if (!$employee || !$extracurricular || $extracurricular->employee_id !== $employee->id) {
            return ResponseHelper::unauthorized();
        }

        $request->validate([
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'radius' => 'nullable|numeric',
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

        return ResponseHelper::created(['id' => $schedule->id], 'Jadwal berhasil ditambahkan');
    }

    /**
     * Delete schedule
     */
    public function deleteSchedule($scheduleId)
    {
        $schedule = ExtracurricularSchedule::find($scheduleId);

        if (!$schedule) {
            return ResponseHelper::notFound('Jadwal tidak ditemukan');
        }

        $schedule->delete();

        return ResponseHelper::success(null, 'Jadwal berhasil dihapus');
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

        return ResponseHelper::success(['permissions' => $permissions], 'Berhasil mengambil data perizinan');
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
            return ResponseHelper::validationError($validator->errors()->first());
        }

        $permission = \App\Models\StudentPermission::find($permissionId);

        if (!$permission) {
            return ResponseHelper::notFound('Data perizinan tidak ditemukan');
        }

        $status = $request->status;
        if ($status == 'disetujui')
            $status = 'approved';
        if ($status == 'ditolak')
            $status = 'rejected';

        $permission->status = $status;
        $permission->save();

        return ResponseHelper::success($permission, 'Status perizinan berhasil diperbarui');
    }
}
