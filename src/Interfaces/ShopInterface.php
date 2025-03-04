<?php

namespace App\Interfaces;

use App\Models\Storage;

interface ShopInterface
{
    public function addStorage(StorageInterface $storage): void;

    /**
     * @return StorageInterface[]
     */
    public function getStorages(): array;
    public function getName(): string;
    public function getLocation(): string;
}
