<?php

namespace App\Enums;

enum RoleEnum: string
{
    case STUDENT = "student";
    case TEACHER = "teacher";
    case SCHOOL = "school";
    case STAFF = "staff";
    case PARENT = "parent";
    case EXTRACURRICULAR = "extracurricular";
}
