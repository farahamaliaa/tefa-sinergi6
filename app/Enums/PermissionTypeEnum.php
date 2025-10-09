<?php
namespace App\Enums;

enum PermissionTypeEnum: string
{
    case SICK = "sick";
    case PERMIT = "permit";
    case OTHER = "other";
}