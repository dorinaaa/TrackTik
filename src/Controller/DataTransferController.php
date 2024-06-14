<?php

namespace App\Controller;

use App\Service\EmployeeConsumerService;
use App\Service\EmployeeDataMapper;
use App\Validator\EmployeeConsumerValidator;
use Exception;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DataTransferController extends AbstractController
{

    public function __construct(
        private readonly EmployeeDataMapper        $dataMapper,
        private readonly EmployeeConsumerValidator $validator,
        private readonly EmployeeConsumerService   $consumerService
    )
    {}

    /**
     */
    public function index(Request $request): JsonResponse
    {
        $providerType = $request->attributes->get('type'); // TODO we could get them from database ideally
        $consumerType = $request->attributes->get('consumer');

        $data = json_decode($request->getContent(), true);

        try {
            // map data from provider to consumer
            $consumerEmployee = $this->dataMapper->mapData($data, $providerType, $consumerType);

            // validate data before sending to consumer
            $validationErrors = $this->validator->validate($consumerEmployee);
            if (count($validationErrors) > 0) {
                return new JsonResponse($validationErrors, 400);
            }

            // if all ok, send to consumer
            $apiResponse = $this->consumerService
                ->getConsumerApi($consumerType)
                ->createOrUpdateEmployee($consumerEmployee->toArray());
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse($apiResponse, 201);
    }
}