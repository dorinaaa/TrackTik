<?php

namespace App\Adapter\Provider;
use App\Abstract\AbstractEmployeeAdapter;
use App\Model\Provider\Provider2Employee;

/**
 * Get the employee data from Provider1 and adapt it to the Employee
 */
class Provider2EmployeeAdapter extends AbstractEmployeeAdapter {

    public function __construct(private readonly Provider2Employee $employee) {}

    public function getFirstName(): string {
        list($firstName, $lastName) = $this->splitName($this->employee->getFullName());
        return $firstName;
    }

    public function getLastName(): string {
        list($firstName, $lastName) = $this->splitName($this->employee->getFullName());
        return $lastName;
    }

    public function getUserName(): string {
        return $this->employee->getFullName();
    }

    public function getPassword(): string {
        return $this->employee->getPassword();
    }

    public function getGender(): string {
        return $this->employee->getSex();
    }

    public function getBirthday(): string {
        return $this->employee->getBirthYear()  . '-' . $this->employee->getBirthMonth() . '-' . $this->employee->getBirthDay();
    }

    public function getEmail(): string {
        return $this->employee->getEmailAddress();
    }

    public function getPhoneNumber(): string {
        return $this->employee->getContactNumber();
    }

    public function getAddress(): array
    {
        return [$this->employee->getCountry() . ', ' . $this->employee->getCity() . ', ' . $this->employee->getStreet() . ', ' . $this->employee->getPostalCode()];
    }

    public function jobTitle(): string {
        return $this->employee->getJobRole();
    }

    private function splitName(string $fullName): array {
        // Split the full name string by space
        $nameParts = explode(" ", $fullName);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1];
        return array($firstName, $lastName);
    }


}
