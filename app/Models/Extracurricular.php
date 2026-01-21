<?php

namespace App\Models;

use App\Traits\Models\BelongsToEmployee;
use App\Traits\Models\BelongsToSchool;
use App\Traits\Models\HasManyExtracurricularStudent;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    use HasFactory, HasUuids, BelongsToEmployee, HasManyExtracurricularStudent;

    protected $guarded = ['id'];

    public $incrementing = false;
    public $keyType = 'char';

    /**
     * Get the schedules for the extracurricular.
     */
    public function schedules()
    {
        return $this->hasMany(ExtracurricularSchedule::class);
    }

    /**
     * Get the journals for the extracurricular.
     */
    public function journals()
    {
        return $this->hasMany(ExtracurricularJournal::class);
    }
}
