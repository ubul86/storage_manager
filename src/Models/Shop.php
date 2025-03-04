<?php

namespace App\Models;

use App\Interfaces\ShopInterface;
use App\Interfaces\StorageInterface;

class Shop implements ShopInterface
{
    private string $name;
    private string $location;

    /**
     * @var StorageInterface[]
     */
    private array $storages = [];

    public function __construct(string $name, string $location)
    {
        $this->name = $name;
        $this->location = $location;
    }

    public function addStorage(StorageInterface $storage): void
    {
        $this->storages[] = $storage;
    }

    /**
     *
     * @param StorageInterface[] $newStorages
     */
    public function refreshStorages(array $newStorages): void
    {
        foreach ($newStorages as $newStorage) {
            $found = false;
            foreach ($this->storages as $key => $existingStorage) {
                if ($existingStorage->getName() === $newStorage->getName()) {
                    $this->storages[$key] = $newStorage;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $this->addStorage($newStorage);
            }
        }
    }

    public function getStorages(): array
    {
        return $this->storages;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function __toString(): string
    {
        $storages = array_map(fn($s) => (string) $s, $this->storages);
        return sprintf(
            "Shop: %s (Location: %s)\nStorages:\n%s",
            $this->name,
            $this->location,
            implode("\n\n", $storages)
        );
    }
}
