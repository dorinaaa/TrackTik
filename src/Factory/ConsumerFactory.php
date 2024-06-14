<?php

namespace App\Factory;

use App\Consumer\EmployeeConsumerApi;
use App\Consumer\TrackTikConsumerApi;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\CacheInterface;

class ConsumerFactory
{
    public function __construct(
        private readonly ParameterBagInterface $params,
        private readonly CacheInterface $cache
    ){}

    /**
     * @throws Exception
     */
    public function createConsumer(string $consumer): EmployeeConsumerApi
    {
        if ($consumer === 'tracktik') {
            return new TrackTikConsumerApi($this->params, $this->cache);
        }
        throw new Exception('Invalid consumer');
    }
}