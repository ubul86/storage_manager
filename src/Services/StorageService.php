<?php

namespace App\Services;

use App\Interfaces\StorageInterface;
use App\Models\Storage;
use App\Validators\StorageValidator;

class StorageService
{
    /**
     * @param array{ name: string, address: string, capacity: int } $data
     * @return StorageInterface
     */
    public function createStorage(array $data): StorageInterface
    {

        StorageValidator::validate($data);

        $name = $data['name'];
        $address = $data['address'];
        $capacity = $data['capacity'];

        return new Storage($name, $address, $capacity);
    }
}
