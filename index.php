<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Helpers/printHelper.php';

use App\Controllers\ShopController;
use App\Exceptions\InsufficientStockException;
use App\Controllers\ProductController;
use App\Controllers\BrandController;
use App\Controllers\StorageController;
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

$shopController = $container->get(ShopController::class);
$productController = $container->get(ProductController::class);
$brandController = $container->get(BrandController::class);
$storageController = $container->get(StorageController::class);

printBanner('1. Creating Elements');

$brand = $brandController->create(data: [
    'name' => 'Test',
    'qualityCategory' => 5
]);

$product = $productController->create(data: [
    'sku' => '12345',
    'name' => 'Test Product',
    'price' => 10,
], brand: $brand);

$product2 = $productController->create(data: [
    'type' => 'Laptop',
    'sku' => '54321',
    'name' => 'Test Product 2',
    'price' => 10,
], brand: $brand);

$storage = $storageController->create(data: [
    'name' => 'Test Storage',
    'address' => 'Test Address',
    'capacity' => 10,
]);

$storageController->addProduct(storage: $storage, product: $product);
$storageController->addProduct(storage: $storage, product: $product2);

$shopModel = $shopController->create(data: [
    'name' => 'Test Shop',
    'location' => 'Test Location'
]);

$storage2 = $storageController->create(data: [
    'name' => 'Test Storage 2',
    'address' => 'Test Address 2',
    'capacity' => 10,
]);

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