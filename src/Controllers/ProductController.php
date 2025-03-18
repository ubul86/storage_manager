<?php

namespace App\Controllers;

use InvalidArgumentException;
use App\Models\Brand;
use App\Models\Product;
use App\Services\ProductService;
use DI\Attribute\Inject;

class ProductController
{
    #[Inject]
    public function __construct(private readonly ProductService $productService)
    {
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
            return $this->productService->createProduct(data: $data, brand: $brand);
        } catch (InvalidArgumentException $e) {
            throw $e;
        }
    }
}
