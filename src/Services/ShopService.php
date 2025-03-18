<?php

namespace App\Services;

use App\Exceptions\InsufficientStockException;
use App\Exceptions\StorageFullException;
use App\Interfaces\ProductInterface;
use App\Interfaces\StorageInterface;
use App\Models\Shop;

class ShopService
{
    private StorageService $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    /**
     * @param array{ name: string, location: string } $data
     * @return Shop
     */
    public function createShop(array $data): Shop
    {
        $name = $data['name'];
        $location = $data['location'];

        return new Shop(name: $name, location: $location);
    }

    /**
     * @param Shop $shop
     * @param ProductInterface $product
     * @param int $quantity
     * @throws StorageFullException|InsufficientStockException
     * @return void
     */
    public function addProductsToStorages(Shop $shop, ProductInterface $product, int $quantity): void
    {
        $this->modifyProductQuantityInStorages(shop: $shop, product: $product, quantity: $quantity, isAdding: true);
    }

    /**
     * @param Shop $shop
     * @param ProductInterface $product
     * @param int $quantity
     * @throws StorageFullException|InsufficientStockException
     * @return void
     */
    public function takeOutProductsFromStorages(Shop $shop, ProductInterface $product, int $quantity): void
    {
        $this->checkProductAvailability(storages: $shop->getStorages(), product: $product, requiredQuantity: $quantity);
        $this->modifyProductQuantityInStorages(shop: $shop, product: $product, quantity: $quantity, isAdding: false);
    }

    /**
     * @param Shop $shop
     * @param ProductInterface $product
     * @param int $quantity
     * @param bool $isAdding
     * @throws StorageFullException|InsufficientStockException
     * @return void
     */
    private function modifyProductQuantityInStorages(Shop $shop, ProductInterface $product, int $quantity, bool $isAdding): void
    {
        $remainingQuantity = $quantity;

        foreach ($shop->getStorages() as $storage) {
            $availableSpaceOrStock = $isAdding ? $storage->getCapacity() - $storage->getStockQuantity() : $storage->getProductCount($product);

            if ($availableSpaceOrStock > 0) {
                $amountToProcess = min($remainingQuantity, $availableSpaceOrStock);

                $isAdding ? $this->storageService->addMultipleProduct(storage: $storage, product: $product, quantity: $amountToProcess) : $this->storageService->removeMultipleProduct(storage: $storage, product: $product, quantity: $amountToProcess);

                $remainingQuantity -= $amountToProcess;

                if ($remainingQuantity === 0) {
                    return;
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
    }

    /**
     * @param StorageInterface[] $storages
     * @param ProductInterface $product
     * @param int $requiredQuantity
     * @return int
     * @throws InsufficientStockException
     */
    public function checkProductAvailability(array $storages, ProductInterface $product, int $requiredQuantity): int
    {
        $totalAvailable = 0;

        foreach ($storages as $storage) {
            $totalAvailable += $storage->getProductCount(product: $product);
        }

        if ($requiredQuantity > $totalAvailable) {
            throw new InsufficientStockException('Not enough products in storage to remove!');
        }

        return  $totalAvailable - $requiredQuantity;
    }
}
