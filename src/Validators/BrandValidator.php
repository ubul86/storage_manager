<?php

namespace App\Validators;

use InvalidArgumentException;

class BrandValidator
{
    /**
     * @param array{ name: string, qualityCategory: int } $data
     * @throws InvalidArgumentException
     */
    public static function validate(array $data): void
    {
        if (!is_string($data['name']) || empty(trim($data['name']))) {
            throw new InvalidArgumentException("The 'name' field is required and must be a non-empty string.");
        }

        if (!is_int($data['qualityCategory']) || $data['qualityCategory'] < 1 || $data['qualityCategory'] > 5) {
            throw new InvalidArgumentException("The 'qualityCategory' field must be an integer between 1 and 5.");
        }
    }
}
