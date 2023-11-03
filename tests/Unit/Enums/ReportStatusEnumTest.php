<?php

namespace Enums;

use App\Enums\ReportStatusEnum;
use PHPUnit\Framework\TestCase;

class ReportStatusEnumTest extends TestCase
{
    public function testValues()
    {
        $this->assertEquals(
            ['new', 'scheduled', 'deadline'],
            ReportStatusEnum::values()
        );
    }
}
