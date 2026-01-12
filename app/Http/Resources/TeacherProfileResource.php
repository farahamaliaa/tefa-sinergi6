<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $employee = $this->employee;
        $classroom = $employee ? $employee->classroom : null;
        $teacherSubjects = $employee ? $employee->teacherSubjects : collect();
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $employee && $employee->image 
                ? asset('storage/' . $employee->image) 
                : asset('admin_assets/dist/images/profile/user-1.jpg'),
            'nip' => $employee ? $employee->nip : null,
            'phone' => $employee ? $employee->phone : null,
            'address' => $employee ? $employee->address : null,
            'gender' => $employee ? $employee->gender : null,
            'position' => $employee && $employee->employeePosition 
                ? $employee->employeePosition->name 
                : null,
            'subjects' => $teacherSubjects->map(function ($ts) {
                return [
                    'id' => $ts->id,
                    'name' => $ts->subject ? $ts->subject->name : null,
                ];
            }),
            'is_homeroom' => $classroom ? true : false,
            'homeroom_class' => $classroom ? [
                'id' => $classroom->id,
                'name' => $classroom->name,
            ] : null,
        ];
    }
}
