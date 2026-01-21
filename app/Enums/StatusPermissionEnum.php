<?php
namespace App\Enums;

enum StatusPermissionEnum: string
{
    case PENDING = "pending";
    case APPROVED = "approved";
    case REJECTED = "rejected";
}