<?php

namespace App\Services;

use App\Models\Laptop;
use App\Models\Mobile;
use App\Models\Product;
use App\Models\Brand;
use App\Validators\ProductValidator;

class ProductService
{
    /**
     * @param array<mixed> $data
     * @param Brand $brand
     * @return Product
     */
    public function createProduct(array $data, Brand $brand): Product
    {

        ProductValidator::validate($data);

        $type = $data['type'] ?? 'Product';
        $sku = $data['sku'];
        $name = $data['name'];
        $price = $data['price'];
        $product = match ($type) {
            'Laptop' => (new Laptop(sku: $sku, name: $name))
                ->setProcessor(processor: $data['processor'] ?? 'Intel i7')
                ->setRamSize(ramSize: $data['ramSize'] ?? 16),
            'Mobile' => (new Mobile(sku: $sku, name: $name))
                ->setScreenSize(screenSize: $data['screenSize'] ?? '10"'),
            default => new Product(sku: $sku, name: $name),
        };
        $product->setPrice(price: $price);
        $product->setBrand(brand: $brand);

        return $product;
    }
}
