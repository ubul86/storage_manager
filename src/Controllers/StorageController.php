<?php

namespace App\Controllers;

use App\Interfaces\StorageInterface;
use InvalidArgumentException;
use App\Services\StorageService;

class StorageController
{
    private StorageService $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    /**
     * @param array{ name: string, address: string, capacity: int } $data
     * @return StorageInterface
     * @throws InvalidArgumentException
     */
    public function create(array $data): StorageInterface
    {
        try {
            return $this->storageService->createStorage($data);
        } catch (InvalidArgumentException $e) {
            throw $e;
        }
    }
}
