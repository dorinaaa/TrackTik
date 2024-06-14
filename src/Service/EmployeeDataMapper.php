<?php

namespace App\Service;

use App\Factory\AdapterFactory;
use App\Model\Consumer\ConsumerEmployee;
use Exception;

class EmployeeDataMapper
{
    public function __construct(private readonly AdapterFactory $factory) {}

    /**
     * @throws Exception
     */
    public function mapData(array $data, string $provider, string $consumer): ConsumerEmployee
    {
        try {
            // Create provider model
            $providerModel = $this->factory->createProviderModel($data, $provider);

            // Create provider adapter
            $providerAdapter = $this->factory->createProviderAdapter($provider, $providerModel);

            // Adapt data to app model
            $baseEmployeeModel = $providerAdapter->adapt();

            // Create adapter for consumer
            $appToConsumerAdapter = $this->factory->createAppToConsumerAdapter($consumer, $baseEmployeeModel);

            // Adapt app model to consumer model and return final consumer model
            return $appToConsumerAdapter->adapt();
        } catch (Exception $e) {
            throw new Exception("Failed mapping data: {$e->getMessage()}", 400, $e);
        }
    }

}