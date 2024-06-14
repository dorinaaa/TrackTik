<?php
namespace App\Interface;
interface EmployeeInterface {
    public function getFirstName();
    public function getLastName();
    public function getUserName();
    public function getPassword();
    public function getGender();
    public function getBirthday();
    public function getEmail();
    public function getPhoneNumber();
    public function getAddress(): array;
    public function jobTitle();
}
