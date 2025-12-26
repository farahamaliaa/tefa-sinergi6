<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtracurricularAttendance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the journal that owns the attendance.
     */
    public function journal()
    {
        return $this->belongsTo(ExtracurricularJournal::class, 'extracurricular_journal_id');
    }

    /**
     * Get the extracurricular student.
     */
    public function extracurricularStudent()
    {
        return $this->belongsTo(ExtracurricularStudent::class);
    }
}
