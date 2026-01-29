<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RfidResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image = null;
        if ($this->model && $this->model->image) {
            $image = request()->root() . '/storage/' . $this->model->image;
        }

        return [
            'id' => $this->id,
            'rfid' => $this->rfid,
            'classroom' => $this->model_type == 'App\Models\Student' ? $this->model->classroomStudents->sortByDesc('school_year_id')->first()?->classroom->name : null,
            'name' => $this->model_type ? $this->model->user->name : null,
            'type' => 'student',
            'image' => $image,
        ];
    }
}
