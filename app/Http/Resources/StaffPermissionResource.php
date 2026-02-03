<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffPermissionResource extends JsonResource
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
            'name' => $this->employee?->user?->name ?? '-',
            'email' => $this->employee?->user?->email ?? '-',
            'gender' => $this->employee?->gender?->label() ?? '-',
            'position' => $this->employee?->position ?? '-',
            'date' => $this->date ? Carbon::parse($this->date)->translatedFormat('d F Y') : '-',
            'permission_type' => $this->permission_type?->value ?? 'permit',
            'duration' => $this->duration ?? '-',
            'status' => $this->status?->value ?? 'pending',
            'status_label' => $this->status?->label() ?? 'Pending',
            'proof' => $this->proof ?? '-',
            'proof_image' => $this->proof_image ? url('storage/' . $this->proof_image) : null,
            'created_at' => $this->created_at,
        ];
    }
}
