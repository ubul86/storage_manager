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
        $this->shopService = new ShopService();
    }

    public function testAddProductsToStorageAndPrintStorageContent(): void
    {

        $brand = $this->brandService->createBrand([
            'name' => 'Test',
            'qualityCategory' => 5
        ]);

        $product1 = $this->productService->createProduct([
            'sku' => '12345',
            'name' => 'Test Product',
            'price' => 10,
        ], $brand);

        $product2 = $this->productService->createProduct([
            'sku' => '54321',
            'name' => 'Test Product 2',
            'price' => 15,
        ], $brand);

        $storage = $this->storageService->createStorage([
            'name' => 'Test Storage',
            'address' => 'Test Location',
            'capacity' => 20,
        ]);

        $storage->addProduct($product1);
        $storage->addProduct($product2);

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

        $brand = $this->brandService->createBrand([
            'name' => 'Test',
            'qualityCategory' => 5
        ]);

        $product1 = $this->productService->createProduct([
            'sku' => '12345',
            'name' => 'Test Product',
            'price' => 10,
        ], $brand);


        $storage = $this->storageService->createStorage([
            'name' => 'Test Storage',
            'address' => 'Test Location',
            'capacity' => 2,
        ]);

        $shop = $this->shopService->createShop([
            'name' => 'Test Shop',
            'location' => 'Test Location'
        ]);

        $shop->addStorage($storage);

        $storage = $this->storageService->createStorage([
            'name' => 'Test Storage 2',
            'address' => 'Test Location',
            'capacity' => 5,
        ]);

        $shop->addStorage($storage);

        $refreshedStorages = $this->storageService->addProductsToStorages($shop->getStorages(), $product1, 5);
        $shop->refreshStorages($refreshedStorages);

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

        $brand = $this->brandService->createBrand([
            'name' => 'Test',
            'qualityCategory' => 5
        ]);

        $product1 = $this->productService->createProduct([
            'sku' => '12345',
            'name' => 'Test Product',
            'price' => 10,
        ], $brand);


        $storage = $this->storageService->createStorage([
            'name' => 'Test Storage',
            'address' => 'Test Location',
            'capacity' => 2,
        ]);

        $shop = $this->shopService->createShop([
            'name' => 'Test Shop',
            'location' => 'Test Location'
        ]);

        $shop->addStorage($storage);

        $storage = $this->storageService->createStorage([
            'name' => 'Test Storage 2',
            'address' => 'Test Location',
            'capacity' => 5,
        ]);

        $shop->addStorage($storage);

        $refreshedStorages = $this->storageService->takeOutProductsFromStorages($shop->getStorages(), $product1, 5);
        $shop->refreshStorages($refreshedStorages);
    }
}
