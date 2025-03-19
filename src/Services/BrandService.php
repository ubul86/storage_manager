<?php

namespace App\Services;

use App\DTO\BrandDTO;
use App\Models\Brand;
use InvalidArgumentException;

class BrandService
{
    /**
     * @param BrandDTO $data
     * @return Brand
     * @throws InvalidArgumentException
     */
    public function createBrand(BrandDTO $data): Brand
    {

        $name = $data->name;
        $qualityCategory = $data->qualityCategory;

        return new Brand(name: $name, qualityCategory: $qualityCategory);
    }
}
