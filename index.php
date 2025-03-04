<?php

require __DIR__ . '/vendor/autoload.php';

use App\Controllers\ShopController;


$shop = new ShopController();


$brand = $shop->createBrand([
    'name' => 'Test',
    'qualityCategory' => 5
]);

$product = $shop->createProduct([
    'sku' => 'asdqwe',
    'name' => 'Test Product',
    'price' => 10,
], $brand);

$product2 = $shop->createProduct([
    'type' => 'Laptop',
    'sku' => 'asdqwe2',
    'name' => 'Test Product 2',
    'price' => 10,
], $brand);

$storage = $shop->createStorage([
    'name' => 'Teszt Storage',
    'address' => 'Test Location',
    'capacity' => 10,
]);

$storage->addProduct($product);
$storage->addProduct($product2);

$shopModel = $shop->createShop([
    'name' => 'Test Shop',
    'location' => 'Test Location'
]);

$storage2 = $shop->createStorage([
    'name' => 'Teszt Storage 2',
    'address' => 'Test Location',
    'capacity' => 10,
]);

$shopModel->addStorage($storage);
$shopModel->addStorage($storage2);

$shop->addProductsToStorages($shopModel, $product, 18);

//echo '<pre>' . nl2br($shopModel) . '</pre>';

$shop->removeProductsFromStorages($shopModel, $product, 1);

echo '<pre>' . nl2br($shopModel) . '</pre>';
