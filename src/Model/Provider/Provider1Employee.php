<?php

namespace App\Model\Provider;

use stdClass;

class Provider1Employee extends ProviderEmployee
{
    private string $name;
    private string $lastName;
    private string $username;
    private string $password;
    private string $gender;
    private string $birthDate;
    private string $email;
    private string $phone;
    private array $address;
    private string $jobTitle;

    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->phone = $data['phone'] ?? '';
        $this->address = $data['address'] ?? [];
        $this->jobTitle = $data['jobTitle'] ?? '';
        $this->lastName = $data['lastName'] ?? '';
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->gender = $data['gender'] ?? '';
        $this->birthDate = $data['birthDate'] ?? '';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAddress(): array
    {
        return $this->address;
    }

    public function getJobTitle(): string
    {
        return $this->jobTitle;
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
        return $this->birthDate;
    }

}
