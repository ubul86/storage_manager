<?php

namespace App\Models;

use App\Interfaces\BrandInterface;

class Brand implements BrandInterface
{
    public function __construct(private readonly string $name, private readonly int $qualityCategory)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQualityCategory(): int
    {
        return $this->qualityCategory;
    }

    public function __toString(): string
    {
        return sprintf("Brand: %s (Quality: %d)", $this->name, $this->qualityCategory);
    }
}
