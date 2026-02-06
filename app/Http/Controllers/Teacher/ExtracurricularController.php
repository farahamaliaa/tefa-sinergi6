<?php

namespace App\Http\Controllers\Teacher;

use App\Contracts\Interfaces\ExtracurricularInterface;
use App\Contracts\Interfaces\ExtracurricularStudentInterface;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Extracurricular;
use App\Models\ExtracurricularAttendance;
use App\Models\ExtracurricularJournal;
use App\Models\ExtracurricularPermission;
use App\Models\ExtracurricularSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExtracurricularController extends Controller
{
    private ExtracurricularInterface $extracurricular;

    private ExtracurricularStudentInterface $extracurricularStudent;

    public function __construct(
        ExtracurricularInterface $extracurricular,
        ExtracurricularStudentInterface $extracurricularStudent
    ) {
        $this->extracurricular = $extracurricular;
        $this->extracurricularStudent = $extracurricularStudent;
    }

    public function index(Request $request)
    {
        $employee = auth()->user()->employee;

        $extracurriculars = Extracurricular::where('employee_id', $employee->id)
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->search.'%');
            })
            ->with('extracurricularStudents')
            ->latest()
            ->get();

        return view('teacher.pages.ekstrakulikuler.index', compact('extracurriculars'));
    }

    public function studentsIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');

        if (! $extracurricularId) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        // Get extracurricular info
        $extracurricular = Extracurricular::find($extracurricularId);

        if (! $extracurricular) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        // Get extracurricular students
        $extracurricularStudents = $extracurricular->extracurricularStudents()
            ->with('student.user', 'student.classroomStudents.classroom')
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('student.user', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%'.$request->search.'%');
                });
            })
            ->get();
        $classrooms = Classroom::orderBy('name')->get();

        return view('teacher.pages.extracurricular-students.index', compact('extracurricularStudents', 'extracurricular', 'classrooms'));
    }

    public function attendanceIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');

        if (! $extracurricularId) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        $extracurricular = Extracurricular::find($extracurricularId);

        if (! $extracurricular) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        // Get extracurricular students
        $extracurricularStudents = $extracurricular->extracurricularStudents()
            ->with('student.user', 'student.classroomStudents.classroom')
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('student.user', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%'.$request->search.'%');
                });
            })
            ->get();

        // Get date filter
        $date = $request->get('date');
        $isHistory = ! $date;

        if ($isHistory) {
            $attendancesQuery = ExtracurricularAttendance::with(['extracurricularStudent.student.user', 'extracurricularStudent.student.classroomStudents.classroom'])
                ->whereIn('extracurricular_student_id', $extracurricular->extracurricularStudents->pluck('id'))
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc');

            if ($request->status) {
                $attendancesQuery->where('status', $request->status);
            }

            if ($request->search) {
                $attendancesQuery->whereHas('extracurricularStudent.student.user', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%'.$request->search.'%');
                });
            }

            $attendancesPaginator = $attendancesQuery->paginate(15);
            $summary = ['hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alpha' => 0];

            // For summary in history mode, we might want total counts in the range or just empty?
            // Usually summary cards are more useful in daily view, but let's provide totals.
            $totalSummary = ExtracurricularAttendance::whereIn('extracurricular_student_id', $extracurricular->extracurricularStudents->pluck('id'))
                ->selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status');

            $summary = [
                'hadir' => $totalSummary['hadir'] ?? 0,
                'sakit' => $totalSummary['sakit'] ?? 0,
                'izin' => $totalSummary['izin'] ?? 0,
                'alpha' => $totalSummary['alpha'] ?? 0,
            ];

            return view('teacher.pages.extracurricular-attendance.index', compact(
                'extracurricular',
                'attendancesPaginator',
                'summary',
                'date',
                'isHistory'
            ));
        }

        // Daily View (when date is provided)
        $extracurricularStudents = $extracurricular->extracurricularStudents()
            ->with('student.user', 'student.classroomStudents.classroom')
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('student.user', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%'.$request->search.'%');
                });
            })
            ->get();

        $dateCarbon = \Carbon\Carbon::parse($date);
        $dayName = strtolower($dateCarbon->format('l'));

        // Identify if time passed for this schedule
        $schedule = $extracurricular->schedules()->where('day', $dayName)->first();
        $isTimePassed = false;
        if ($schedule) {
            $scheduleExistsOnDate = $dateCarbon->isAfter($schedule->created_at->startOfDay()) || $dateCarbon->isSameDay($schedule->created_at);

            if ($scheduleExistsOnDate) {
                if ($dateCarbon->isPast() && ! $dateCarbon->isToday()) {
                    $isTimePassed = true;
                } elseif ($dateCarbon->isToday()) {
                    $endTime = \Carbon\Carbon::parse($schedule->end_time);
                    if (now()->gt($endTime)) {
                        $isTimePassed = true;
                    }
                }
            }
        }

        // Get journal for this date
        $journal = $extracurricular->journals()
            ->where('date', $date)
            ->first();

        // Cleanup: Remove invalid auto-alphas that predate schedule or enrollment
        $invalidAttendanceIds = ExtracurricularAttendance::whereIn('extracurricular_student_id', $extracurricularStudents->pluck('id'))
            ->where('status', 'alpha')
            ->whereNull('extracurricular_journal_id')
            ->get()
            ->filter(function ($att) use ($extracurricular, $extracurricularStudents) {
                $esStudent = $extracurricularStudents->firstWhere('id', $att->extracurricular_student_id);
                if (! $esStudent) {
                    return true;
                }

                $attDate = \Carbon\Carbon::parse($att->date)->startOfDay();
                $dayName = strtolower($attDate->format('l'));
                $sched = $extracurricular->schedules->where('day', $dayName)->first();

                if (! $sched) {
                    return true;
                }

                return $attDate->lt($sched->created_at->startOfDay()) ||
                    $attDate->lt($esStudent->created_at->startOfDay());
            })
            ->pluck('id');

        if ($invalidAttendanceIds->isNotEmpty()) {
            ExtracurricularAttendance::whereIn('id', $invalidAttendanceIds)->delete();
        }

        // Build attendance map
        $summary = ['hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alpha' => 0];

        // Fetch all attendances for this date, with or without journal
        $attendances = ExtracurricularAttendance::where('date', $date)
            ->whereIn('extracurricular_student_id', $extracurricularStudents->pluck('id'))
            ->get()
            ->keyBy('extracurricular_student_id');

        $attendanceMap = $attendances;

        // If no schedule today AND no attendance records, don't show students
        if (! $schedule && $attendances->isEmpty()) {
            $extracurricularStudents = collect();
        }

        // Auto-create Alpha records if time has passed and no attendance recorded
        if ($isTimePassed) {
            foreach ($extracurricularStudents as $esStudent) {
                if (! $attendanceMap->has($esStudent->id)) {
                    // Check if student was already enrolled on this date
                    if ($esStudent->created_at->startOfDay()->gt($dateCarbon->startOfDay())) {
                        continue;
                    }

                    // Check for approved permission for this date
                    $permission = ExtracurricularPermission::where('extracurricular_student_id', $esStudent->id)
                        ->where('date', $date)
                        ->where('status', 'approved')
                        ->first();

                    if ($permission) {
                        $status = $permission->type; // 'izin' or 'sakit'
                    } else {
                        $status = 'alpha';
                    }

                    $alpha = ExtracurricularAttendance::create([
                        'extracurricular_student_id' => $esStudent->id,
                        'date' => $date,
                        'status' => $status,
                        'extracurricular_journal_id' => $journal?->id ?? null,
                    ]);
                    $attendanceMap->put($esStudent->id, $alpha);
                }
            }
        }

        // Calculate summary based on finalized attendance map
        foreach ($attendanceMap as $attendance) {
            if (isset($summary[$attendance->status])) {
                $summary[$attendance->status]++;
            }
        }

        // Apply Status Filter to the displayed students list
        $statusFilter = $request->get('status');
        if ($statusFilter) {
            $extracurricularStudents = $extracurricularStudents->filter(function ($es) use ($attendanceMap, $statusFilter) {
                $status = $attendanceMap->get($es->id)?->status ?? 'belum';

                return $status === $statusFilter;
            });
        }

        return view('teacher.pages.extracurricular-attendance.index', compact(
            'extracurricularStudents',
            'extracurricular',
            'attendanceMap',
            'summary',
            'date'
        ));
    }

    public function permissionIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');

        if (! $extracurricularId) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        $extracurricular = Extracurricular::find($extracurricularId);

        if (! $extracurricular) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        // Get permissions for this extracurricular
        $permissions = ExtracurricularPermission::where('extracurricular_id', $extracurricularId)
            ->with('extracurricularStudent.student.user', 'extracurricularStudent.student.classroomStudents.classroom', 'schedule')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('teacher.pages.extracurricular-permission.index', compact('permissions', 'extracurricular'));
    }

    public function journalIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');

        if (! $extracurricularId) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        $extracurricular = Extracurricular::with('schedules', 'journals.schedule', 'journals.attendances', 'extracurricularStudents')
            ->find($extracurricularId);

        if (! $extracurricular) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        // Get today's day name in lowercase (e.g., 'monday', 'tuesday')
        $todayDayName = strtolower(now()->format('l'));

        // Get schedules for today
        $todaySchedules = $extracurricular->schedules()
            ->where('day', $todayDayName)
            ->get();

        // Check which schedules already have journals for today
        $todaysJournals = $extracurricular->journals()
            ->whereDate('date', now()->toDateString())
            ->with('schedule', 'attendances')
            ->get();

        // Create a unified history of real and missed journals (last 30 days)
        $allHistory = collect();
        $startDate = now()->subDays(30)->startOfDay();
        $endDate = now();
        $schedules = $extracurricular->schedules;

        // 1. Get real journals (last 30 days)
        $realJournals = $extracurricular->journals()
            ->with('schedule', 'attendances')
            ->where('date', '>=', $startDate->toDateString())
            ->get();

        foreach ($realJournals as $journal) {
            $allHistory->push((object) [
                'id' => $journal->id,
                'date' => \Carbon\Carbon::parse($journal->date),
                'schedule' => $journal->schedule,
                'description' => $journal->description,
                'image' => $journal->image,
                'attendances' => $journal->attendances,
                'is_filled' => true,
                'created_at' => \Carbon\Carbon::parse($journal->date)->startOfDay(),
            ]);
        }

        // 2. Scan for missed journals (last 30 days, but only AFTER schedule was created)
        for ($date = clone $startDate; $date->lte($endDate); $date->addDay()) {
            $dayName = strtolower($date->format('l'));
            $daySchedules = $schedules->where('day', $dayName);

            foreach ($daySchedules as $sch) {
                $sessionEnded = false;
                if ($date->lt(now()->startOfDay())) {
                    $sessionEnded = true;
                } elseif ($date->isToday()) {
                    $endTime = \Carbon\Carbon::parse($sch->end_time);
                    if (now()->gt($endTime)) {
                        $sessionEnded = true;
                    }
                }

                // Check if the schedule existed on this date
                $scheduleExistsOnDate = $date->isAfter($sch->created_at->startOfDay()) || $date->isSameDay($sch->created_at);

                if ($sessionEnded && $scheduleExistsOnDate) {
                    $dateStr = $date->toDateString();
                    $exists = $realJournals->where('date', $dateStr)
                        ->where('schedule_id', $sch->id)
                        ->isNotEmpty();

                    if (! $exists) {
                        $allHistory->push((object) [
                            'id' => null,
                            'date' => clone $date,
                            'schedule' => $sch,
                            'description' => '-',
                            'image' => null,
                            'attendances' => collect(),
                            'is_filled' => false,
                            'created_at' => clone $date,
                        ]);
                    }
                }
            }
        }

        // Sort by date DESC
        $sortedHistory = $allHistory->sort(function ($a, $b) {
            if ($a->date->toDateString() === $b->date->toDateString()) {
                return strcmp($b->schedule->start_time, $a->schedule->start_time);
            }

            return $b->date <=> $a->date;
        });

        // Manual Pagination
        $currentPage = $request->get('page', 1);
        $perPage = 10;
        $journalHistory = new \Illuminate\Pagination\LengthAwarePaginator(
            $sortedHistory->forPage($currentPage, $perPage),
            $sortedHistory->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view(
            'teacher.pages.extracurricular-journal.index',
            compact('extracurricular', 'todaySchedules', 'todaysJournals', 'journalHistory')
        );
    }

    public function journalCreate(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');
        $scheduleId = $request->get('schedule');
        $date = $request->get('date', now()->toDateString());

        $extracurricular = Extracurricular::with('extracurricularStudents.student.user')
            ->find($extracurricularId);

        if (! $extracurricular) {
            return redirect()->back()->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        $schedule = ExtracurricularSchedule::find($scheduleId);

        if (! $schedule) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan');
        }

        $extracurricularStudents = $extracurricular->extracurricularStudents()
            ->with('student.user')
            ->get();

        $existingAttendances = ExtracurricularAttendance::whereIn('extracurricular_student_id', $extracurricularStudents->pluck('id'))
            ->where('date', $date)
            ->get()
            ->keyBy('extracurricular_student_id');

        return view('teacher.pages.extracurricular-journal.create', compact(
            'extracurricular',
            'schedule',
            'extracurricularStudents',
            'existingAttendances',
            'date'
        ));
    }

    public function journalShow($id)
    {
        $journal = ExtracurricularJournal::with('extracurricular')->find($id);

        if (! $journal) {
            return redirect()->back()->with('error', 'Data jurnal tidak ditemukan');
        }

        $extracurricular = $journal->extracurricular;

        $attendances = ExtracurricularAttendance::where('extracurricular_journal_id', $id)
            ->with('extracurricularStudent.student.user', 'extracurricularStudent.student.classroomStudents.classroom')
            ->get();

        return view('teacher.pages.extracurricular-journal.detail', compact('journal', 'attendances', 'extracurricular'));
    }

    public function journalEdit($id)
    {
        $journal = ExtracurricularJournal::with('extracurricular')->find($id);

        if (! $journal) {
            return redirect()->back()->with('error', 'Data jurnal tidak ditemukan');
        }

        $extracurricular = $journal->extracurricular;
        $schedules = ExtracurricularSchedule::where('extracurricular_id', $extracurricular->id)->get();

        $attendances = ExtracurricularAttendance::where('extracurricular_journal_id', $id)
            ->with('extracurricularStudent.student.user', 'extracurricularStudent.student.classroomStudents.classroom')
            ->get()
            ->keyBy('extracurricular_student_id');

        return view('teacher.pages.extracurricular-journal.update', compact('journal', 'extracurricular', 'schedules', 'attendances'));
    }

    public function scheduleIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');

        if (! $extracurricularId) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        $extracurricular = Extracurricular::with('schedules')->find($extracurricularId);

        if (! $extracurricular) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        return view('teacher.pages.extracurricular-schedule.index', compact('extracurricular'));
    }

    public function scheduleStore(Request $request)
    {
        $request->validate([
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'location_name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer|min:10|max:500',
        ]);

        $extracurricular = Extracurricular::findOrFail($request->extracurricular_id);

        // Check if schedule already exists for this day
        $existingSchedule = $extracurricular->schedules()
            ->where('day', $request->day)
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal untuk hari ini sudah ada. Hanya 1 jadwal per hari yang diizinkan.');
        }

        $extracurricular->schedules()->create([
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location_name' => $request->location_name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function scheduleDestroy($id)
    {
        $schedule = ExtracurricularSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->back()->with('success', 'Jadwal berhasil dihapus');
    }

    public function permissionApprove(Request $request, $id)
    {
        $permission = ExtracurricularPermission::findOrFail($id);

        $permission->update(['status' => 'approved']);

        // Create or update attendance with izin/sakit status
        $journal = $permission->extracurricular->journals()
            ->where('schedule_id', $permission->schedule_id)
            ->where('date', $permission->date)
            ->first();

        if ($journal) {
            ExtracurricularAttendance::updateOrCreate(
                [
                    'extracurricular_journal_id' => $journal->id,
                    'extracurricular_student_id' => $permission->extracurricular_student_id,
                ],
                [
                    'status' => $permission->type,
                    'date' => $permission->date,
                ]
            );
        } else {
            ExtracurricularAttendance::updateOrCreate(
                [
                    'extracurricular_journal_id' => null,
                    'extracurricular_student_id' => $permission->extracurricular_student_id,
                    'date' => $permission->date,
                ],
                [
                    'status' => $permission->type,
                ]
            );
        }

        return redirect()->back()->with('success', 'Izin disetujui dan status kehadiran diperbarui');
    }

    public function permissionReject(Request $request, $id)
    {
        $request->validate([
            'rejection_note' => 'nullable|string|max:500',
        ]);

        $permission = ExtracurricularPermission::findOrFail($id);

        $permission->update([
            'status' => 'rejected',
            'rejection_note' => $request->rejection_note,
        ]);

        return redirect()->back()->with('success', 'Izin ditolak');
    }

    public function journalStore(Request $request)
    {
        $request->validate([
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'schedule_id' => 'required|exists:extracurricular_schedules,id',
            'date' => 'required|date',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
            'attendance' => 'required|array',
        ]);

        // Handle image upload
        $imagePath = $request->file('image')->store('extracurricular-journals', 'public');

        // Create journal
        $journal = ExtracurricularJournal::create([
            'extracurricular_id' => $request->extracurricular_id,
            'schedule_id' => $request->schedule_id,
            'date' => now()->toDateString(),
            'description' => $request->title."\n\n".$request->description,
            'image' => $imagePath,
        ]);

        // Create attendances
        foreach ($request->attendance as $studentId => $status) {
            ExtracurricularAttendance::updateOrCreate(
                [
                    'extracurricular_student_id' => $studentId,
                    'date' => $journal->date,
                ],
                [
                    'extracurricular_journal_id' => $journal->id,
                    'status' => $status,
                ]
            );
        }

        return redirect()->route('teacher.extracurricular-journal.index', ['extracurricular' => $request->extracurricular_id])
            ->with('success', 'Jurnal berhasil disimpan');
    }

    public function journalUpdate(Request $request, $id)
    {
        $journal = ExtracurricularJournal::find($id);

        if (! $journal) {
            return redirect()->back()->with('error', 'Jurnal tidak ditemukan');
        }

        $request->validate([
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'attendance' => 'required|array',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($journal->image) {
                Storage::disk('public')->delete($journal->image);
            }
            $journal->image = $request->file('image')->store('extracurricular-journals', 'public');
        }

        $journal->description = $request->description;
        $journal->save();

        // Update attendances
        foreach ($request->attendance as $studentId => $status) {
            ExtracurricularAttendance::updateOrCreate(
                [
                    'extracurricular_journal_id' => $journal->id,
                    'extracurricular_student_id' => $studentId,
                ],
                ['status' => $status]
            );
        }

        return redirect()->route('teacher.extracurricular-journal.index', ['extracurricular' => $journal->extracurricular_id])
            ->with('success', 'Jurnal berhasil diperbarui');
    }

    public function journalDestroy($id)
    {
        $journal = ExtracurricularJournal::find($id);

        if (! $journal) {
            return redirect()->back()->with('error', 'Jurnal tidak ditemukan');
        }

        $extracurricularId = $journal->extracurricular_id;

        // Delete image
        if ($journal->image) {
            Storage::disk('public')->delete($journal->image);
        }

        // Attendances will be deleted by cascade
        $journal->delete();

        return redirect()->route('teacher.extracurricular-journal.index', ['extracurricular' => $extracurricularId])
            ->with('success', 'Jurnal berhasil dihapus');
    }
}
