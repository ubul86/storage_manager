<?php

namespace App\DTO;

use InvalidArgumentException;
use App\Enums\ShopValidationErrorsEnum;

class ShopDTO
{
    public function __construct(
        public string $name,
        public string $location,
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validate(): void
    {
        if (empty(trim($this->name))) {
            throw new InvalidArgumentException(ShopValidationErrorsEnum::NAME_REQUIRED->value);
        }

        if (empty(trim($this->location))) {
            throw new InvalidArgumentException(ShopValidationErrorsEnum::LOCATION_REQUIRED->value);
        }
    }

    /**
     * @param array{name: ?string, location: ?string} $data
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? throw new InvalidArgumentException(ShopValidationErrorsEnum::NAME_REQUIRED->value),
            location: $data['location'] ?? throw new InvalidArgumentException(ShopValidationErrorsEnum::LOCATION_REQUIRED->value),
        );
    }
}
