<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\Models\Laptop;
use App\Models\Mobile;
use App\Models\Product;
use App\Models\Brand;

class ProductService
{
    /**
     * @param ProductDTO $data
     * @param Brand $brand
     * @return Product
     */
    public function createProduct(ProductDTO $data, Brand $brand): Product
    {

        $type = $data->type;
        $sku = $data->sku;
        $name = $data->name;
        $price = $data->price;

        $product = match ($type) {
            'Laptop' => (new Laptop(sku: $sku, name: $name))
                ->setProcessor(processor: $data->processor ?? 'Intel i7')
                ->setRamSize(ramSize: $data->ramSize ?? 16),
            'Mobile' => (new Mobile(sku: $sku, name: $name))
                ->setScreenSize(screenSize: $data->screenSize ?? '10"'),
            default => new Product(sku: $sku, name: $name),
        };
        $product->setPrice(price: $price);
        $product->setBrand(brand: $brand);

        return $product;
    }
}
