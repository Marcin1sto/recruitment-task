<?php

namespace Services;

use App\Interfaces\ReportInterface;
use App\Services\ReportModelService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ReportModelServiceTest extends TestCase
{
    private ReportModelService $reportModelService;

    private array $message = [
        'phone' => '123456789',
        'dueDate' => '2021-01-01',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
    ];

    protected function setUp(): void
    {
        $this->reportModelService = new ReportModelService();
    }

    public function testCreateModel()
    {
        $data = [
            'phone' => '123456789',
            'dueDate' => '2021-01-01',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ];

        $model = $this->reportModelService->createModel($data, 'warning');

        $this->assertEquals('123456789', $model->getContactNumber());
        $this->assertEquals('2021-01-01', $model->getVisitDate());
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', $model->getDescription());
        $this->assertEquals('warning', $model->getType());

        if (method_exists($model, 'setPriority') && method_exists($model, 'getPriority')) {
            $this->assertEquals('normal', $model->getPriority());
        }
        $this->assertEquals('deadline', $model->getStatus());
        $this->assertInstanceOf(ReportInterface::class, $model);
    }

    public function testChangeArrayKeys()
    {
        $reflection = new \ReflectionClass($this->reportModelService);
        $method = $reflection->getMethod('changeArrayKeys');
        $method->setAccessible(true);
        $resultArray = $method->invokeArgs($this->reportModelService, [$this->message]);

        // Oczekiwane dane wyjściowe po przekształceniu kluczy
        $expectedArray = [
            'contactNumber' => '123456789',
            'visitDate' => '2021-01-01',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ];

        $this->assertEquals($expectedArray, $resultArray);
    }

    public function testSetUniqueParams()
    {
        //TODO: test dla setUniqueParams
    }
}
