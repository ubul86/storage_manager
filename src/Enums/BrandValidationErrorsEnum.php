<?php

namespace App\Enums;

enum BrandValidationErrorsEnum: string
{
    case NAME_REQUIRED = "The 'name' field is required and must be a non-empty string.";
    case QUALITY_CATEGORY_REQUIRED = "The 'qualityCategory' field must be an integer between 1 and 5.";
}
