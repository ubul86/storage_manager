<?php

namespace App\Controllers;

use App\Exceptions\ProductNotFoundException;
use App\Interfaces\StorageInterface;
use InvalidArgumentException;
use App\Services\StorageService;
use App\Interfaces\ProductInterface;
use App\Exceptions\StorageFullException;
use DI\Attribute\Inject;

class StorageController
{
    #[Inject]
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
            return $this->storageService->createStorage(data: $data);
        } catch (InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @param StorageInterface $storage
     * @param ProductInterface $product
     * @return void
     * @throws StorageFullException
     */
    public function addProduct(StorageInterface $storage, ProductInterface $product): void
    {
        try {
            $this->storageService->addProduct(storage: $storage, product: $product);
        } catch (StorageFullException $e) {
            throw $e;
        }
    }

    /**
     * @param StorageInterface $storage
     * @param ProductInterface $product
     * @return void
     * @throws ProductNotFoundException
     */
    public function removeProduct(StorageInterface $storage, ProductInterface $product): void
    {
        try {
            $this->storageService->removeProduct(storage: $storage, product: $product);
        } catch (ProductNotFoundException $e) {
            throw $e;
        }
    }
}
