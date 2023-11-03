<?php

namespace Traits;

use App\Traits\ReportTypeProcessingTrait;
use PHPUnit\Framework\TestCase;

class ReportTypeProcessingTraitTest extends TestCase
{
    public function testSelectType(string $description = 'test', string $expected = 'warning')
    {
        $message = [
            'number' => '1',
            'phone' => '123456789',
            'description' => $description,
            'dueDate' => '2023-01-01 00:00:00',
        ];

        $reportPriorityProcessingTrait = $this->getMockForTrait(ReportTypeProcessingTrait::class);
        $result = $reportPriorityProcessingTrait->selectType($message);

        $this->assertEquals($expected, $result);
    }

    public function testIsWarningType()
    {
        $this->testSelectType('pilne', 'warning');
    }

    public function testIsOverviewType()
    {
        $this->testSelectType('Bardzo pilne. Prosze się nie śmiać, potrzebny przegląd', 'overview');
    }
}
