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
use App\Http\Resources\PopularViolationResource;
use App\Http\Resources\RegulationResource;
use App\Http\Resources\RepairStudentResource;
use App\Http\Resources\StudentPermissionResource;
use App\Http\Resources\StudentPointResource;
use App\Models\User;
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
}
