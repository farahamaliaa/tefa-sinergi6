<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Traits\Models\BelongsToReligion;
use App\Traits\Models\BelongsToSchool;
use App\Traits\Models\BelongsToUser;
use App\Traits\Models\MorphManyRfid;
use App\Traits\Models\BelongToParent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, BelongsToUser, BelongsToReligion, MorphManyRfid, BelongToParent;

    protected $guarded = ['id'];

    protected $casts = [
        'gender' => GenderEnum::class,
    ];

    public function memberships()
    {
        return $this->hasMany(StudentMembership::class);
    }

    public function classrooms()
    {
        return $this->morphedByMany(Classroom::class, 'memberable', 'student_memberships');
    }

    public function extracurriculars()
    {
        return $this->morphedByMany(Extracurricular::class, 'memberable', 'student_memberships');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
