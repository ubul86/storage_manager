<?php

namespace App\Controllers;

use App\DTO\ShopDTO;
use App\Exceptions\InsufficientStockException;
use App\Exceptions\StorageFullException;
use App\Interfaces\ProductInterface;
use App\Models\Shop;
use App\Services\ShopService;
use DI\Attribute\Inject;

class ShopController
{
    #[Inject]
    public function __construct(private readonly ShopService $shopService)
    {
    }

    /**
     * @param ShopDTO $data
     * @return Shop
     */
    public function create(ShopDTO $data): Shop
    {
        return $this->shopService->createShop(data: $data);
    }

    /**
     * @param Shop $shop
     * @param ProductInterface $product
     * @param int $quantity
     * @return void
     * @throws StorageFullException|InsufficientStockException
     */
    public function addProductsToStorages(Shop $shop, ProductInterface $product, int $quantity): void
    {
        try {
            $this->shopService->addProductsToStorages(shop: $shop, product: $product, quantity: $quantity);
        } catch (StorageFullException | InsufficientStockException $e) {
            throw $e;
        }
    }

    /**
     * @param Shop $shop
     * @param ProductInterface $product
     * @param int $quantity
     * @return void
     * @throws StorageFullException|InsufficientStockException
     */
    public function removeProductsFromStorages(Shop $shop, ProductInterface $product, int $quantity): void
    {
        try {
            $this->shopService->takeOutProductsFromStorages(shop: $shop, product: $product, quantity: $quantity);
        } catch (StorageFullException | InsufficientStockException $e) {
            throw $e;
        }
    }
}
