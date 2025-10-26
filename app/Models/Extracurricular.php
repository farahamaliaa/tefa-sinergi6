<?php

namespace App\Models;

use App\Traits\Models\BelongsToEmployee;
use App\Traits\Models\BelongsToSchool;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    use HasFactory, BelongsToEmployee;

    protected $guarded = ['id'];

    public $incrementing = false;
    public $keyType = 'char';

    public function students()
    {
        return $this->morphToMany(Student::class, 'memberable', 'student_memberships');
    }

    public function memberships()
    {
        return $this->morphMany(StudentMembership::class, 'memberable');
    }    

}