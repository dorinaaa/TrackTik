<?php

namespace App\Abstract;

use App\Interface\TrackTikEmployeeInterface;
use App\Model\Consumer\ConsumerEmployee;
use App\Model\Consumer\TrackTikEmployee;

/**
 * Abstract class to adapt any provider to TrackTikEmployee model
 */
abstract class AbstractTrackTikAdapter implements TrackTikEmployeeInterface
{
    /**
     * @return ConsumerEmployee
     */
    public function adapt(): ConsumerEmployee
    {
        // Adapt Employee to TrackTikEmployee model
        return new TrackTikEmployee(
            $this->getFirstName(),
            $this->getLastName(),
            $this->getUserName(),
            $this->getPassword(),
            $this->getGender(),
            $this->getBirthday(),
            $this->getEmail(),
            $this->getPrimaryPhoneNumber(),
            $this->getAddress(),
            $this->jobTitle()
        );
    }

}
