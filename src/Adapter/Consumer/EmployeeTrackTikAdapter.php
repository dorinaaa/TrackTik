<?php

namespace App\Adapter\Consumer;
use App\Abstract\AbstractTrackTikAdapter;
use App\Model\Base\Employee;

/**
 * Get the employee data from Employee and adapt it to the TrackTikEmployee
 */
class EmployeeTrackTikAdapter extends AbstractTrackTikAdapter
{

    public function __construct(private readonly Employee $employee) {}


    public function getFirstName(): string
    {
        return $this->employee->getFirstName();
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
    public function getPrimaryPhoneNumber(): string {
        return $this->employee->getPhoneNumber();
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
        return $this->employee->jobTitle();
    }

    public function getEmailAddress(): string
    {
        return $this->employee->getEmail();
    }
}