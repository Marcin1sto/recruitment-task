<?php

namespace App\Enums;

enum ReportStatusEnum: string
{
    case STATUS_NEW = 'new';
    case STATUS_SCHEDULED = 'scheduled';
    case STATUS_DEADLINE = 'deadline';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
