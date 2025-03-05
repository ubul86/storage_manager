<?php

namespace App\Interfaces;

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

    public function getProductCount(ProductInterface $product): int;

    public function removeProduct(ProductInterface $product): void;

    public function hasCapacity(): bool;

    public function hasProduct(ProductInterface $product): bool;
}
