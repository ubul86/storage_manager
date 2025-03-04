<?php

namespace App\Controllers;

use App\Exceptions\InsufficientStockException;
use App\Exceptions\StorageFullException;
use App\Interfaces\ProductInterface;
use App\Interfaces\StorageInterface;
use InvalidArgumentException;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Storage;
use App\Services\BrandService;
use App\Services\ProductService;
use App\Services\ShopService;
use App\Services\StorageService;

class ShopController
{
    private ShopService $shopService;
    private ProductService $productService;
    private BrandService $brandService;
    private StorageService $storageService;

    public function __construct()
    {
        $this->shopService = new ShopService();
        $this->productService = new ProductService();
        $this->brandService = new BrandService();
        $this->storageService = new StorageService();
    }

    /**
     * @param array{ name: string, location: string } $data
     * @return Shop
     */
    public function createShop(array $data): Shop
    {
        return $this->shopService->createShop($data);
    }

    /**
     * @param array{ name: string, address: string, capacity: int } $data
     * @return StorageInterface
     * @throws InvalidArgumentException
     */
    public function createStorage(array $data): StorageInterface
    {
        try {
            return $this->storageService->createStorage($data);
        } catch (InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @param array<mixed> $data
     * @param Brand $brand
     * @return Product
     * @throws InvalidArgumentException
     */
    public function createProduct(array $data, Brand $brand): Product
    {
        try {
            return $this->productService->createProduct($data, $brand);
        } catch (InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @param array{ name: string, qualityCategory: int } $data
     * @return Brand
     * @throws InvalidArgumentException
     */
    public function createBrand(array $data): Brand
    {
        try {
            return $this->brandService->createBrand($data);
        } catch (InvalidArgumentException $e) {
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
    public function addProductsToStorages(Shop $shop, ProductInterface $product, int $quantity): void
    {
        try {
            $this->storageService->addProductsToStorages($shop, $product, $quantity);
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
            $this->storageService->takeOutProductsFromStorages($shop, $product, $quantity);
        } catch (StorageFullException | InsufficientStockException $e) {
            throw $e;
        }
    }
}
