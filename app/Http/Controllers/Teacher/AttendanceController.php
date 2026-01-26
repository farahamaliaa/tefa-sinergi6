<?php

namespace App\Http\Controllers\Teacher;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Contracts\Interfaces\ClassroomStudentInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    private ClassroomStudentInterface $studentClass;
    private AttendanceInterface $attendance;

    public function __construct(AttendanceInterface $attendance, ClassroomStudentInterface $studentClass)
    {
        $this->attendance = $attendance;
        $this->studentClass = $studentClass;
    }

    public function index()
    {
        $attendances = $this->attendance->whereUser(auth()->user()->employee->id, 'App\Models\Employee');
        return view('teacher.pages.attendance-history.index', compact('attendances'));
    }

    public function classroomIndex(Request $request)
    {
        $classroomId = $request->get('classroom');
        
        if (!$classroomId) {
            return redirect()->route('teacher.dashboard')->with('error', 'Kelas tidak ditemukan');
        }
        
        $classroom = \App\Models\Classroom::find($classroomId);
        
        if (!$classroom) {
            return redirect()->route('teacher.dashboard')->with('error', 'Kelas tidak ditemukan');
        }
        
        $classroomStudents = $this->studentClass->where($classroomId, $request);
        
        $attendances = $this->attendance->whereClassroomFiltered($classroomId, $request);
        
        return view('teacher.pages.classroom-attendance.index', compact('attendances', 'classroomStudents', 'classroom'));
    }

    public function permissionIndex(Request $request)
    {
        $classroomId = $request->get('classroom');
        
        if (!$classroomId) {
            return redirect()->route('teacher.dashboard')->with('error', 'Kelas tidak ditemukan');
        }
        
        $classroom = \App\Models\Classroom::find($classroomId);
        
        if (!$classroom) {
            return redirect()->route('teacher.dashboard')->with('error', 'Kelas tidak ditemukan');
        }
        
        $classroomStudents = $this->studentClass->where($classroomId, new Request());
        
        $query = \App\Models\StudentPermission::where('classroom_id', $classroomId)
            ->with(['student.user', 'submittedBy', 'approvedBy']);
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('student.user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }
        
        if ($request->filled('date')) {
            $query->whereDate('date', $request->get('date'));
        }
        
        $permissions = $query->latest()->get();
        
        return view('teacher.pages.classroom-permission.index', compact('classroomStudents', 'classroom', 'permissions'));
    }

    public function approvePermission(Request $request, $id)
    {
        $permission = \App\Models\StudentPermission::findOrFail($id);
        
        $classroom = \App\Models\Classroom::find($permission->classroom_id);
        
        if (!$classroom || $classroom->employee_id !== auth()->user()->employee->id) {
            return back()->with('error', 'Anda bukan wali kelas untuk kelas ini');
        }
        
        $permission->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Izin berhasil disetujui',
            ]);
        }
        
        return back()->with('success', 'Izin berhasil disetujui');
    }

    public function rejectPermission(Request $request, $id)
    {
        $permission = \App\Models\StudentPermission::findOrFail($id);
        
        $classroom = \App\Models\Classroom::find($permission->classroom_id);
        
        if (!$classroom || $classroom->employee_id !== auth()->user()->employee->id) {
            return back()->with('error', 'Anda bukan wali kelas untuk kelas ini');
        }
        
        $permission->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Izin berhasil ditolak',
            ]);
        }
        
        return back()->with('success', 'Izin berhasil ditolak');
    }
}
