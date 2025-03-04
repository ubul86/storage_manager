<?php

namespace App\Validators;

use InvalidArgumentException;

class ProductValidator
{
    /**
     * @param array<mixed> $data
     * @throws InvalidArgumentException
     */
    public static function validate(array $data): void
    {
        if (!is_string($data['name']) || empty(trim($data['name']))) {
            throw new InvalidArgumentException("The 'name' field is required and must be a non-empty string.");
        }

        if (!is_string($data['sku']) || empty(trim($data['sku']))) {
            throw new InvalidArgumentException("The 'sku' field is required and must be a non-empty string.");
        }
    }
}
