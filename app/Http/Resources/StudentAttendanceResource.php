<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentAttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student_name' => $this->model->student->user->name ?? 'Unknown',
            'student_avatar' => $this->model->student->image 
                ? asset('storage/' . $this->model->student->image) 
                : asset('admin_assets/dist/images/profile/user-1.jpg'),
            'nis' => $this->model->student->nis ?? null,
            'classroom' => $this->model->classroom->name ?? null,
            'date' => Carbon::parse($this->created_at)->translatedFormat('d F Y'),
            'check_in' => $this->checkin ? Carbon::parse($this->checkin)->format('H:i') : '-',
            'check_out' => $this->checkout ? Carbon::parse($this->checkout)->format('H:i') : '-',
            'status' => $this->status ? $this->status->label() : 'Unknown',
        ];
    }
}
