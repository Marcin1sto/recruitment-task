<?php

namespace App\Enums;

enum ReportPriorityEnum: string
{
    case PRIORITY_NORMAL = 'normal';
    case PRIORITY_HIGH = 'high';
    case PRIORITY_CRITICAL = 'critical';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
