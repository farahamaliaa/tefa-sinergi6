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

        if ($user->hasRole('school')) {
            $extracurriculars = Extracurricular::with('extracurricularStudents')
                ->latest()
                ->get();
        } elseif ($user->hasRole('student')) {
            $student = $user->student;
            if ($student) {
                $extracurriculars = Extracurricular::whereHas('extracurricularStudents', function ($query) use ($student) {
                    $query->where('student_id', $student->id);
                })
                    ->with('extracurricularStudents')
                    ->latest()
                    ->get();
            }
        } else {
            $employee = $user->employee;

            if ($employee) {
                $extracurriculars = Extracurricular::where('employee_id', $employee->id)
                    ->with('extracurricularStudents')
                    ->latest()
                    ->get();
            } else {
                $manualEmployee = \App\Models\Employee::where('user_id', $user->id)->first();
                if ($manualEmployee) {
                    $extracurriculars = Extracurricular::where('employee_id', $manualEmployee->id)
                        ->with('extracurricularStudents')
                        ->latest()
                        ->get();
                }
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
            $classroom = $student->classroomStudents()
                ->whereHas('classroom.schoolYear', function ($q) {
                    $q->where('active', true);
                })
                ->first()?->classroom;

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
        $extracurricular = Extracurricular::with('schedules')->find($extracurricularId);

        if (!$extracurricular) {
            return ResponseHelper::notFound('Ekstrakurikuler tidak ditemukan');
        }

        $allHistory = collect();
        $schedules = $extracurricular->schedules;

        if ($request->input('month') && $request->input('year')) {
            $month = $request->input('month');
            $year = $request->input('year');
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endDate = clone $startDate;
            $endDate->endOfMonth();

            // Don't scan future dates
            if ($endDate->isAfter(now())) {
                $endDate = now();
            }
        } else {
            $startDate = now()->subDays(30)->startOfDay();
            $endDate = now();
        }

        // 1. Get real journals
        $realJournals = ExtracurricularJournal::where('extracurricular_id', $extracurricularId)
            ->with(['schedule', 'attendances'])
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->get();

        foreach ($realJournals as $journal) {
            $allHistory->push((object) [
                'id' => $journal->id,
                'title' => $journal->title ?? '-',
                'description' => $journal->description,
                'date_full' => $journal->date,
                'date_display' => Carbon::parse($journal->date)->translatedFormat('d F'),
                'year' => Carbon::parse($journal->date)->format('Y'),
                'location' => $journal->location,
                'images' => $journal->image ? [asset('storage/' . $journal->image)] : [],
                'is_filled' => true,
                'schedule' => $journal->schedule,
                'created_at_dt' => Carbon::parse($journal->date)->startOfDay()
            ]);
        }

        // 2. Scan for missed journals
        for ($date = clone $startDate; $date->lte($endDate); $date->addDay()) {
            $dayName = strtolower($date->format('l'));
            $daySchedules = $schedules->where('day', $dayName);

            foreach ($daySchedules as $sch) {
                $sessionEnded = false;
                if ($date->lt(now()->startOfDay())) {
                    $sessionEnded = true;
                } elseif ($date->isToday()) {
                    $endTime = Carbon::parse($sch->end_time);
                    if (now()->gt($endTime)) {
                        $sessionEnded = true;
                    }
                }

                $scheduleExistsOnDate = $date->isAfter($sch->created_at->startOfDay()) || $date->isSameDay($sch->created_at);

                if ($sessionEnded && $scheduleExistsOnDate) {
                    $dateStr = $date->toDateString();
                    $exists = $realJournals->where('date', $dateStr)
                        ->where('schedule_id', $sch->id)
                        ->isNotEmpty();

                    if (!$exists) {
                        $allHistory->push((object) [
                            'id' => null,
                            'title' => '-',
                            'description' => '-',
                            'date_full' => $dateStr,
                            'date_display' => $date->translatedFormat('d F'),
                            'year' => $date->format('Y'),
                            'location' => $sch->location_name ?? $sch->location,
                            'images' => [],
                            'is_filled' => false,
                            'schedule' => $sch,
                            'created_at_dt' => clone $date
                        ]);
                    }
                }
            }
        }

        $journals = $allHistory->sortByDesc('created_at_dt')->values();

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
        $isSchool = $user->hasRole('school');

        if (!$isSchool) {
            $employee = $user->employee ?? \App\Models\Employee::where('user_id', $user->id)->first();
            $extracurricular = $journal->extracurricular;

            if (!$employee || $extracurricular->employee_id !== $employee->id) {
                return ResponseHelper::unauthorized();
            }
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

        $date = $request->date;
        $isHistory = !$date;

        if ($isHistory) {
            $user = auth()->user();
            $query = ExtracurricularAttendance::query();

            if ($user->hasRole('student')) {
                $studentId = $user->student?->id;
                $eskulStudentIds = $extracurricular->extracurricularStudents
                    ->where('student_id', $studentId)
                    ->pluck('id');
                $attendancesQuery = $query->whereIn('extracurricular_student_id', $eskulStudentIds);
            } else {
                $attendancesQuery = $query->whereIn('extracurricular_student_id', $extracurricular->extracurricularStudents->pluck('id'));
            }

            $attendancesQuery->with('extracurricularStudent.student.user')
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc');

            if ($request->status) {
                $attendancesQuery->where('status', $request->status);
            }

            if ($request->search) {
                $attendancesQuery->whereHas('extracurricularStudent.student.user', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%');
                });
            }

            $attendancesPaginator = $attendancesQuery->paginate($request->get('limit', 20));

            $history = collect($attendancesPaginator->items())->map(function ($att) {
                return [
                    'id' => $att->id,
                    'extracurricular_student_id' => $att->extracurricular_student_id,
                    'name' => $att->extracurricularStudent->student->user->name ?? '-',
                    'image' => $att->extracurricularStudent->student->image ? asset('storage/' . $att->extracurricularStudent->student->image) : null,
                    'status' => $att->status,
                    'date' => $att->date,
                    'day' => Carbon::parse($att->date)->translatedFormat('l'),
                    'clock_in' => ($att->status == 'hadir' && $att->created_at->format('H:i') != '00:00') ? $att->created_at->format('H:i') : null,
                ];
            });

            return ResponseHelper::success([
                'extracurricular' => [
                    'id' => $extracurricular->id,
                    'name' => $extracurricular->name,
                ],
                'attendance' => $history,
                'meta' => [
                    'current_page' => $attendancesPaginator->currentPage(),
                    'last_page' => $attendancesPaginator->lastPage(),
                    'total' => $attendancesPaginator->total(),
                ]
            ]);
        }

        // Daily View logic (original)
        $date = $request->date ?? Carbon::today()->format('Y-m-d');
        $dateCarbon = Carbon::parse($date);
        $dayName = strtolower($dateCarbon->format('l'));

        $schedule = ExtracurricularSchedule::where('extracurricular_id', $extracurricularId)
            ->where('day', $dayName)
            ->first();

        $isTimePassed = false;
        if ($schedule) {
            $scheduleExistsOnDate = $dateCarbon->isAfter($schedule->created_at->startOfDay()) || $dateCarbon->isSameDay($schedule->created_at);

            if ($scheduleExistsOnDate) {
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
        }

        $journal = ExtracurricularJournal::where('extracurricular_id', $extracurricularId)
            ->where('date', $date)
            ->first();

        // LOGIC REMOVED: No auto-create journal if time passed
        // LOGIC REMOVED: No auto-create alpha if time passed

        // Cleanup: Remove invalid auto-alphas that predate schedule or enrollment
        $invalidAttendanceIds = ExtracurricularAttendance::whereIn('extracurricular_student_id', $extracurricular->extracurricularStudents->pluck('id'))
            ->where('status', 'alpha')
            ->whereNull('extracurricular_journal_id')
            ->get()
            ->filter(function ($att) use ($extracurricular) {
                $esStudent = $extracurricular->extracurricularStudents->firstWhere('id', $att->extracurricular_student_id);
                if (!$esStudent)
                    return true;

                $attDate = Carbon::parse($att->date)->startOfDay();
                $dayName = strtolower($attDate->format('l'));
                $sched = $extracurricular->schedules->where('day', $dayName)->first();

                if (!$sched)
                    return true;

                return $attDate->lt($sched->created_at->startOfDay()) ||
                    $attDate->lt($esStudent->created_at->startOfDay());
            })
            ->pluck('id');

        if ($invalidAttendanceIds->isNotEmpty()) {
            ExtracurricularAttendance::whereIn('id', $invalidAttendanceIds)->delete();
        }

        $attendances = collect();
        if ($journal) {
            $attendances = ExtracurricularAttendance::where('extracurricular_journal_id', $journal->id)
                ->get()
                ->keyBy('extracurricular_student_id');
        } else {
            // Also fetch attendances without journals (like auto-alphas or permissions)
            $attendances = ExtracurricularAttendance::where('date', $date)
                ->whereIn('extracurricular_student_id', $extracurricular->extracurricularStudents->pluck('id'))
                ->get()
                ->keyBy('extracurricular_student_id');
        }

        $students = $extracurricular->extracurricularStudents->map(function ($es) use ($attendances, $isTimePassed, $date, $journal) {
            $attendance = $attendances->get($es->id);
            $status = $attendance?->status;

            if ($status === null && $isTimePassed) {
                // Check for approved permission
                $permission = \App\Models\ExtracurricularPermission::where('extracurricular_student_id', $es->id)
                    ->where('date', $date)
                    ->where('status', 'approved')
                    ->first();

                $status = $permission ? $permission->type : 'alpha';

                // Persist the auto-alpha/permission status
                ExtracurricularAttendance::create([
                    'extracurricular_student_id' => $es->id,
                    'date' => $date,
                    'status' => $status,
                    'extracurricular_journal_id' => $journal?->id ?? null,
                ]);
            }

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
            'image' => 'nullable|image|max:2048',
            'attendance' => 'nullable|array',
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

        // Process attendance if provided
        $attendanceData = $request->input('attendance', []);
        if (!empty($attendanceData)) {
            foreach ($attendanceData as $item) {
                // Handle both array of objects or indexed fields from MultipartRequest
                $esStudentId = $item['student_id'] ?? null;
                $status = $item['status'] ?? null;

                if ($esStudentId && $status) {
                    ExtracurricularAttendance::updateOrCreate(
                        [
                            'extracurricular_student_id' => $esStudentId,
                            'date' => $request->input('date'),
                        ],
                        [
                            'extracurricular_journal_id' => $journal->id,
                            'status' => $status,
                        ]
                    );
                }
            }
        }

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
     * Student self check-in (location based)
     */
    public function studentCheckIn(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::validationError($validator->errors()->first());
        }

        $user = auth()->user();
        if (!$user->hasRole('student')) {
            return ResponseHelper::error('Hanya siswa yang dapat melakukan absen mandiri', 403);
        }

        $studentId = $user->student?->id;
        if (!$studentId) {
            return ResponseHelper::error('Data siswa tidak ditemukan', 404);
        }

        // Find the extracurricular student record
        $eskulStudent = \App\Models\ExtracurricularStudent::where('extracurricular_id', $request->extracurricular_id)
            ->where('student_id', $studentId)
            ->first();

        if (!$eskulStudent) {
            return ResponseHelper::error('Anda tidak terdaftar di ekstrakurikuler ini', 404);
        }

        // Check if there's a schedule for today
        $today = Carbon::today();
        $dayName = strtolower($today->format('l'));

        $schedule = ExtracurricularSchedule::where('extracurricular_id', $request->extracurricular_id)
            ->where('day', $dayName)
            ->first();

        if (!$schedule) {
            return ResponseHelper::error('Tidak ada jadwal eskul hari ini', 400);
        }

        // Check if already checked in today
        $existingAttendance = ExtracurricularAttendance::where('extracurricular_student_id', $eskulStudent->id)
            ->where('date', $today->format('Y-m-d'))
            ->where('status', 'hadir')
            ->first();

        if ($existingAttendance) {
            return ResponseHelper::error('Anda sudah absen hari ini', 400);
        }

        // Validate location if schedule has location settings
        if ($schedule->latitude && $schedule->longitude && $schedule->radius) {
            $distance = $this->calculateDistance(
                $request->latitude,
                $request->longitude,
                $schedule->latitude,
                $schedule->longitude
            );

            if ($distance > $schedule->radius) {
                return ResponseHelper::error(
                    "Anda berada di luar radius lokasi absen. Jarak: " . round($distance) . "m, Maksimal: " . $schedule->radius . "m",
                    400
                );
            }
        }

        // Create or update attendance record
        $attendance = ExtracurricularAttendance::updateOrCreate(
            [
                'extracurricular_student_id' => $eskulStudent->id,
                'date' => $today->format('Y-m-d'),
            ],
            [
                'status' => 'hadir',
            ]
        );

        return ResponseHelper::success([
            'attendance_id' => $attendance->id,
            'status' => 'hadir',
            'check_in_time' => $attendance->updated_at->format('H:i:s'),
        ], 'Absen masuk berhasil!');
    }

    /**
     * Calculate distance between two coordinates in meters (Haversine formula)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $lat1Rad = deg2rad($lat1);
        $lat2Rad = deg2rad($lat2);
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLon = deg2rad($lon2 - $lon1);

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
            cos($lat1Rad) * cos($lat2Rad) *
            sin($deltaLon / 2) * sin($deltaLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Store new schedule
     */
    public function storeSchedule(Request $request)
    {
        // Verify ownership - must be pembina OR school role
        $user = auth()->user();
        $isSchool = $user->hasRole('school');

        if (!$isSchool) {
            $employee = $user->employee ?? \App\Models\Employee::where('user_id', $user->id)->first();
            $extracurricular = Extracurricular::find($request->input('extracurricular_id'));

            if (!$employee || !$extracurricular || $extracurricular->employee_id !== $employee->id) {
                return ResponseHelper::unauthorized();
            }
        }

        $request->validate([
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'radius' => 'nullable|numeric|min:10|max:500',
        ]);

        // Check if schedule already exists for this day
        $existingSchedule = ExtracurricularSchedule::where('extracurricular_id', $request->input('extracurricular_id'))
            ->where('day', $request->input('day'))
            ->exists();

        if ($existingSchedule) {
            return ResponseHelper::error('Jadwal untuk hari ini sudah ada. Hanya 1 jadwal per hari yang diizinkan.', 422);
        }

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
     * Update schedule
     */
    public function updateSchedule(Request $request, $id)
    {
        $schedule = ExtracurricularSchedule::find($id);

        if (!$schedule) {
            return ResponseHelper::notFound('Jadwal tidak ditemukan');
        }

        // Verify ownership - must be pembina OR school role
        $user = auth()->user();
        $isSchool = $user->hasRole('school');

        if (!$isSchool) {
            $employee = $user->employee ?? \App\Models\Employee::where('user_id', $user->id)->first();
            $extracurricular = $schedule->extracurricular;

            if (!$employee || !$extracurricular || $extracurricular->employee_id !== $employee->id) {
                return ResponseHelper::unauthorized();
            }
        }

        $request->validate([
            'day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'radius' => 'nullable|numeric|min:10|max:500',
        ]);

        // Check if another schedule exists for the same day (exclude current)
        $existingSchedule = ExtracurricularSchedule::where('extracurricular_id', $schedule->extracurricular_id)
            ->where('day', $request->input('day'))
            ->where('id', '!=', $id)
            ->exists();

        if ($existingSchedule) {
            return ResponseHelper::error('Jadwal untuk hari ini sudah ada.', 422);
        }

        $schedule->update([
            'day' => $request->input('day'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'location_name' => $request->input('location'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'radius' => $request->input('radius', 100),
        ]);

        return ResponseHelper::success(null, 'Jadwal berhasil diperbarui');
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

        // Verify ownership
        $user = auth()->user();
        $isSchool = $user->hasRole('school');

        if (!$isSchool) {
            $employee = $user->employee ?? \App\Models\Employee::where('user_id', $user->id)->first();
            $extracurricular = $schedule->extracurricular;

            if (!$employee || !$extracurricular || $extracurricular->employee_id !== $employee->id) {
                return ResponseHelper::unauthorized();
            }
        }

        $schedule->delete();

        return ResponseHelper::success(null, 'Jadwal berhasil dihapus');
    }
    /**
     * Get permissions for students in the extracurricular.
     */
    public function permissions($extracurricularId, Request $request)
    {
        $extracurricular = Extracurricular::with('extracurricularStudents.student.user')->findOrFail($extracurricularId);
        $user = auth()->user();

        $query = \App\Models\ExtracurricularPermission::where('extracurricular_id', $extracurricularId)
            ->with(['extracurricularStudent.student.user']);

        // If student, only show their own permissions
        if ($user->hasRole('student')) {
            $studentId = $user->student?->id;
            $eskulStudentIds = $extracurricular->extracurricularStudents
                ->where('student_id', $studentId)
                ->pluck('id');
            $query->whereIn('extracurricular_student_id', $eskulStudentIds);
        }

        // Filter by status
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $permissions = $query->latest()->get()->map(function ($perm) use ($extracurricular) {
            $student = $perm->extracurricularStudent?->student;
            return [
                'id' => $perm->id,
                'student_name' => $student?->user?->name ?? '-',
                'student_id' => $student?->id,
                'class_name' => $student?->classroom?->name ?? '-',
                'gender' => $student?->gender ?? '-',
                'type' => $perm->type,
                'status' => $perm->status,
                'date' => $perm->date?->format('Y-m-d'),
                'date_formatted' => $perm->date?->translatedFormat('d F Y'),
                'duration' => '1 Hari',
                'reason' => $perm->reason,
                'attachment_url' => $perm->attachment ? asset('storage/' . $perm->attachment) : null,
                'rejection_note' => $perm->rejection_note,
                'created_at' => $perm->created_at?->format('Y-m-d H:i:s'),
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
            'rejection_note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::validationError($validator->errors()->first());
        }

        $permission = \App\Models\ExtracurricularPermission::find($permissionId);

        if (!$permission) {
            return ResponseHelper::notFound('Data perizinan tidak ditemukan');
        }

        $status = $request->status;
        if ($status == 'disetujui')
            $status = 'approved';
        if ($status == 'ditolak')
            $status = 'rejected';

        $permission->status = $status;
        if ($request->rejection_note) {
            $permission->rejection_note = $request->rejection_note;
        }
        $permission->save();

        return ResponseHelper::success($permission, 'Status perizinan berhasil diperbarui');
    }

    /**
     * Store new extracurricular permission (for students)
     */
    public function storePermission(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'type' => 'required|in:izin,sakit',
            'date' => 'required|date',
            'reason' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::validationError($validator->errors()->first());
        }

        $user = auth()->user();
        if (!$user->hasRole('student')) {
            return ResponseHelper::error('Hanya siswa yang dapat mengajukan perizinan', 403);
        }

        $studentId = $user->student?->id;
        if (!$studentId) {
            return ResponseHelper::error('Data siswa tidak ditemukan', 404);
        }

        // Find the extracurricular student record
        $eskulStudent = \App\Models\ExtracurricularStudent::where('extracurricular_id', $request->extracurricular_id)
            ->where('student_id', $studentId)
            ->first();

        if (!$eskulStudent) {
            return ResponseHelper::error('Anda tidak terdaftar di ekstrakurikuler ini', 404);
        }

        // Handle attachment upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('extracurricular-permissions', 'public');
        }

        $permission = \App\Models\ExtracurricularPermission::create([
            'extracurricular_id' => $request->extracurricular_id,
            'extracurricular_student_id' => $eskulStudent->id,
            'date' => $request->date,
            'type' => $request->type,
            'reason' => $request->reason,
            'attachment' => $attachmentPath,
            'status' => 'pending',
        ]);

        return ResponseHelper::success($permission, 'Perizinan berhasil diajukan');
    }
}
