<?php

namespace App\Services;

use App\Models\Brand;
use App\Validators\BrandValidator;
use InvalidArgumentException;

class BrandService
{
    /**
     * @param array{ name: string, qualityCategory: int } $data
     * @return Brand
     * @throws InvalidArgumentException
     */
    public function createBrand(array $data): Brand
    {

        BrandValidator::validate($data);

        $name = $data['name'];
        $qualityCategory = $data['qualityCategory'];

        return new Brand($name, $qualityCategory);
    }
}
