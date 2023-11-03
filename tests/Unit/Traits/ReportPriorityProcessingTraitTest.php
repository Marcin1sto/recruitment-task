<?php

namespace Traits;

use App\Interfaces\ReportInterface;
use App\Traits\ReportPriorityProcessingTrait;
use PHPUnit\Framework\TestCase;

class ReportPriorityProcessingTraitTest extends TestCase
{
    public function testSelectPriority(string $description = 'test', string $expected = 'normal')
    {
        $report = $this->createMock(ReportInterface::class);
        $report->method('getDescription')->willReturn($description);

        $reportPriorityProcessingTrait = $this->getMockForTrait(ReportPriorityProcessingTrait::class);
        $result = $reportPriorityProcessingTrait->selectPriority($report);

        $this->assertEquals($expected, $result);
    }

    public function testIsHighPriority()
    {
        $this->testSelectPriority('pilne', 'high');
    }


    public function testIsCriticalPriority()
    {
        $this->testSelectPriority('bardzo pilne', 'critical');
    }
}
