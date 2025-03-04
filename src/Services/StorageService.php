<?php

namespace App\Services;

use App\Exceptions\InsufficientStockException;
use App\Interfaces\StorageInterface;
use App\Models\Storage;
use App\Interfaces\ProductInterface;
use App\Exceptions\StorageFullException;

class StorageService
{
    /**
     * @param array{ name: string, address: string, capacity: int } $data
     * @return Storage
     */
    public function createStorage(array $data): Storage
    {
        $name = $data['name'];
        $address = $data['address'];
        $capacity = $data['capacity'];

        return new Storage($name, $address, $capacity);
    }

    /**
     * @param array<Storage> $storages
     * @param ProductInterface $product
     * @param int $quantity
     * @throws StorageFullException|InsufficientStockException
     * @return array<StorageInterface>
     */
    public function addProductsToStorages(array $storages, ProductInterface $product, int $quantity): array
    {
        return $this->modifyProductQuantityInStorages($storages, $product, $quantity, true);
    }

    /**
     * @param array<Storage> $storages
     * @param ProductInterface $product
     * @param int $quantity
     * @throws StorageFullException|InsufficientStockException
     * @return array<StorageInterface>
     */
    public function takeOutProductsFromStorages(array $storages, ProductInterface $product, int $quantity): array
    {
        $this->checkProductAvailability($storages, $product, $quantity);
        return $this->modifyProductQuantityInStorages($storages, $product, $quantity, false);
    }

    /**
     * @param array<Storage> $storages
     * @param ProductInterface $product
     * @param int $quantity
     * @param bool $isAdding
     * @throws StorageFullException|InsufficientStockException
     * @return array<StorageInterface>
     */
    private function modifyProductQuantityInStorages(array $storages, ProductInterface $product, int $quantity, bool $isAdding): array
    {
        $remainingQuantity = $quantity;

        foreach ($storages as $storage) {
            $availableSpaceOrStock = $isAdding
                ? $storage->getCapacity() - $storage->getStockQuantity()
                : $storage->getProductCount($product);

            if ($availableSpaceOrStock > 0) {
                $amountToProcess = min($remainingQuantity, $availableSpaceOrStock);

                for ($i = 0; $i < $amountToProcess; $i++) {
                    $isAdding ? $storage->addProduct($product) : $storage->removeProduct($product);
                }

                $remainingQuantity -= $amountToProcess;

                if ($remainingQuantity === 0) {
                    return $storages;
                }
            }
        }

        if ($remainingQuantity > 0) {
            if ($isAdding) {
                throw new StorageFullException("Not enough space to add all products to storage!");
            } else {
                throw new InsufficientStockException("Not enough products in storage to remove!");
            }
        }

        return $storages;
    }

    /**
     * @param Storage[] $storages
     * @param ProductInterface $product
     * @param int $requiredQuantity
     * @return int
     * @throws InsufficientStockException
     */
    public function checkProductAvailability(array $storages, ProductInterface $product, int $requiredQuantity): int
    {
        $totalAvailable = 0;

        foreach ($storages as $storage) {
            $totalAvailable += $storage->getProductCount($product);
        }

        if ($requiredQuantity > $totalAvailable) {
            throw new InsufficientStockException();
        }

        return  $totalAvailable - $requiredQuantity;
    }
}
