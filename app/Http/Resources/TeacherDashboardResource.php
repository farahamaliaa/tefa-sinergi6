<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherDashboardResource extends JsonResource
{
    protected $classroom;
    protected $pendingPermissions;
    protected $todaySchedules;

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @param mixed $classroom
     * @param int $pendingPermissions
     * @param int $todaySchedules
     */
    public function __construct($resource, $classroom = null, $pendingPermissions = 0, $todaySchedules = 0)
    {
        parent::__construct($resource);
        $this->classroom = $classroom;
        $this->pendingPermissions = $pendingPermissions;
        $this->todaySchedules = $todaySchedules;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $employee = $this->employee;
        
        return [
            'teacher_name' => $this->name,
            'avatar' => $employee && $employee->image 
                ? asset('storage/' . $employee->image) 
                : asset('admin_assets/dist/images/profile/user-1.jpg'),
            'is_homeroom' => $this->classroom ? true : false,
            'homeroom_class' => $this->classroom ? [
                'id' => $this->classroom->id,
                'name' => $this->classroom->name,
                'student_count' => $this->classroom->classroomStudents()->count(),
            ] : null,
            'pending_permissions' => $this->pendingPermissions,
            'today_schedules' => $this->todaySchedules,
            'today' => Carbon::now()->translatedFormat('l, d F Y'),
        ];
    }
}
