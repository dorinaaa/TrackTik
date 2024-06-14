<?php

namespace App\Factory;

use App\Abstract\AbstractEmployeeAdapter;
use App\Abstract\AbstractTrackTikAdapter;
use App\Adapter\Consumer\EmployeeTrackTikAdapter;
use App\Adapter\Provider\Provider1EmployeeAdapter;
use App\Adapter\Provider\Provider2EmployeeAdapter;
use App\Model\Base\Employee;
use App\Model\Provider\Provider1Employee;
use App\Model\Provider\Provider2Employee;
use App\Model\Provider\ProviderEmployee;
use Exception;

class AdapterFactory {
    /**
     * @throws Exception
     */
    public function createProviderModel($data, $provider): ProviderEmployee
    {
        if ($provider === 'provider1') {
            return new Provider1Employee($data);
        } elseif ($provider === 'provider2') {
            return new Provider2Employee($data);
        }
        throw new Exception('Invalid provider');
    }

    /**
     * @throws Exception
     */
    public function createProviderAdapter(string $provider, $providerModel): AbstractEmployeeAdapter
    {
        if ($provider === 'provider1') {
            return new Provider1EmployeeAdapter($providerModel);
        } elseif ($provider === 'provider2') {
            return new Provider2EmployeeAdapter($providerModel);
        }
        throw new Exception('Invalid provider');
    }

    /**
     * @throws Exception
     */
    public function createAppToConsumerAdapter($consumer, Employee $baseEmployee): AbstractTrackTikAdapter
    {
        if ($consumer === 'tracktik') {
            return new EmployeeTrackTikAdapter($baseEmployee);
        }
        throw new Exception('Invalid consumer');
    }
}