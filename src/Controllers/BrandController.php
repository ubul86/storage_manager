<?php

namespace App\Controllers;

use App\DTO\BrandDTO;
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
     * @param BrandDTO $data
     * @return Brand
     * @throws InvalidArgumentException
     */
    public function create(BrandDTO $data): Brand
    {
        try {
            return $this->brandService->createBrand(data: $data);
        } catch (InvalidArgumentException $e) {
            throw $e;
        }
    }
}
