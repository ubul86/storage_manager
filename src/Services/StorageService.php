<?php

namespace App\Services;

use App\DTO\StorageDTO;
use App\Exceptions\ProductNotFoundException;
use App\Exceptions\StorageFullException;
use App\Interfaces\ProductInterface;
use App\Interfaces\StorageInterface;
use App\Models\Storage;
use App\Validators\StorageValidator;

class StorageService
{
    /**
     * @param StorageDTO $data
     * @return StorageInterface
     */
    public function createStorage(StorageDTO $data): StorageInterface
    {

        $name = $data->name;
        $address = $data->address;
        $capacity = $data->capacity;

        return new Storage(name: $name, address: $address, capacity: $capacity);
    }

    /**
     * @param StorageInterface $storage
     * @param ProductInterface $product
     * @param int $quantity
     * @return void
     * @throws StorageFullException
     */
    public function addMultipleProduct(StorageInterface $storage, ProductInterface $product, int $quantity): void
    {
        array_map(fn() => $this->addProduct(storage: $storage, product: $product), array_fill(start_index: 0, count: $quantity, value: null));
    }

    /**
     * @param StorageInterface $storage
     * @param ProductInterface $product
     * @param int $quantity
     * @return void
     * @throws ProductNotFoundException
     */
    public function removeMultipleProduct(StorageInterface $storage, ProductInterface $product, int $quantity): void
    {
        array_map(fn() => $this->removeProduct(storage: $storage, product: $product), array_fill(start_index: 0, count: $quantity, value: null));
    }

    /**
     * @throws StorageFullException
     */
    public function addProduct(StorageInterface $storage, ProductInterface $product): void
    {
        if (!$storage->hasCapacity()) {
            throw new StorageFullException("Not enough space in storage!");
        }

        $storage->addProduct(product: $product);
    }

    /**
     * @param StorageInterface $storage
     * @param ProductInterface $product
     * @return void
     * @throws ProductNotFoundException
     */
    public function removeProduct(StorageInterface $storage, ProductInterface $product): void
    {
        if (!$storage->hasProduct(product: $product)) {
            throw new ProductNotFoundException("Product not found in storage!");
        }

        $storage->removeProduct(product: $product);
    }
}
