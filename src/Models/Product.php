<?php

namespace App\Models;

use App\Interfaces\ProductInterface;
use ReflectionClass;

class Product implements ProductInterface
{
    protected float $price = 0.0;
    protected Brand $brand;

    public function __construct(private readonly string $sku, private readonly string $name)
    {
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function setBrand(Brand $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function __toString(): string
    {
        return sprintf(
            "%s: %s (SKU: %s, Price: %.2f, Brand: %s)",
            (new ReflectionClass($this))->getShortName(),
            $this->name,
            $this->sku,
            $this->price,
            $this->brand->getName()
        );
    }
}
