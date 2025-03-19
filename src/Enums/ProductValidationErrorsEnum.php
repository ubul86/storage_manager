<?php

namespace App\Enums;

enum ProductValidationErrorsEnum: string
{
    case NAME_REQUIRED = "The 'name' field is required and must be a non-empty string.";
    case SKU_REQUIRED = "The 'sku' field is required and must be a non-empty string.";
    case TYPE_REQUIRED = "The 'type' field is required and must be a non-empty string.";

    case PRICE_IS_NUMERIC = "The 'price' field must be a positive value.";

    case PROCESSOR_REQUIRED = 'The "processor" field is required for Laptop.';

    case RAMSIZE_REQUIRED = 'The "ramsize" field is required for Laptop.';

    case SCREEN_SIZE_REQUIRED = 'The "screen size" field is required for Laptop.';
}
