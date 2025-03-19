<?php

namespace App\Enums;

enum StorageValidationErrorsEnum: string
{
    case NAME_REQUIRED = "The 'name' field is required and must be a non-empty string.";
    case ADDRESS_REQUIRED = "The 'address' field is required and must be a non-empty string.";
    case CAPACITY_REQUIRED = "The 'capacity' field is required and must be a positive value.";
}
