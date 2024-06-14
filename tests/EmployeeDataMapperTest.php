<?php

namespace App\Tests;

use App\Adapter\Consumer\EmployeeTrackTikAdapter;
use App\Adapter\Provider\Provider1EmployeeAdapter;
use App\Factory\AdapterFactory;
use App\Model\Consumer\ConsumerEmployee;
use App\Model\Provider\ProviderEmployee;
use App\Service\EmployeeDataMapper;
use PHPUnit\Framework\TestCase;

class EmployeeDataMapperTest extends TestCase
{
    public function testSuccessfulDataMapping()
    {
        $factory = $this->createMock(AdapterFactory::class);
        $factory->method('createProviderModel')->willReturn(new ProviderEmployee());
        $factory->method('createProviderAdapter')->willReturn(new Provider1EmployeeAdapter()); // todo: fix this
        $factory->method('createAppToConsumerAdapter')->willReturn(new EmployeeTrackTikAdapter()); // todo: fix this

        $mapper = new EmployeeDataMapper($factory);

        $data = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $provider = 'providerType';
        $consumer = 'consumerType';

        $result = $mapper->mapData($data, $provider, $consumer);

        $this->assertInstanceOf(ConsumerEmployee::class, $result);
    }

    public function testDataMappingWithException()
    {
        $factory = $this->createMock(AdapterFactory::class);
        $factory->method('createProviderModel')->willThrowException(new \Exception());

        $mapper = new EmployeeDataMapper($factory);

        $data = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $provider = 'providerType';
        $consumer = 'consumerType';

        $this->expectException(\Exception::class);

        $mapper->mapData($data, $provider, $consumer);
    }
}