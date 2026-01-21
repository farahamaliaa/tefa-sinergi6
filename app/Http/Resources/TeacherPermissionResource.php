<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherPermissionResource extends JsonResource
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
            'student' => [
                'id' => $this->student->id ?? null,
                'name' => $this->student->user->name ?? 'Unknown',
                'nis' => $this->student->nis ?? null,
                'avatar' => $this->student->image 
                    ? asset('storage/' . $this->student->image) 
                    : asset('admin_assets/dist/images/profile/user-1.jpg'),
            ],
            'classroom' => $this->classroom ? [
                'id' => $this->classroom->id,
                'name' => $this->classroom->name,
            ] : null,
            'permission_type' => $this->permission_type,
            'permission_type_label' => $this->getPermissionTypeLabel($this->permission_type),
            'proof' => $this->proof,
            'proof_image' => $this->proof_image 
                ? asset('storage/' . $this->proof_image) 
                : null,
            'date' => Carbon::parse($this->date)->translatedFormat('d F Y'),
            'status' => $this->status,
            'status_label' => $this->getStatusLabel($this->status),
            'submitted_by' => $this->submittedBy ? [
                'id' => $this->submittedBy->id,
                'name' => $this->submittedBy->name,
            ] : null,
            'approved_by' => $this->approvedBy ? [
                'id' => $this->approvedBy->id,
                'name' => $this->approvedBy->name,
            ] : null,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y H:i'),
        ];
    }

    /**
     * Get permission type label
     */
    private function getPermissionTypeLabel($type): string
    {
        $types = [
            'sick' => 'Sakit',
            'permit' => 'Izin',
            'other' => 'Lainnya',
        ];

        return $types[$type] ?? $type;
    }

    /**
     * Get status label
     */
    private function getStatusLabel($status): string
    {
        $statuses = [
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
        ];

        return $statuses[$status] ?? $status;
    }
}
