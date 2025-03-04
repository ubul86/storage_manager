<?php

namespace App\Services;

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

    public function addMultipleProduct(StorageInterface $storage, ProductInterface $product, int $quantity): void
    {
        array_map(fn() => $storage->addProduct($product), array_fill(0, $quantity, null));
    }

    public function removeMultipleProduct(StorageInterface $storage, ProductInterface $product, int $quantity): void
    {
        array_map(fn() => $storage->removeProduct($product), array_fill(0, $quantity, null));
    }
}
