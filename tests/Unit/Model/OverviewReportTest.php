<?php

namespace Model;

use App\Models\OverviewReport;
use PHPUnit\Framework\TestCase;

class OverviewReportTest extends TestCase
{
    private OverviewReport $overviewReportModel;

    public function setUp(): void
    {
        $this->overviewReportModel = new OverviewReport();
    }

    // test Construct method
    public function testConstruct(): void
    {
        $this->assertInstanceOf(\DateTime::class, $this->overviewReportModel->getCreationDate());
    }

    public function testDescriptionParam(): void
    {
        $this->overviewReportModel->setDescription('test');
        $this->assertEquals('test', $this->overviewReportModel->getDescription());
    }

    public function testTypeParam(): void
    {
        $this->overviewReportModel->setType('test');
        $this->assertEquals('test', $this->overviewReportModel->getType());
    }

    public function testVisitDateParam(): void
    {
        $this->overviewReportModel->setVisitDate('2021-01-01 00:00:00');
        $this->assertEquals('2021-01-01', $this->overviewReportModel->getVisitDate());
    }

    public function testStatusParam(): void
    {
        $this->overviewReportModel->setStatus('test');
        $this->assertEquals('test', $this->overviewReportModel->getStatus());
    }

    public function testRecommendationsParam(): void
    {
        $this->overviewReportModel->setRecommendations('test');
        $this->assertEquals('test', $this->overviewReportModel->getRecommendations());
    }

    public function testContactNumberParam(): void
    {
        $this->overviewReportModel->setContactNumber('test');
        $this->assertEquals('test', $this->overviewReportModel->getContactNumber());
    }

    public function testCreationDateParam(): void
    {
        $this->overviewReportModel->setCreationDate(new \DateTime('2021-01-01'));
        $this->assertEquals(new \DateTime('2021-01-01'), $this->overviewReportModel->getCreationDate());
    }

    public function testWeekInTheYearParam(): void
    {
        $this->overviewReportModel->visitDate = '2021-01-01 00:00:00';
        $this->overviewReportModel->setWeekInTheYear();
        $this->assertEquals('53', $this->overviewReportModel->getWeekInTheYear());

        $this->overviewReportModel->visitDate = '2021-01-08 00:00:00';
        $this->overviewReportModel->setWeekInTheYear();
        $this->assertEquals('01', $this->overviewReportModel->getWeekInTheYear());
    }
}
