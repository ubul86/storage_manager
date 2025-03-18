<?php

namespace App\Tests;

use App\Exceptions\InsufficientStockException;
use App\Exceptions\StorageFullException;
use App\Services\BrandService;
use App\Services\ProductService;
use App\Services\ShopService;
use App\Services\StorageService;
use PHPUnit\Framework\TestCase;

class ShopTest extends TestCase
{
    private BrandService $brandService;
    private ProductService $productService;
    private StorageService $storageService;
    private ShopService $shopService;

    protected function setUp(): void
    {
        $this->brandService = new BrandService();
        $this->productService = new ProductService();
        $this->storageService = new StorageService();
        $this->shopService = new ShopService($this->storageService);
    }

    public function testAddProductsToStorageAndPrintStorageContent(): void
    {

        $brand = $this->brandService->createBrand(data: [
            'name' => 'Test',
            'qualityCategory' => 5
        ]);

        $product1 = $this->productService->createProduct(data: [
            'sku' => '12345',
            'name' => 'Test Product',
            'price' => 10,
        ], brand: $brand);

        $product2 = $this->productService->createProduct(data: [
            'sku' => '54321',
            'name' => 'Test Product 2',
            'price' => 15,
        ], brand: $brand);

        $storage = $this->storageService->createStorage(data: [
            'name' => 'Test Storage',
            'address' => 'Test Location',
            'capacity' => 20,
        ]);

        $this->storageService->addProduct(storage: $storage, product: $product1);
        $this->storageService->addProduct(storage: $storage, product: $product2);

        $storageContent = (string)$storage;

        $this->assertStringContainsString('Test Product', $storageContent);
        $this->assertStringContainsString('Test Product 2', $storageContent);
        $this->assertStringContainsString('Capacity: 20', $storageContent);
    }

    /**
     * @throws InsufficientStockException
     * @throws StorageFullException
     */
    public function testAddProductsToMultipleStorages(): void
    {

        $brand = $this->brandService->createBrand(data: [
            'name' => 'Test',
            'qualityCategory' => 5
        ]);

        $product1 = $this->productService->createProduct(data: [
            'sku' => '12345',
            'name' => 'Test Product',
            'price' => 10,
        ], brand: $brand);


        $storage = $this->storageService->createStorage(data: [
            'name' => 'Test Storage',
            'address' => 'Test Location',
            'capacity' => 2,
        ]);

        $shop = $this->shopService->createShop(data: [
            'name' => 'Test Shop',
            'location' => 'Test Location'
        ]);

        $shop->addStorage(storage: $storage);

        $storage = $this->storageService->createStorage(data: [
            'name' => 'Test Storage 2',
            'address' => 'Test Location',
            'capacity' => 5,
        ]);

        $shop->addStorage(storage: $storage);

        $this->shopService->addProductsToStorages(shop: $shop, product: $product1, quantity: 5);

        $storages = $shop->getStorages();

        $this->assertEquals(2, $storages[0]->getStockQuantity());
        $this->assertEquals(3, $storages[1]->getStockQuantity());
    }

    /**
     * @throws InsufficientStockException
     * @throws StorageFullException
     */
    public function testRemovingMoreProductsThanAvailable(): void
    {
        $this->expectException(InsufficientStockException::class);

        $brand = $this->brandService->createBrand(data: [
            'name' => 'Test',
            'qualityCategory' => 5
        ]);

        $product1 = $this->productService->createProduct(data: [
            'sku' => '12345',
            'name' => 'Test Product',
            'price' => 10,
        ], brand: $brand);


        $storage = $this->storageService->createStorage(data: [
            'name' => 'Test Storage',
            'address' => 'Test Location',
            'capacity' => 2,
        ]);

        $shop = $this->shopService->createShop(data: [
            'name' => 'Test Shop',
            'location' => 'Test Location'
        ]);

        $shop->addStorage($storage);

        $storage = $this->storageService->createStorage(data: [
            'name' => 'Test Storage 2',
            'address' => 'Test Location',
            'capacity' => 5,
        ]);

        $shop->addStorage(storage: $storage);

        $this->shopService->takeOutProductsFromStorages(shop: $shop, product: $product1, quantity: 5);
    }
}
