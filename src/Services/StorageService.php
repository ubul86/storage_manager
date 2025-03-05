<?php

namespace App\Services;

use App\Exceptions\ProductNotFoundException;
use App\Exceptions\StorageFullException;
use App\Interfaces\ProductInterface;
use App\Interfaces\StorageInterface;
use App\Models\Storage;
use App\Validators\StorageValidator;

class StorageService
{
    /**
     * @param array{ name: string, address: string, capacity: int } $data
     * @return StorageInterface
     */
    public function createStorage(array $data): StorageInterface
    {

        StorageValidator::validate($data);

        $name = $data['name'];
        $address = $data['address'];
        $capacity = $data['capacity'];

        return new Storage($name, $address, $capacity);
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
        array_map(fn() => $this->addProduct($storage, $product), array_fill(0, $quantity, null));
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
        array_map(fn() => $this->removeProduct($storage, $product), array_fill(0, $quantity, null));
    }

    /**
     * @throws StorageFullException
     */
    public function addProduct(StorageInterface $storage, ProductInterface $product): void
    {
        if (!$storage->hasCapacity()) {
            throw new StorageFullException("Not enough space in storage!");
        }

        $storage->addProduct($product);
    }

    /**
     * @param StorageInterface $storage
     * @param ProductInterface $product
     * @return void
     * @throws ProductNotFoundException
     */
    public function removeProduct(StorageInterface $storage, ProductInterface $product): void
    {
        if (!$storage->hasProduct($product)) {
            throw new ProductNotFoundException("Product not found in storage!");
        }

        $storage->removeProduct($product);
    }
}
