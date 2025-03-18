<?php

namespace App\Controllers;

use InvalidArgumentException;
use App\Models\Brand;
use App\Services\BrandService;
use DI\Attribute\Inject;

class BrandController
{
    #[Inject]
    public function __construct(private readonly BrandService $brandService)
    {
    }

    /**
     * @param array{ name: string, qualityCategory: int } $data
     * @return Brand
     * @throws InvalidArgumentException
     */
    public function create(array $data): Brand
    {
        try {
            return $this->brandService->createBrand(data: $data);
        } catch (InvalidArgumentException $e) {
            throw $e;
        }
    }
}
