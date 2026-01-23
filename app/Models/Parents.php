<?php

namespace App\Models;

use App\Traits\Models\BelongsToManyStudent;
use App\Traits\Models\BelongsToUser;
use App\Traits\Models\HasManyStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory, BelongsToUser, BelongsToManyStudent; //BelongsToManyStudents entah kenapa trait error
    protected $fillable = [
        'user_id',
        'name',
        'phone_number',
        'address',
        'image'
    ];
}
