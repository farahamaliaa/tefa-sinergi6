<?php

namespace App\Models;

use App\Traits\Models\BelongsToStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMembership extends Model
{
    use HasFactory, BelongsToStudent;

    protected $fillable = ['student_id', 'memberable_id', 'memberable_type'];

    public function memberable()
    {
        return $this->morphTo();
    }
}
