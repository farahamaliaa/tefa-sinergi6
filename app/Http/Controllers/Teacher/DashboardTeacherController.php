<?php

namespace App\Http\Controllers\Teacher;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Contracts\Interfaces\ClassroomInterface;
use App\Contracts\Interfaces\LessonScheduleInterface;
use App\Contracts\Interfaces\SchoolYearInterface;
use App\Contracts\Interfaces\Teachers\TeacherJournalInterface;
use App\Contracts\Interfaces\TeacherSubjectInterface;
use App\Enums\AttendanceEnum;
use App\Http\Controllers\Controller;
use App\Services\Teacher\NotificationJournalService;
use App\Services\TeacherService;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use App\Enums\UploadDiskEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardTeacherController extends Controller
{
    use UploadTrait;
    private NotificationJournalService $notification;
    private SchoolYearInterface $schoolYear;
    private TeacherSubjectInterface $teacherSubject;
    private AttendanceInterface $attendance;
    private LessonScheduleInterface $lessonSchedule;
    private TeacherService $service;
    private TeacherJournalInterface $teacherJournal;
    private ClassroomInterface $classroom;

    public function __construct(
        NotificationJournalService $notification, SchoolYearInterface $schoolYear,
        TeacherSubjectInterface $teacherSubject, AttendanceInterface $attendance,
        LessonScheduleInterface $lessonSchedule, TeacherService $service, TeacherJournalInterface $teacherJournal,
        ClassroomInterface $classroom)
    {
        $this->notification = $notification;
        $this->schoolYear = $schoolYear;
        $this->teacherSubject = $teacherSubject;
        $this->attendance = $attendance;
        $this->lessonSchedule = $lessonSchedule;
        $this->service = $service;
        $this->teacherJournal = $teacherJournal;
        $this->classroom = $classroom;
    }

    public function index()
    {
        $notifications = $this->notification->notification();
        $schoolYear = $this->schoolYear->active();
        $teacherSubjects = $this->teacherSubject->where(auth()->user()->employee->id);
        $todayAttendance = $this->attendance->userToday('App\Models\Employee', auth()->user()->employee->id);
        $lessonSchedules = $this->lessonSchedule->getByTeacher(auth()->user()->id);
        $attendances = $this->attendance->whereUser(auth()->user()->employee->id, 'App\Models\Employee');

        $late = $this->attendance->getByUserAndStatus('App\Models\Employee', auth()->user()->employee->id, AttendanceEnum::LATE->value, 'get');
        $sick = $this->attendance->getByUserAndStatus('App\Models\Employee', auth()->user()->employee->id, AttendanceEnum::SICK->value, 'get');
        $alpha = $this->attendance->getByUserAndStatus('App\Models\Employee', auth()->user()->employee->id, AttendanceEnum::ALPHA->value, 'get');
        $present = $this->attendance->getByUserAndStatus('App\Models\Employee', auth()->user()->employee->id, AttendanceEnum::PRESENT->value, 'get');
        $permit = $this->attendance->getByUserAndStatus('App\Models\Employee', auth()->user()->employee->id, AttendanceEnum::PERMIT->value, 'get');
        $chartTeacherAttendance = $this->service->chartTeacherAttendance($late, $sick, $alpha, $present, $permit);

        $teacherJournals = $this->teacherJournal->getByTeacher(auth()->user()->employee->id);
        $classroom = $this->classroom->whereEmployeeId(auth()->user()->employee->id);
        // dd($chartTeacherAttendance);

        return view('teacher.pages.dashboard.index', compact(
            'notifications', 'schoolYear', 'teacherSubjects',
            'todayAttendance', 'lessonSchedules', 'attendances',
            'chartTeacherAttendance', 'teacherJournals', 'classroom'));
    }

    public function profile()
    {
        $user = auth()->user();
        $employee = $user->employee;
        return view('teacher.pages.profile', compact('user', 'employee'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $employee = $user->employee;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:13',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password lama tidak sesuai'])->withInput();
            }
        }

        try {
            DB::transaction(function () use ($request, $user, $employee) {
                $dataUser = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'gender' => $request->gender,
                ];

                if ($request->hasFile('image')) {
                    if ($user->image) {
                        $this->remove($user->image);
                    }
                    $dataUser['image'] = $this->upload(UploadDiskEnum::TEACHER->value, $request->file('image'));
                }

                if ($request->filled('password')) {
                    $dataUser['password'] = Hash::make($request->password);
                }

                $user->update($dataUser);

                if ($employee) {
                    $employee->update([
                        'phone_number' => $request->phone_number,
                        'address' => $request->address,
                        'gender' => $request->gender,
                    ]);
                }
            });

            return redirect()->back()->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
    public function permissions(Request $request)
    {
        // Get permissions linked to ANY classroom this teacher is homeroom for
        // Assuming relationship: Employee -> Classroom (Homeroom)
        // Or if they are a specific subject teacher? Usually Homeroom approves permissions.
        
        $classrooms = $this->classroom->whereEmployeeId(auth()->user()->employee->id);
        $classroomIds = $classrooms->pluck('id');
        
        $permissions = \App\Models\StudentPermission::whereIn('classroom_id', $classroomIds)
            ->with(['student', 'classroom'])
            ->when($request->status, function($q) use ($request) {
                return $q->where('status', $request->status);
            })
            ->latest()
            ->paginate(10);
            
        return view('teacher.pages.permissions.index', compact('permissions', 'classrooms'));
    }

    public function approvePermission(Request $request, $id)
    {
        $permission = \App\Models\StudentPermission::findOrFail($id);
        
        // Security check: ensure teacher owns this classroom
        if ($permission->classroom->employee_id !== auth()->user()->employee->id) {
             return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            DB::transaction(function() use ($permission) {
                $permission->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id()
                ]);

                // Update Attendance
                // Check if attendance exists for that date
                $attendance = \App\Models\Attendance::where('model_type', 'App\Models\ClassroomStudent')
                    ->where('model_id', $permission->student->classroomStudents->first()->id) // simplified, usually safer lookup needed
                    ->whereDate('created_at', $permission->date)
                    ->first();
                
                $statusEnum = $permission->permission_type == 'sick' 
                    ? \App\Enums\AttendanceEnum::SICK 
                    : \App\Enums\AttendanceEnum::PERMIT;

                if ($attendance) {
                    $attendance->update(['status' => $statusEnum]);
                } else {
                    \App\Models\Attendance::create([
                        'model_type' => 'App\Models\ClassroomStudent',
                        'model_id' => $permission->student->classroomStudents->first()->id,
                        'status' => $statusEnum,
                        'point' => 10, // Default point
                        'created_at' => \Carbon\Carbon::parse($permission->date),
                        'proof' => $permission->proof_image
                    ]);
                }
            });
            
            return redirect()->back()->with('success', 'Permission approved and attendance updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error approving: '.$e->getMessage());
        }
    }

    public function rejectPermission(Request $request, $id)
    {
        $permission = \App\Models\StudentPermission::findOrFail($id);
        
        // Security check
        if ($permission->classroom->employee_id !== auth()->user()->employee->id) {
             return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $permission->update([
            'status' => 'rejected',
            'approved_by' => auth()->id()
        ]);
        
        return redirect()->back()->with('success', 'Permission rejected.');
    }
}
