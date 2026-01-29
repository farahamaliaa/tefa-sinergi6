<?php
namespace App\Enums;

enum StatusPermissionEnum: string
{
    case PENDING = "pending";
    case APPROVED = "approved";
    case REJECTED = "rejected";

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Disetujui',
            self::REJECTED => 'Ditolak',
        };
    }
}
