<?php

namespace App\Enums;

enum ReportTypeEnum: string
{
    case TYPE_OVERVIEW = 'overview';
    case TYPE_WARNING = 'warning';
    case TYPE_NOT_ASSIGNED = 'not_assigned';

    public static function isValid(string $type): bool
    {
        return in_array($type, self::values());
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
