<?php

namespace App\Models;

use App\Interfaces\BrandInterface;

class Brand implements BrandInterface
{
    private string $name;
    private int $qualityCategory;

    public function __construct(string $name, int $qualityCategory)
    {
        $this->name = $name;
        $this->qualityCategory = $qualityCategory;
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
