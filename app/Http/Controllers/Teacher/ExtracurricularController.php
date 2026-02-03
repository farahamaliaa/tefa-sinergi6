<?php

namespace App\Http\Controllers\Teacher;

use App\Contracts\Interfaces\ExtracurricularInterface;
use App\Contracts\Interfaces\ExtracurricularStudentInterface;
use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\Classroom;
use App\Models\LessonSchedule;
use App\Models\TeacherJournal;
use App\Models\ClassroomStudent;
use App\Models\ExtracurricularSchedule;
use App\Models\ExtracurricularPermission;
use App\Models\ExtracurricularJournal;
use App\Models\ExtracurricularAttendance;
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
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            })
            ->with('extracurricularStudents')
            ->latest()
            ->get();

        return view('teacher.pages.ekstrakulikuler.index', compact('extracurriculars'));
    }

    public function studentsIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');
        
        if (!$extracurricularId) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular info
        $extracurricular = Extracurricular::find($extracurricularId);
        
        if (!$extracurricular) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular students
        $extracurricularStudents = $extracurricular->extracurricularStudents()
            ->with('student.user', 'student.classroomStudents.classroom')
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('student.user', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%');
                });
            })
            ->get();
            $classrooms = Classroom::orderBy('name')->get();

        
        return view('teacher.pages.extracurricular-students.index', compact('extracurricularStudents', 'extracurricular', 'classrooms'));
    }

    public function attendanceIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');
        
        if (!$extracurricularId) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        $extracurricular = Extracurricular::find($extracurricularId);
        
        if (!$extracurricular) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        // Get extracurricular students
        $extracurricularStudents = $extracurricular->extracurricularStudents()
            ->with('student.user', 'student.classroomStudents.classroom')
            ->get();
        
        // Get date filter (default: today)
        $date = $request->get('date', now()->format('Y-m-d'));

        // Get journal for this date
        $journal = $extracurricular->journals()
            ->whereDate('date', $date)
            ->first();

        // Build attendance map
        $attendanceMap = collect();
        $summary = ['hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alpha' => 0];

        if ($journal) {
            $attendances = ExtracurricularAttendance::where('extracurricular_journal_id', $journal->id)
                ->get()
                ->keyBy('extracurricular_student_id');

            $attendanceMap = $attendances;

            foreach ($attendances as $attendance) {
                if (isset($summary[$attendance->status])) {
                    $summary[$attendance->status]++;
                }
            }
        }
        
        return view('teacher.pages.extracurricular-attendance.index', compact(
            'extracurricularStudents', 
            'extracurricular', 
            'attendanceMap',
            'summary'
        ));
    }

    public function permissionIndex(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');
        
        if (!$extracurricularId) {
            return redirect()->route('teacher.dashboard')->with('error', 'Ekstrakurikuler tidak ditemukan');
        }
        
        $extracurricular = Extracurricular::find($extracurricularId);
        
        if (!$extracurricular) {
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

        if (!$extracurricularId) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        $extracurricular = Extracurricular::with('schedules', 'journals.schedule', 'journals.attendances', 'extracurricularStudents')
            ->find($extracurricularId);

        if (!$extracurricular) {
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

        // Get journal history (past journals)
        $journalHistory = $extracurricular->journals()
            ->with('schedule', 'attendances')
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view(
            'teacher.pages.extracurricular-journal.index',
            compact('extracurricular', 'todaySchedules', 'todaysJournals', 'journalHistory')
        );
    }

    public function journalCreate(Request $request)
    {
        $extracurricularId = $request->get('extracurricular');
        $scheduleId = $request->get('schedule');

        $extracurricular = Extracurricular::find($extracurricularId);
        
        if (!$extracurricular) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        $schedule = ExtracurricularSchedule::find($scheduleId);

        if (!$schedule) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan');
        }

        $extracurricularStudents = $extracurricular->extracurricularStudents()
            ->with('student.user', 'student.classroomStudents.classroom')
            ->get();

        $existingAttendances = ExtracurricularAttendance::whereIn('extracurricular_student_id', $extracurricularStudents->pluck('id'))
            ->whereDate('date', now()->toDateString())
            ->get()
            ->keyBy('extracurricular_student_id');

        return view('teacher.pages.extracurricular-journal.create', compact(
            'extracurricular',
            'extracurricularStudents',
            'schedule',
            'existingAttendances'
        ));
    }

    public function journalShow($id)
    {
        $journal = ExtracurricularJournal::with('extracurricular')->find($id);

        if (!$journal) {
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

        if (!$journal) {
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

        if (!$extracurricularId) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Ekstrakurikuler tidak ditemukan');
        }

        $extracurricular = Extracurricular::with('schedules')->find($extracurricularId);

        if (!$extracurricular) {
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
            ->whereDate('date', $permission->date)
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
            'description' => $request->title . "\n\n" . $request->description,
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

        if (!$journal) {
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

        if (!$journal) {
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
