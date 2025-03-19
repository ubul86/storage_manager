<?php

namespace App\DTO;

use InvalidArgumentException;
use App\Enums\ProductValidationErrorsEnum;

class ProductDTO
{
    public function __construct(
        public ?string $type,
        public string $sku,
        public string $name,
        public float $price,
        public ?string $processor = null,
        public ?int $ramSize = null,
        public ?string $screenSize = null
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validate(): void
    {
        if (empty(trim($this->sku))) {
            throw new InvalidArgumentException(ProductValidationErrorsEnum::SKU_REQUIRED->value);
        }

        if (empty(trim($this->name))) {
            throw new InvalidArgumentException(ProductValidationErrorsEnum::NAME_REQUIRED->value);
        }

        if ($this->price <= 0) {
            throw new InvalidArgumentException(ProductValidationErrorsEnum::PRICE_IS_NUMERIC->value);
        }

        if ($this->type === 'Laptop') {
            if (empty($this->processor)) {
                throw new InvalidArgumentException(ProductValidationErrorsEnum::PROCESSOR_REQUIRED->value);
            }

            if (empty($this->ramSize)) {
                throw new InvalidArgumentException(ProductValidationErrorsEnum::RAMSIZE_REQUIRED->value);
            }
        }

        if ($this->type === 'Mobile') {
            if (empty($this->screenSize)) {
                throw new InvalidArgumentException(ProductValidationErrorsEnum::SCREEN_SIZE_REQUIRED->value);
            }
        }
    }

    /**
     * @param array{type?: string, sku: ?string, name: ?string, price?: int, processor?: string, ramSize?: int, screenSize?: string} $data
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'] ?? null,
            sku: $data['sku'] ?? throw new InvalidArgumentException(ProductValidationErrorsEnum::SKU_REQUIRED->value),
            name: $data['name'] ?? throw new InvalidArgumentException(ProductValidationErrorsEnum::NAME_REQUIRED->value),
            price: $data['price'] ?? 0.0,
            processor: $data['processor'] ?? null,
            ramSize: $data['ramSize'] ?? null,
            screenSize: $data['screenSize'] ?? null
        );
    }
}
