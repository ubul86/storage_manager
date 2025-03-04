<?php

namespace App\Interfaces;

use App\Models\Storage;

interface ShopInterface
{
    public function addStorage(Storage $storage): void;

    /**
     * @return StorageInterface[]
     */
    public function getStorages(): array;
    public function getName(): string;
    public function getLocation(): string;

    /**
     *
     * @param Storage[] $newStorages
     */
    public function refreshStorages(array $newStorages): void;
}
