<?php

namespace App\Adapter\Provider;
use App\Abstract\AbstractEmployeeAdapter;
use App\Model\Provider\Provider1Employee;


/**
 * Get the employee data from Provider1 and adapt it to the Employee
 */
class Provider1EmployeeAdapter extends AbstractEmployeeAdapter {


    /**
     * @param Provider1Employee $employee
     */
    public function __construct(private readonly Provider1Employee $employee) {}


    /**
     * @return string
     */
    public function getFirstName(): string {
        return $this->employee->getName();
    }

    /**
     * @return string
     */
    public function getLastName(): string {
        return $this->employee->getLastName();
    }

    /**
     * @return string
     */
    public function getUserName(): string {
        return $this->employee->getUsername();
    }

    /**
     * @return string
     */
    public function getPassword(): string {
        return $this->employee->getPassword();
    }

    /**
     * @return string
     */
    public function getGender(): string {
        return $this->employee->getGender();
    }

    /**
     * @return string
     */
    public function getBirthday(): string {
        return $this->employee->getBirthday();
    }

    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->employee->getEmail();
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string {
        return $this->employee->getPhone();
    }

    /**
     * @return array
     */
    public function getAddress(): array {
        return $this->employee->getAddress();
    }

    /**
     * @return string
     */
    public function jobTitle(): string {
        return $this->employee->getJobTitle();
    }
}
