<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtracurricularJournal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the extracurricular that owns the journal.
     */
    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }

    /**
     * Get the schedule associated with the journal.
     */
    public function schedule()
    {
        return $this->belongsTo(ExtracurricularSchedule::class, 'schedule_id');
    }

    /**
     * Get the attendances for the journal.
     */
    public function attendances()
    {
        return $this->hasMany(ExtracurricularAttendance::class);
    }
}
