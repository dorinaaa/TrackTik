<?php

namespace App\Model\Provider;
class Provider2Employee extends ProviderEmployee
{
    private string $fullName;
    private string $emailAddress;
    private string $contactNumber;
    private string $password;
    private string $sex;
    private string $birthYear;
    private string $birthMonth;
    private string $birthDay;
    private string $city;
    private string $country;
    private string $street;
    private string $postalCode;
    private string $jobRole;

    /*
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->fullName = $this->getNested($data, 'personalData.fullName', '');
        $this->sex = $this->getNested($data, 'personalData.sex', '');
        $this->password = $this->getNested($data, 'personalData.password', '');

        $this->emailAddress = $this->getNested($data, 'contact.emailAddress', '');
        $this->contactNumber = $this->getNested($data, 'contact.contactNumber', '');

        $this->city = $this->getNested($data, 'address.city', '');
        $this->country = $this->getNested($data, 'address.country', '');
        $this->street = $this->getNested($data, 'address.street', '');
        $this->postalCode = $this->getNested($data, 'address.postal_code', '');

        $this->jobRole = $this->getNested($data, 'job.job_role', '');

        $this->birthYear = $this->getNested($data, 'birth.birth_year', '');
        $this->birthMonth = $this->getNested($data, 'birth.birth_month', '');
        $this->birthDay = $this->getNested($data, 'birth.birth_day', '');
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function getContactNumber(): string
    {
        return $this->contactNumber;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSex(): string
    {
        return $this->sex;
    }

    public function getBirthYear(): string
    {
        return $this->birthYear;
    }

    public function getBirthMonth(): string
    {
        return $this->birthMonth;
    }

    public function getBirthDay(): string
    {
        return $this->birthDay;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getJobRole(): string
    {
        return $this->jobRole;
    }

    private function getNested(array $data, string $path, $default = null)
    {
        $keys = explode('.', $path);

        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                return $default;
            }

            $data = $data[$key];
        }

        return $data;
    }
}
