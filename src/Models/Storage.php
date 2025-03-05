<?php

namespace App\Models;

use App\Interfaces\ProductInterface;
use App\Interfaces\StorageInterface;

class Storage implements StorageInterface
{
    private string $name;
    private string $address;
    private int $capacity;

    /**
     * @var ProductInterface[]
     */
    private array $stock = [];

    public function __construct(string $name, string $address, int $capacity)
    {
        $this->name = $name;
        $this->address = $address;
        $this->capacity = $capacity;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function getStock(): array
    {
        return $this->stock;
    }

    public function getStockQuantity(): int
    {
        return count($this->stock);
    }

    public function hasCapacity(): bool
    {
        return $this->getStockQuantity() < $this->getCapacity();
    }

    public function hasProduct(ProductInterface $product): bool
    {
        return $this->getProductCount($product) > 0;
    }

    public function addProduct(ProductInterface $product): void
    {
        $this->stock[] = $product;
    }

    public function getProductCount(ProductInterface $product): int
    {
        return count(array_filter($this->stock, fn($p) => $p->getSku() === $product->getSku()));
    }

    public function removeProduct(ProductInterface $product): void
    {
        $index = array_key_first(array_filter($this->stock, fn($storedProduct) => $storedProduct->getSku() === $product->getSku()));

        if ($index !== null) {
            unset($this->stock[$index]);
            $this->stock = array_values($this->stock);
        }
    }

    public function __toString(): string
    {
        $products = array_map(fn($p) => $p, $this->stock);
        return sprintf(
            "Storage: %s (Address: %s, Capacity: %d)\nStock (Quantity %d):\n%s",
            $this->name,
            $this->address,
            $this->capacity,
            $this->getStockQuantity(),
            implode("\n", $products)
        );
    }
}
