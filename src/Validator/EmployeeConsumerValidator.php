<?php

namespace App\Validator;

use App\Model\Consumer\ConsumerEmployee;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmployeeConsumerValidator
{
    public function __construct(private readonly ValidatorInterface $validator) {}
    /**
     * @param ConsumerEmployee $consumerEmployee
     * @return array
     */
    public function validate(ConsumerEmployee $consumerEmployee): array
    {
        $errors = $this->validator->validate($consumerEmployee);

        // Convert validation errors to an array
        $errorArray = [];
        foreach ($errors as $error) {
            $errorArray[$error->getPropertyPath()] = $error->getMessage();
        }
        return $errorArray;
    }
}