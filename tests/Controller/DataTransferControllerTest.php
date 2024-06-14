<?php

namespace App\Tests\Controller;

use App\Consumer\EmployeeConsumerApi;
use App\Controller\DataTransferController;
use App\Model\Base\Employee;
use App\Service\EmployeeConsumerService;
use App\Service\EmployeeDataMapper;
use App\Validator\EmployeeConsumerValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DataTransferControllerTest extends TestCase
{
    public function testsuccessfulDataTransfer()
    {
        $dataMapper = $this->createMock(EmployeeDataMapper::class);
        $validator = $this->createMock(EmployeeConsumerValidator::class);
        $consumerService = $this->createMock(EmployeeConsumerService::class);

        $dataMapper->method('mapData')->willReturn(new Employee()); // todo: fix this
        $validator->method('validate')->willReturn([]);
        $consumerService->method('getConsumerApi')->willReturn(new EmployeeConsumerApi());

        $controller = new DataTransferController($dataMapper, $validator, $consumerService);

        $request = new Request([], [], ['type' => 'provider1', 'consumer' => 'tracktik'], [], [], [], json_encode(['data']));

        $response = $controller->index($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testdataTransferWithValidationError()
    {
        $dataMapper = $this->createMock(EmployeeDataMapper::class);
        $validator = $this->createMock(EmployeeConsumerValidator::class);
        $consumerService = $this->createMock(EmployeeConsumerService::class);

        $dataMapper->method('mapData')->willReturn(new Employee()); // todo fix this
        $validator->method('validate')->willReturn(['error']);
        $consumerService->method('getConsumerApi')->willReturn(new EmployeeConsumerApi());

        $controller = new DataTransferController($dataMapper, $validator, $consumerService);

        $request = new Request([], [], ['type' => 'provider1', 'consumer' => 'tracktik'], [], [], [], json_encode(['data']));

        $response = $controller->index($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testdataTransferWithException()
    {
        $dataMapper = $this->createMock(EmployeeDataMapper::class);
        $validator = $this->createMock(EmployeeConsumerValidator::class);
        $consumerService = $this->createMock(EmployeeConsumerService::class);

        $dataMapper->method('mapData')->willThrowException(new \Exception());
        $validator->method('validate')->willReturn([]);
        $consumerService->method('getConsumerApi')->willReturn(new EmployeeConsumerApi());

        $controller = new DataTransferController($dataMapper, $validator, $consumerService);

        $request = new Request([], [], ['type' => 'provider1', 'consumer' => 'tracktik'], [], [], [], json_encode(['data']));

        $response = $controller->index($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
    }
}