<?php

namespace App\Model\Consumer;


use ReflectionObject;

class ConsumerEmployee
{
    public function toArray(): array
    {
        $reflection = new ReflectionObject($this);
        $properties = $reflection->getProperties();

        $data = [];
        foreach ($properties as $property) {
            // Exclude methods
            $propertyName = $property->getName();
            $data[$propertyName] = $this->$propertyName;
        }
        return array_filter($data, function($value) {
            // Check if the value is not empty
            return !empty($value);
        });
    }

}
