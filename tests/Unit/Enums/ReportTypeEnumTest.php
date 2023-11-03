<?php

namespace Enums;

use App\Enums\ReportTypeEnum;
use PHPUnit\Framework\TestCase;

class ReportTypeEnumTest extends TestCase
{
    public function testValues()
    {
        $this->assertEquals(
            ['overview', 'warning', 'not_assigned'],
            ReportTypeEnum::values()
        );
    }

    public function testIsValid()
    {
        $this->assertTrue(ReportTypeEnum::isValid('overview'));
        $this->assertTrue(ReportTypeEnum::isValid('warning'));
        $this->assertTrue(ReportTypeEnum::isValid('not_assigned'));
        $this->assertFalse(ReportTypeEnum::isValid('invalid'));
    }
}
