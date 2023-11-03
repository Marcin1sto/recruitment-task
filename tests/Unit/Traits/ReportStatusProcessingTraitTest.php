<?php

namespace Traits;

use App\Interfaces\ReportInterface;
use App\Traits\ReportStatusProcessingTrait;
use PHPUnit\Framework\TestCase;

class ReportStatusProcessingTraitTest extends TestCase
{
    public function testSelectStatus(string $type = 'overview', ?string $visitDate = null, string $expected = 'new')
    {
        $report = $this->createMock(ReportInterface::class);
        $report->method('getType')->willReturn($type);
        $report->method('getVisitDate')->willReturn($visitDate);

        $reportPriorityProcessingTrait = $this->getMockForTrait(ReportStatusProcessingTrait::class);
        $result = $reportPriorityProcessingTrait->selectStatus($report);

        $this->assertEquals($expected, $result);
    }

    public function testIsScheduledStatus()
    {
        $this->testSelectStatus('overview', '2023-01-01', 'scheduled');
    }

    public function testIsDeadlineStatus()
    {
        $this->testSelectStatus('warning', '2023-01-01', 'deadline');
    }
}
