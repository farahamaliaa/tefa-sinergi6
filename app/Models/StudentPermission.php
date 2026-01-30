<?php

namespace App\Models;

use App\Traits\Models\BelongsToClassroom;
use App\Traits\Models\BelongsToStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPermission extends Model
{
    use HasFactory, BelongsToStudent, BelongsToClassroom;
    protected $fillable = [
        'student_id',
        'classroom_id',
        'permission_type',
        'proof',
        'proof_image',
        'submitted_by',
        'approved_by',
        'status',
        'date',
        'duration',
    ];
    
    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }    
}
