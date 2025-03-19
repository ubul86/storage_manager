<?php

namespace App\DTO;

use InvalidArgumentException;
use App\Enums\BrandValidationErrorsEnum;

class BrandDTO
{
    public function __construct(
        public string $name,
        public int $qualityCategory
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validate(): void
    {
        if (empty(trim($this->name))) {
            throw new InvalidArgumentException(BrandValidationErrorsEnum::NAME_REQUIRED->value);
        }

        if ($this->qualityCategory < 1 || $this->qualityCategory > 5) {
            throw new InvalidArgumentException(BrandValidationErrorsEnum::QUALITY_CATEGORY_REQUIRED->value);
        }
    }

    /**
     * @param array{name: ?string, qualityCategory: ?int} $data
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? throw new InvalidArgumentException(BrandValidationErrorsEnum::NAME_REQUIRED->value),
            qualityCategory: $data['qualityCategory'] ?? throw new InvalidArgumentException(BrandValidationErrorsEnum::QUALITY_CATEGORY_REQUIRED->value)
        );
    }
}
