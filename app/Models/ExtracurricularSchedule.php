<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtracurricularSchedule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the extracurricular that owns the schedule.
     */
    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }
}
