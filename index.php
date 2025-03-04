<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Helpers/printHelper.php';

use App\Controllers\ShopController;
use App\Exceptions\InsufficientStockException;
use App\Controllers\ProductController;
use App\Controllers\BrandController;
use App\Controllers\StorageController;
use DI\Container;
use App\Services\ShopService;
use App\Services\BrandService;
use App\Services\ProductService;
use App\Services\StorageService;

$container = new Container();
$container->set(ShopService::class, \DI\autowire(ShopService::class));
$container->set(ProductService::class, \DI\autowire(ProductService::class));
$container->set(BrandService::class, \DI\autowire(BrandService::class));
$container->set(StorageService::class, \DI\autowire(StorageService::class));

$shopController = $container->get(ShopController::class);
$productController = $container->get(ProductController::class);
$brandController = $container->get(BrandController::class);
$storageController = $container->get(StorageController::class);

printBanner('1. Creating Elements');

$brand = $brandController->create([
    'name' => 'Test',
    'qualityCategory' => 5
]);

$product = $productController->create([
    'sku' => '12345',
    'name' => 'Test Product',
    'price' => 10,
], $brand);

$product2 = $productController->create([
    'type' => 'Laptop',
    'sku' => '54321',
    'name' => 'Test Product 2',
    'price' => 10,
], $brand);

$storage = $storageController->create([
    'name' => 'Test Storage',
    'address' => 'Test Address',
    'capacity' => 10,
]);

$storage->addProduct($product);
$storage->addProduct($product2);

$shopModel = $shopController->create([
    'name' => 'Test Shop',
    'location' => 'Test Location'
]);

$storage2 = $storageController->create([
    'name' => 'Test Storage 2',
    'address' => 'Test Address 2',
    'capacity' => 10,
]);

$shopModel->addStorage($storage);
$shopModel->addStorage($storage2);

printBanner('2. BULK Add Products');

$shopController->addProductsToStorages($shopModel, $product, 18);

formatOutput($shopModel);

printBanner('3. BULK Remove Products');

$shopController->removeProductsFromStorages($shopModel, $product, 1);

formatOutput($shopModel);

printBanner('4. BULK Remove Products insufficient');

try {
    $shopController->removeProductsFromStorages($shopModel, $product, 19);
    formatOutput($shopModel);
}
catch(InsufficientStockException $e) {
    echo $e->getMessage();
}