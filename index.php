<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Helpers/printHelper.php';

use App\Controllers\ShopController;
use App\Exceptions\InsufficientStockException;

$shop = new ShopController();

printBanner('1. Creating Elements');

$brand = $shop->createBrand([
    'name' => 'Test',
    'qualityCategory' => 5
]);

$product = $shop->createProduct([
    'sku' => '12345',
    'name' => 'Test Product',
    'price' => 10,
], $brand);

$product2 = $shop->createProduct([
    'type' => 'Laptop',
    'sku' => '54321',
    'name' => 'Test Product 2',
    'price' => 10,
], $brand);

$storage = $shop->createStorage([
    'name' => 'Test Storage',
    'address' => 'Test Address',
    'capacity' => 10,
]);

$storage->addProduct($product);
$storage->addProduct($product2);

$shopModel = $shop->createShop([
    'name' => 'Test Shop',
    'location' => 'Test Location'
]);

$storage2 = $shop->createStorage([
    'name' => 'Test Storage 2',
    'address' => 'Test Address 2',
    'capacity' => 10,
]);

$shopModel->addStorage($storage);
$shopModel->addStorage($storage2);

printBanner('2. BULK Add Products');

$shop->addProductsToStorages($shopModel, $product, 18);

formatOutput($shopModel);

printBanner('3. BULK Remove Products');

$shop->removeProductsFromStorages($shopModel, $product, 1);

formatOutput($shopModel);

printBanner('4. BULK Remove Products insufficient');

try {
    $shop->removeProductsFromStorages($shopModel, $product, 19);
    formatOutput($shopModel);
}
catch(InsufficientStockException $e) {
    echo $e->getMessage();
}