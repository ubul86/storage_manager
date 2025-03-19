<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Helpers/printHelper.php';

use App\Controllers\ShopController;
use App\Exceptions\InsufficientStockException;
use App\Controllers\ProductController;
use App\Controllers\BrandController;
use App\Controllers\StorageController;
use DI\ContainerBuilder;
use App\DTO\BrandDTO;
use App\DTO\ProductDTO;
use App\DTO\StorageDTO;

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

$shopController = $container->get(ShopController::class);
$productController = $container->get(ProductController::class);
$brandController = $container->get(BrandController::class);
$storageController = $container->get(StorageController::class);

printBanner('1. Creating Elements');

$brandData = [
    'name' => 'Test',
    'qualityCategory' => 5
];

$brand = $brandController->create(data: BrandDTO::fromArray($brandData));

$productData = [
    'sku' => '12345',
    'name' => 'Test Product',
    'price' => 10,
];

$product = $productController->create(data: ProductDTO::fromArray($productData), brand: $brand);

$productData2 = [
    'type' => 'Laptop',
    'sku' => '54321',
    'name' => 'Test Product 2',
    'processor' => 'Amd',
    'ramSize' => 16,
    'price' => 10,
];

$product2 = $productController->create(data: ProductDTO::fromArray($productData2), brand: $brand);

$storageData = [
    'name' => 'Test Storage',
    'address' => 'Test Address',
    'capacity' => 10,
];

$storage = $storageController->create(data: StorageDTO::fromArray($storageData));

$storageController->addProduct(storage: $storage, product: $product);
$storageController->addProduct(storage: $storage, product: $product2);

$shopModel = $shopController->create(data: [
    'name' => 'Test Shop',
    'location' => 'Test Location'
]);

$storageData2 = [
    'name' => 'Test Storage 2',
    'address' => 'Test Address 2',
    'capacity' => 10,
];

$storage2 = $storageController->create(data: StorageDTO::fromArray($storageData2));

$shopModel->addStorage(storage: $storage);
$shopModel->addStorage(storage: $storage2);

printBanner('2. BULK Add Products');

$shopController->addProductsToStorages(shop: $shopModel, product: $product, quantity: 18);

formatOutput($shopModel);

printBanner('3. BULK Remove Products');

$shopController->removeProductsFromStorages(shop: $shopModel, product: $product, quantity: 1);

formatOutput($shopModel);

printBanner('4. BULK Remove Products Insufficient');

try {
    $shopController->removeProductsFromStorages(shop: $shopModel, product: $product, quantity: 19);
    formatOutput($shopModel);
}
catch(InsufficientStockException $e) {
    echo $e->getMessage();
}