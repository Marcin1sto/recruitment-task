<?php

namespace Model;

use App\Models\WarningReport;
use PHPUnit\Framework\TestCase;

class WarningReportTest extends TestCase
{
    private WarningReport $warningReportModel;

    public function setUp(): void
    {
        $this->warningReportModel = new WarningReport();
    }

    // test Construct method
    public function testConstruct(): void
    {
        $this->assertInstanceOf(\DateTime::class, $this->warningReportModel->getCreationDate());
    }

    public function testDescriptionParam(): void
    {
        $this->warningReportModel->setDescription('test');
        $this->assertEquals('test', $this->warningReportModel->getDescription());
    }

    public function testTypeParam(): void
    {
        $this->warningReportModel->setType('test');
        $this->assertEquals('test', $this->warningReportModel->getType());
    }

    public function testVisitDateParam(): void
    {
        $this->warningReportModel->setVisitDate('2021-01-01 00:00:00');
        $this->assertEquals('2021-01-01', $this->warningReportModel->getVisitDate());
    }

    public function testStatusParam(): void
    {
        $this->warningReportModel->setStatus('test');
        $this->assertEquals('test', $this->warningReportModel->getStatus());
    }

    public function testServiceNotesParam(): void
    {
        $this->warningReportModel->setServiceNotes('test');
        $this->assertEquals('test', $this->warningReportModel->getServiceNotes());
    }

    public function testContactNumberParam(): void
    {
        $this->warningReportModel->setContactNumber('test');
        $this->assertEquals('test', $this->warningReportModel->getContactNumber());
    }

    public function testCreationDateParam(): void
    {
        $this->warningReportModel->setCreationDate(new \DateTime('2021-01-01'));
        $this->assertEquals(new \DateTime('2021-01-01'), $this->warningReportModel->getCreationDate());
    }
}
