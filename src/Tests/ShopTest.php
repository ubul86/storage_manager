<?php

namespace App\Tests;

use App\DTO\BrandDTO;
use App\DTO\ProductDTO;
use App\DTO\StorageDTO;
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

        $brandData = [
            'name' => 'Test',
            'qualityCategory' => 5
        ];

        $brand = $this->brandService->createBrand(data: BrandDTO::fromArray($brandData));

        $product1Data =  [
            'sku' => '12345',
            'name' => 'Test Product',
            'price' => 10,
        ];

        $product1 = $this->productService->createProduct(data: ProductDTO::fromArray($product1Data), brand: $brand);

        $product2Data = [
            'sku' => '54321',
            'name' => 'Test Product 2',
            'price' => 15,
        ];

        $product2 = $this->productService->createProduct(data: ProductDTO::fromArray($product2Data), brand: $brand);

        $storageData = [
            'name' => 'Test Storage',
            'address' => 'Test Location',
            'capacity' => 20,
        ];

        $storage = $this->storageService->createStorage(data: StorageDTO::fromArray($storageData));

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

        $brandData = [
            'name' => 'Test',
            'qualityCategory' => 5
        ];

        $brand = $this->brandService->createBrand(data: BrandDTO::fromArray($brandData));

        $product1Data =  [
            'sku' => '12345',
            'name' => 'Test Product',
            'price' => 10,
        ];

        $product1 = $this->productService->createProduct(data: ProductDTO::fromArray($product1Data), brand: $brand);

        $storageData1 = [
            'name' => 'Test Storage',
            'address' => 'Test Location',
            'capacity' => 2,
        ];

        $storage = $this->storageService->createStorage(data: StorageDTO::fromArray($storageData1));

        $shop = $this->shopService->createShop(data: [
            'name' => 'Test Shop',
            'location' => 'Test Location'
        ]);

        $shop->addStorage(storage: $storage);

        $storageData2 = [
            'name' => 'Test Storage 2',
            'address' => 'Test Location',
            'capacity' => 5,
        ];

        $storage = $this->storageService->createStorage(data: StorageDTO::fromArray($storageData2));

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

        $brandData = [
            'name' => 'Test',
            'qualityCategory' => 5
        ];

        $brand = $this->brandService->createBrand(data: BrandDTO::fromArray($brandData));

        $product1Data =  [
            'sku' => '12345',
            'name' => 'Test Product',
            'price' => 10,
        ];

        $product1 = $this->productService->createProduct(data: ProductDTO::fromArray($product1Data), brand: $brand);

        $storageData1 = [
            'name' => 'Test Storage',
            'address' => 'Test Location',
            'capacity' => 2,
        ];

        $storage = $this->storageService->createStorage(data: StorageDTO::fromArray($storageData1));

        $shop = $this->shopService->createShop(data: [
            'name' => 'Test Shop',
            'location' => 'Test Location'
        ]);

        $shop->addStorage($storage);

        $storageData2 = [
            'name' => 'Test Storage 2',
            'address' => 'Test Location',
            'capacity' => 5,
        ];

        $storage = $this->storageService->createStorage(data: StorageDTO::fromArray($storageData2));

        $shop->addStorage(storage: $storage);

        $this->shopService->takeOutProductsFromStorages(shop: $shop, product: $product1, quantity: 5);
    }
}
