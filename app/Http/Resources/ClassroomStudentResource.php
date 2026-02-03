<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $fullDomain = request()->root();
        $student = $this->student;

        // Handle case where student might be null
        if (!$student) {
            return [
                'id' => $this->id,
                'student_id' => null,
                'error' => 'Student data not found',
            ];
        }

        return [
            // IDs
            'id' => $this->id,
            'student_id' => $student->id,
            'user_id' => $student->user_id,

            // Basic Information
            'name' => optional($student->user)->name,
            'email' => optional($student->user)->email,
            'nisn' => $student->nisn,
            'nik' => $student->nik,
            'image' => $student->image
                ? asset('storage/' . $student->image)
                : asset('admin_assets/dist/images/profile/user-1.jpg'),
            'image_path' => $student->image,

            // Personal Information
            'gender' => $student->gender?->value ?? null,
            'gender_label' => $student->gender ? $student->gender->label() : null,
            'religion_id' => $student->religion_id,
            'religion_name' => optional($student->religion)->name,
            'birth_date' => $student->birth_date,
            'birth_date_formatted' => $student->birth_date
                ? \Carbon\Carbon::parse($student->birth_date)->format('d-m-Y')
                : null,
            'birth_place' => $student->birth_place,

            // Identity Documents
            'number_kk' => $student->number_kk,
            'number_akta' => $student->number_akta,

            // Family Information
            'order_child' => $student->order_child,
            'count_siblings' => $student->count_siblings,

            // Address
            'address' => $student->address,

            // Academic Information
            'point' => $student->point ?? 0,
            'classroom_id' => $this->classroom_id,
            'classroom_name' => optional($this->classroom)->name,
            'attendance_status_today' => $this->resource->prefilled_status ?? null,
        ];
    }
}
