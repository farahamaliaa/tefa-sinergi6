<?php

namespace App\Models;

use App\Enums\PermissionTypeEnum;
use App\Enums\StatusPermissionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePermission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'permission_type' => PermissionTypeEnum::class,
        'status' => StatusPermissionEnum::class,
        'date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
