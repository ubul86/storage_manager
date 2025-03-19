<?php

namespace App\Enums;

enum ShopValidationErrorsEnum: string
{
    case NAME_REQUIRED = "The 'name' field is required and must be a non-empty string.";
    case LOCATION_REQUIRED = "The 'location' field is required and must be a non-empty string.";
}
