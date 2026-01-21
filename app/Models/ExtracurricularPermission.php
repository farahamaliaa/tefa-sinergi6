<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtracurricularPermission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the extracurricular that owns the permission.
     */
    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }

    /**
     * Get the extracurricular student that owns the permission.
     */
    public function extracurricularStudent()
    {
        return $this->belongsTo(ExtracurricularStudent::class);
    }

    /**
     * Get the schedule associated with the permission.
     */
    public function schedule()
    {
        return $this->belongsTo(ExtracurricularSchedule::class, 'schedule_id');
    }

    /**
     * Check if permission is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if permission is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}
