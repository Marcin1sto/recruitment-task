<?php

namespace Enums;

use App\Enums\ReportPriorityEnum;
use PHPUnit\Framework\TestCase;

class ReportPriorityEnumTest extends TestCase
{
    public function testValues()
    {
        $this->assertEquals(
            ['normal', 'high', 'critical'],
            ReportPriorityEnum::values()
        );
    }
}
