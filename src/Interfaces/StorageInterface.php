<?php

namespace App\Interfaces;

use App\Interfaces\ProductInterface;

interface StorageInterface
{
    public function getName(): string;
    public function getAddress(): string;
    public function getCapacity(): int;

    /**
     * @return ProductInterface[]
    */
    public function getStock(): array;
    public function getStockQuantity(): int;
    public function addProduct(ProductInterface $product): void;

    public function __toString(): string;
}
