<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Interfaces\AttendanceInterface;
use App\Contracts\Interfaces\AttendanceRuleInterface;
use App\Contracts\Interfaces\EmployeeInterface;
use App\Contracts\Interfaces\EmployeeJournalInterface;
use App\Contracts\Interfaces\RegulationInterface;
use App\Contracts\Interfaces\SchoolPointInterface;
use App\Contracts\Interfaces\StudentInterface;
use App\Contracts\Interfaces\StudentRepairInterface;
use App\Contracts\Interfaces\StudentViolationInterface;
use App\Enums\AttendanceEnum;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeJournalResource;
use App\Http\Resources\HistoryAttendanceResource;
use App\Http\Resources\PopularViolationResource;
use App\Http\Resources\RegulationResource;
use App\Http\Resources\RepairStudentResource;
use App\Http\Resources\StudentPermissionResource;
use App\Http\Resources\StudentPointResource;
use App\Models\User;
use App\Models\Attendance;
use App\Models\EmployeePermission;
use App\Enums\StatusPermissionEnum;
use App\Services\EmployeeJournalService;
use App\Services\StaffChartService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StafApiController extends Controller
{
    private StudentViolationInterface $studentViolation;
    private StudentRepairInterface $studentRepair;
    private SchoolPointInterface $schoolPoint;
    private StudentInterface $student;
    private EmployeeInterface $employee;
    private EmployeeJournalService $journalService;
    private EmployeeJournalInterface $employeeJournal;
    private RegulationInterface $regulation;
    private AttendanceRuleInterface $attendanceRule;
    private AttendanceInterface $attendance;
    private StaffChartService $chartService;


    public function __construct(
        AttendanceRuleInterface $attendanceRule,
        StudentViolationInterface $studentViolation,
        StudentRepairInterface $studentRepair,
        SchoolPointInterface $schoolPoint,
        StudentInterface $student,
        EmployeeInterface $employee,
        EmployeeJournalService $journalService,
        EmployeeJournalInterface $employeeJournal,
        RegulationInterface $regulation,
        AttendanceInterface $attendance,
        StaffChartService $chartService
    ) {
        $this->attendanceRule = $attendanceRule;
        $this->studentViolation = $studentViolation;
        $this->studentRepair = $studentRepair;
        $this->schoolPoint = $schoolPoint;
        $this->student = $student;
        $this->employee = $employee;
        $this->journalService = $journalService;
        $this->employeeJournal = $employeeJournal;
        $this->regulation = $regulation;
        $this->attendance = $attendance;
        $this->chartService = $chartService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }

        try {
            $approved = $this->studentRepair->count_approved('1');
            $process = $this->studentRepair->count_approved('0');
            $not_process = $this->studentRepair->count_approved(null);

            return ResponseHelper::success([
                'approved' => $approved,
                'process' => $process,
                'not_process' => $not_process,
            ]);
        } catch (\Throwable $th) {
            return ResponseHelper::error('Data Kosong', 400);
        }
    }

    public function history_journals(User $user)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }

        try {
            $employeeJournals = $this->journalService->getHistory($user);
            $todayJournal = $employeeJournals->first(function ($item) {
                return \Carbon\Carbon::parse($item->created_at)->isToday();
            });

            if ($todayJournal && $todayJournal->status === \App\Enums\StatusEnum::NOT_COMPLETED) {
                return ResponseHelper::success([
                    'journal_message' => 'Hari ini anda belum mengisi jurnal!',
                    'journals' => EmployeeJournalResource::collection($employeeJournals),
                ]);
            } else {
                return ResponseHelper::success([
                    'journals' => EmployeeJournalResource::collection($employeeJournals),
                ]);
            }

        } catch (\Throwable $th) {
            return ResponseHelper::error('Data Kosong ' . $th->getMessage(), 400);
        }
    }

    public function create_journal(User $user, Request $request)
    {
        $condition = $this->attendanceRule->whereDayRole(Carbon::today()->format('l'), 'teacher');
        if (Carbon::now()->format('H:i:s') <= $condition->checkout_end) {
            return ResponseHelper::error('Anda belum waktunya mengisi jurnal', 400);
        }

        $description = preg_replace('/\s+/', '', $request->input('description'));
        if (strlen($description) < 10) {
            return ResponseHelper::error('Deskripsi minimal harus 10 karakter tanpa spasi', 400);
        }

        $employee = $this->employee->getByUser($user->id);
        $result = $this->employeeJournal->whereDate($employee->id, Carbon::today());

        if ($result) {
            return ResponseHelper::error('Jurnal anda hari ini sudah tersedia', 500);
        }


        $data = $this->journalService->store_api($request, $user);
        $this->employeeJournal->store($data);
        return ResponseHelper::success(null, 'Data Berhasil di Tambahkan');
    }

    public function update_journal($journalId, Request $request)
    {
        $journal = $this->employeeJournal->show($journalId);

        if (!$journal) {
            return ResponseHelper::error('Jurnal tidak ditemukan', 404);
        }

        // Only allow editing today's journal
        if (!Carbon::parse($journal->created_at)->isToday()) {
            return ResponseHelper::error('Hanya bisa mengedit jurnal hari ini', 403);
        }

        $description = preg_replace('/\s+/', '', $request->input('description'));
        if (strlen($description) < 10) {
            return ResponseHelper::error('Deskripsi minimal harus 10 karakter tanpa spasi', 400);
        }

        $this->employeeJournal->update($journalId, [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return ResponseHelper::success(null, 'Data Berhasil di Update');
    }

    public function overview_header()
    {
        try {
            $student_violation = $this->studentViolation->countByStudent();
            $maxPoint = $this->schoolPoint->getMaxPoint();
            $studentHighPoint = $this->student->highestPoint($maxPoint);

            $countViolation = $this->studentViolation->count('week');
            $countRepair = $this->studentRepair->count();

            return ResponseHelper::success([
                'student_violation' => $student_violation,
                'student_high_point' => $studentHighPoint,
                'violation_in_week' => $countViolation,
                'repair_in_week' => $countRepair,
            ]);
        } catch (\Throwable $th) {
            return ResponseHelper::error('Data Kosong', 400);
        }
    }

    public function max_point()
    {
        try {
            $maxPoint = $this->schoolPoint->getMaxPoint();
            return ResponseHelper::success(['max_point' => $maxPoint]);
        } catch (\Throwable $th) {
            return ResponseHelper::error('Data Kosong', 400);
        }
    }

    public function list_violation()
    {
        try {
            $regulations = $this->regulation->latest();
            return ResponseHelper::success(RegulationResource::collection($regulations));
        } catch (\Throwable $th) {
            return ResponseHelper::error('Data Kosong', 400);
        }
    }

    public function list_repair()
    {
        try {
            $data = $this->studentRepair->groupByClassroomStudentAndCreated();
            return ResponseHelper::success($data->mapWithKeys(function ($dateGroup, $date) {
                $formattedDate = Carbon::parse($date)->translatedFormat('j F Y');
                return [
                    $formattedDate => $dateGroup->map(function ($classroomGroup, $classroomStudentId) {
                        $totalPoints = $classroomGroup->sum('point');
                        $studentName = optional($classroomGroup->first())->classroomStudent()->latest()->first()->student->user->name;

                        return [
                            'name' => $studentName,
                            'total_points' => $totalPoints,
                            'data' => RepairStudentResource::collection($classroomGroup),
                        ];
                    })
                ];
            }));
        } catch (\Throwable $th) {
            return ResponseHelper::error('Data Kosong', 400);
        }
    }

    public function list_point_student(Request $request)
    {
        try {
            $students = $this->student->getByApi($request);
            return ResponseHelper::success(StudentPointResource::collection($students));
        } catch (\Throwable $th) {
            return ResponseHelper::error('Data Kosong', 400);
        }
    }

    public function popular_violations()
    {
        try {
            $popular_violations = $this->regulation->getOrderApi();
            return ResponseHelper::success(PopularViolationResource::collection($popular_violations));
        } catch (\Throwable $th) {
            return ResponseHelper::error('Data Kosong', 400);
        }
    }

    public function student_permissions(Request $request)
    {
        try {
            $attendances = $this->attendance->getSickAndPermit($request, [AttendanceEnum::SICK->value, AttendanceEnum::PERMIT->value]);
            return ResponseHelper::success(['permissions' => StudentPermissionResource::collection($attendances)]);
        } catch (\Throwable $th) {
            return ResponseHelper::error('Data Kosong' . $th->getMessage(), 400);
        }
    }

    public function statistic_violation()
    {
        try {
            $charts = $this->chartService->violationChart();
            return ResponseHelper::success(['violations' => $charts]);
        } catch (\Throwable $th) {
            return ResponseHelper::error('Data Kosong' . $th->getMessage(), 400);
        }
    }

    public function get_config()
    {
        return ResponseHelper::success([
            'school' => config('attendance.school'),
            'time' => config('attendance.time'),
        ]);
    }

    public function attendance_history(User $user)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }

        $employee = $this->employee->getByUser($user->id);
        if (!$employee) {
            return ResponseHelper::notFound('Data pegawai tidak ditemukan');
        }

        $history_attendance = $this->attendance->whereUser($employee->id, 'App\Models\Employee');
        $single_attendance = $this->attendance->userToday('App\Models\Employee', $employee->id);

        // Get today's permission if any
        $todayPermission = EmployeePermission::where('employee_id', $employee->id)
            ->where('date', now()->format('Y-m-d'))
            ->where('status', StatusPermissionEnum::APPROVED)
            ->first();

        $timeConfig = config('attendance.time');
        $currentTime = now()->format('H:i');

        $statusLabel = 'Belum Absen';
        if ($single_attendance) {
            $statusLabel = $single_attendance->status->label();
        } elseif ($todayPermission) {
            $statusLabel = $todayPermission->permission_type->label();
        } elseif ($currentTime > $timeConfig['late_limit']) {
            $statusLabel = 'Alpha';

            // Inject virtual Alpha to history
            $virtualAlpha = new Attendance();
            $virtualAlpha->status = AttendanceEnum::ALPHA;
            $virtualAlpha->created_at = now();

            if ($history_attendance instanceof \Illuminate\Support\Collection) {
                $history_attendance->prepend($virtualAlpha);
            } else {
                $history_attendance = collect($history_attendance)->prepend($virtualAlpha);
            }
        }

        return ResponseHelper::success([
            'attendance_now' => [
                'day' => now()->translatedFormat('l'),
                'date' => now()->translatedFormat('d'),
                'month' => now()->translatedFormat('M'),
                'date_complate' => now()->translatedFormat('l, j F Y'),
                'check_in' => $single_attendance ? ($single_attendance->checkin ? Carbon::parse($single_attendance->checkin)->format('H:i') : '-') : '-',
                'check_out' => $single_attendance ? ($single_attendance->checkout ? Carbon::parse($single_attendance->checkout)->format('H:i') : '-') : '-',
                'status' => $statusLabel,
                'is_late' => $single_attendance ? ($single_attendance->status == \App\Enums\AttendanceEnum::LATE) : false,
            ],
            'attendance_history' => $history_attendance->count() > 0 ? HistoryAttendanceResource::collection($history_attendance) : [],
        ]);
    }

    public function check_in(Request $request)
    {
        $user = auth()->user();
        $employee = $this->employee->getByUser($user->id);

        if (!$employee) {
            return ResponseHelper::notFound('Data pegawai tidak ditemukan');
        }

        $today = $this->attendance->userToday('App\Models\Employee', $employee->id);
        if ($today) {
            return ResponseHelper::error('Anda sudah absen masuk hari ini', 400);
        }

        // Check if past late limit
        $timeConfig = config('attendance.time');
        $currentTime = now()->format('H:i');
        if ($currentTime > $timeConfig['late_limit']) {
            return ResponseHelper::error('Batas waktu absensi telah berakhir (Jam ' . $timeConfig['late_limit'] . '). Silakan ajukan izin.', 422);
        }

        // Rule: Late if after config time
        $checkInEnd = config('attendance.time.check_in_end', '07:30');

        $status = AttendanceEnum::PRESENT;
        if ($currentTime > $checkInEnd) {
            $status = AttendanceEnum::LATE;
        }

        $data = [
            'model_type' => 'App\Models\Employee',
            'model_id' => $employee->id,
            'checkin' => now(),
            'status' => $status->value,
            'point' => 0,
            'proof' => null,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'location_address' => $request->address,
            'created_at' => now(),
            'updated_at' => now()
        ];

        $this->attendance->insert($data);

        return ResponseHelper::success(null, 'Absen masuk berhasil' . ($status == AttendanceEnum::LATE ? ' (Terlambat)' : ''));
    }

    public function check_out(Request $request)
    {
        $user = auth()->user();
        $employee = $this->employee->getByUser($user->id);

        if (!$employee) {
            return ResponseHelper::notFound('Data pegawai tidak ditemukan');
        }

        $today = $this->attendance->userToday('App\Models\Employee', $employee->id);
        if (!$today) {
            return ResponseHelper::error('Anda belum absen masuk hari ini', 400);
        }

        if ($today->checkout) {
            return ResponseHelper::error('Anda sudah absen pulang hari ini', 400);
        }

        // Check if within checkout time window
        $checkOutStart = config('attendance.time.check_out_start', '14:00');
        $checkOutEnd = config('attendance.time.check_out_end', '22:00');
        $currentTime = now()->format('H:i');

        if ($currentTime < $checkOutStart) {
            return ResponseHelper::error("Belum waktunya checkout. Checkout dimulai jam {$checkOutStart}.", 400);
        }

        if ($currentTime > $checkOutEnd) {
            return ResponseHelper::error("Waktu checkout sudah berakhir. Batas maksimal jam {$checkOutEnd}.", 400);
        }

        $this->attendance->update($today->id, [
            'checkout' => now(),
        ]);

        return ResponseHelper::success(null, 'Absen pulang berhasil');
    }
}
