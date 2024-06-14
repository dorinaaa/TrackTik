<?php

namespace App\Service;

use App\Consumer\EmployeeConsumerApi;
use App\Factory\ConsumerFactory;
use Exception;

class EmployeeConsumerService
{
    public function __construct(private readonly ConsumerFactory $consumerFactory) {}

    /**
     * @throws Exception
     */
    public function getConsumerApi($consumer): EmployeeConsumerApi
    {
        try {
            return $this->consumerFactory->createConsumer($consumer);
        } catch (Exception $e) {
            throw new Exception("Failed getting consumer api, {$e->getMessage()}", 400, $e);
        }
    }
}