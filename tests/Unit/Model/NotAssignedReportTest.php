<?php

namespace Model;

use App\Models\NotAssignedReport;
use PHPUnit\Framework\TestCase;

class NotAssignedReportTest extends TestCase
{
    private NotAssignedReport $notAssignedReportModel;

    public function setUp(): void
    {
        $this->notAssignedReportModel = new NotAssignedReport();
    }

    // test Construct method
    public function testConstruct(): void
    {
        $this->assertInstanceOf(\DateTime::class, $this->notAssignedReportModel->creationDate);
    }

    public function testDescriptionParam(): void
    {
        $this->notAssignedReportModel->setDescription('test');
        $this->assertEquals('test', $this->notAssignedReportModel->getDescription());
    }

    public function testTypeParam(): void
    {
        $this->notAssignedReportModel->setType('test');
        $this->assertEquals('test', $this->notAssignedReportModel->getType());
    }

    public function testVisitDateParam(): void
    {
        $this->notAssignedReportModel->setVisitDate('2021-01-01 00:00:00');
        $this->assertEquals('2021-01-01', $this->notAssignedReportModel->getVisitDate());
    }

    public function testStatusParam(): void
    {
        $this->notAssignedReportModel->setStatus('test');
        $this->assertEquals('test', $this->notAssignedReportModel->getStatus());
    }

    public function testRecommendationsParam(): void
    {
        $this->notAssignedReportModel->setRecommendations('test');
        $this->assertEquals('test', $this->notAssignedReportModel->getRecommendations());
    }

    public function testContactNumberParam(): void
    {
        $this->notAssignedReportModel->setContactNumber('test');
        $this->assertEquals('test', $this->notAssignedReportModel->getContactNumber());
    }

    public function testCreationDateParam(): void
    {
        $this->notAssignedReportModel->setCreationDate(new \DateTime('2021-01-01'));
        $this->assertEquals(new \DateTime('2021-01-01'), $this->notAssignedReportModel->getCreationDate());
    }
}
