<?php

namespace App\Traits\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait BelongsToManyStudent {
    /**
     * The Student that belong to the BelongToManyStudents
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'parent_students', 'parent_id', 'student_id');
    }
}
