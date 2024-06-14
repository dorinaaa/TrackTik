<?php

namespace App\Interface;

interface TrackTikEmployeeInterface {
    public function getFirstName();
    public function getLastName();
    public function getUsername();
    public function getPassword();
    public function getGender();
    public function getBirthday();
    public function getEmailAddress();
    public function getPrimaryPhoneNumber();
    public function getAddress();
    public function jobTitle();

}