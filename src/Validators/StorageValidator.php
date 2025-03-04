<?php

namespace App\Validators;

use InvalidArgumentException;

class StorageValidator
{
    /**
     * @param array{ name: string, address: string, capacity: int } $data
     * @throws InvalidArgumentException
     */
    public static function validate(array $data): void
    {
        if (!is_string($data['name']) || empty(trim($data['name']))) {
            throw new InvalidArgumentException("The 'name' field is required and must be a non-empty string.");
        }

        if (!is_string($data['address']) || empty(trim($data['address']))) {
            throw new InvalidArgumentException("The 'address' field is required and must be a non-empty string.");
        }

        if (!is_int($data['capacity']) || empty($data['capacity'])) {
            throw new InvalidArgumentException("The 'capacity' field is required and must be an non-empty integer.");
        }
    }
}
