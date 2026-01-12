<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeeklyScheduleResource extends JsonResource
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
            'day' => $this->day,
            'day_name' => $this->getDayName($this->day),
            'classroom' => $this->classroom ? [
                'id' => $this->classroom->id,
                'name' => $this->classroom->name,
            ] : null,
            'subject' => $this->teacherSubject && $this->teacherSubject->subject ? [
                'id' => $this->teacherSubject->subject->id,
                'name' => $this->teacherSubject->subject->name,
            ] : null,
            
            // Time information
            'start_time' => $this->start ? $this->start->start : null,
            'end_time' => $this->end ? $this->end->end : null,
            'hour' => $this->start && $this->end 
                ? \Carbon\Carbon::parse($this->start->start)->format('H:i') . ' - ' . \Carbon\Carbon::parse($this->end->end)->format('H:i')
                : null,
            
            // Lesson hour numbers (Jam ke-X sampai Y)
            'lesson_hour_start' => $this->lesson_hour_start,
            'lesson_hour_end' => $this->lesson_hour_end,
            'lesson_hour_label' => $this->lesson_hour_start && $this->lesson_hour_end
                ? 'Jam ke-' . $this->getHourNumber($this->start) . ' - ' . $this->getHourNumber($this->end)
                : null,
            'time' => $this->start && $this->end && $this->start->name && $this->end->name
                ? $this->extractHourNumber($this->start->name) . ' - ' . $this->extractHourNumber($this->end->name)
                : null,
        ];
    }

    /**
     * Get day name from day value
     */
    private function getDayName($day): string
    {
        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        return $days[$day] ?? $day;
    }

    /**
     * Get hour number from LessonHour model
     */
    private function getHourNumber($lessonHour): string
    {
        if (!$lessonHour) {
            return '';
        }
        
        // Extract hour number from the name (e.g., "Jam - 1" -> "1")
        if ($lessonHour->name) {
            return $this->extractHourNumber($lessonHour->name);
        }
        
        return (string) $lessonHour->id;
    }

    /**
     * Extract hour number from lesson hour name
     * e.g., "Jam - 1" -> "1"
     */
    private function extractHourNumber($name): string
    {
        if (!$name) {
            return '';
        }
        
        // Try to extract number from name like "Jam - 1"
        if (preg_match('/(\d+)/', $name, $matches)) {
            return $matches[1];
        }
        
        return $name;
    }
}
