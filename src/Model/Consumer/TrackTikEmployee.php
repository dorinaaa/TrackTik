<?php

namespace App\Model\Consumer;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class TrackTikEmployee extends ConsumerEmployee
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $username,
        public string $password,
        public string $gender,
        public string $birthday,
        public string $email,
        public string $primaryPhone,
        public array $address,
        public string $jobTitle,
    ){}

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('firstName', new NotBlank());
        $metadata->addPropertyConstraint('lastName', new NotBlank());
        $metadata->addPropertyConstraint('email', new Email());
        $metadata->addPropertyConstraint('birthday', new Date());
        $metadata->addPropertyConstraint('gender', new Choice(['M', 'F', 'B']));
        $metadata->addPropertyConstraint('password', new Length(['max' => 8]));
        // TODO: Add more constraints based on API requirements
    }
}