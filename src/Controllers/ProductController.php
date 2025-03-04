<?php

namespace App\Controllers;

use InvalidArgumentException;
use App\Models\Brand;
use App\Models\Product;
use App\Services\ProductService;

class ProductController
{
    private ProductService $productService;
    public function __construct()
    {
        $this->productService = new ProductService();
    }

    /**
     * @param array<mixed> $data
     * @param Brand $brand
     * @return Product
     * @throws InvalidArgumentException
     */
    public function create(array $data, Brand $brand): Product
    {
        try {
            return $this->productService->createProduct($data, $brand);
        } catch (InvalidArgumentException $e) {
            throw $e;
        }
    }
}
