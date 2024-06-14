<?php

namespace App\Model\Base;

use App\Interface\EmployeeInterface;

class Employee implements EmployeeInterface
{

    public function __construct(
        private string $name,
        private string $lastName,
        private string $username,
        private string $password,
        private string $gender,
        private string $birthday,
        private string $email,
        private string $phone,
        private array  $address,
        private string $jobTitle,
    )
    {
    }

    public function getFirstName(): string
    {
        return $this->name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getUserName(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phone;
    }

    public function getAddress(): array
    {
        return $this->address;
    }

    public function jobTitle(): string
    {
        return $this->jobTitle;
    }


}