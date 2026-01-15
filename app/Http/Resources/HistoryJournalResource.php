<?php

namespace App\Http\Resources;

use App\Enums\AttendanceEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryJournalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->lesson_schedule_id,
            'subject' => $this->lessonSchedule->teacherSubject->subject->name,
            'subject_name' => $this->lessonSchedule->teacherSubject->subject->name,
            'classroom' => $this->lessonSchedule->classroom->name,
            'class_name' => $this->lessonSchedule->classroom->name,
            'title' => $this->title,
            'description' => $this->description,
            'date' => Carbon::parse($this->date)->translatedFormat('d F'),
            'year' => Carbon::parse($this->date)->format('Y'),
            'date_full' => $this->date,
            'status' => 'filled',
            'count_alpha' => $this->attendanceJournals->where('status', AttendanceEnum::ALPHA)->count(),
            'count_sick' => $this->attendanceJournals->where('status', AttendanceEnum::SICK)->count(),
            'count_permit' => $this->attendanceJournals->where('status', AttendanceEnum::PERMIT)->count(),
            'count_present' => $this->attendanceJournals->where('status', AttendanceEnum::PRESENT)->count(),
            'attendance' => [
                'present' => $this->attendanceJournals->where('status', AttendanceEnum::PRESENT)->count(),
                'sick' => $this->attendanceJournals->where('status', AttendanceEnum::SICK)->count(),
                'alpha' => $this->attendanceJournals->where('status', AttendanceEnum::ALPHA)->count(),
                'permit' => $this->attendanceJournals->where('status', AttendanceEnum::PERMIT)->count(),
            ],
        ];
    }
}
