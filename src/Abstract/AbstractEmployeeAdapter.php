<?php

namespace App\Abstract;

use App\Interface\EmployeeInterface;
use App\Model\Base\Employee;


/**
 * Abstract class to adapt any provider to Employee model
 * Class AbstractEmployeeAdapter
 * @package App\Abstract
 */
abstract class AbstractEmployeeAdapter implements EmployeeInterface
{
    /**
     * @return Employee
     */
    public function adapt(): Employee
    {
        // Adapt any provider to Employee model
        return new Employee(
            $this->getFirstName(),
            $this->getLastName(),
            $this->getUserName(),
            $this->getPassword(),
            $this->getGender(),
            $this->getBirthday(),
            $this->getEmail(),
            $this->getPhoneNumber(),
            $this->getAddress(),
            $this->jobTitle(),
        );
    }
}