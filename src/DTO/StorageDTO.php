<?php

namespace App\DTO;

use InvalidArgumentException;
use App\Enums\StorageValidationErrorsEnum;

class StorageDTO
{
    public function __construct(
        public string $name,
        public string $address,
        public int $capacity = 0,
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validate(): void
    {
        if (empty(trim($this->name))) {
            throw new InvalidArgumentException(StorageValidationErrorsEnum::NAME_REQUIRED->value);
        }

        if (empty(trim($this->address))) {
            throw new InvalidArgumentException(StorageValidationErrorsEnum::ADDRESS_REQUIRED->value);
        }

        if ($this->capacity < 0) {
            throw new InvalidArgumentException(StorageValidationErrorsEnum::CAPACITY_REQUIRED->value);
        }
    }

    /**
     * @param array{name: ?string, address: ?string, capacity: ?int} $data
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? throw new InvalidArgumentException(StorageValidationErrorsEnum::NAME_REQUIRED->value),
            address: $data['address'] ?? throw new InvalidArgumentException(StorageValidationErrorsEnum::ADDRESS_REQUIRED->value),
            capacity: $data['capacity'] ?? throw new InvalidArgumentException(StorageValidationErrorsEnum::CAPACITY_REQUIRED->value),
        );
    }
}
