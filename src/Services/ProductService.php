<?php

namespace App\Services;

use App\Models\Laptop;
use App\Models\Mobile;
use App\Models\Product;
use App\Models\Brand;

class ProductService
{
    /**
     * @param array<mixed> $data
     * @param Brand $brand
     * @return Product
     */
    public function createProduct(array $data, Brand $brand): Product
    {
        $type = $data['type'] ?? 'Product';
        $sku = $data['sku'];
        $name = $data['name'];
        $price = $data['price'];
        $product = match ($type) {
            'Laptop' => (new Laptop($sku, $name))
                ->setProcessor($data['processor'] ?? 'Intel i7')
                ->setRamSize($data['ramSize'] ?? 16),
            'Mobile' => (new Mobile($sku, $name))
                ->setScreenSize($data['screenSize'] ?? '10"'),
            default => new Product($sku, $name),
        };
        $product->setPrice($price);
        $product->setBrand($brand);

        return $product;
    }
}
