<?php
namespace App\Enums;

enum PermissionTypeEnum: string
{
    case SICK = "sick";
    case PERMIT = "permit";
    case DINAS = "dinas";
    case OTHER = "other";

    public function label(): string
    {
        return match ($this) {
            self::SICK => 'Sakit',
            self::PERMIT => 'Izin',
            self::DINAS => 'Dinas Luar',
            self::OTHER => 'Lainnya',
        };
    }
}