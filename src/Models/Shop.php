<?php

namespace App\Models;

use App\Interfaces\ShopInterface;
use App\Interfaces\StorageInterface;

class Shop implements ShopInterface
{
    /**
     * @var StorageInterface[]
     */
    private array $storages = [];

    public function __construct(private readonly string $name, private readonly string $location)
    {
    }

    public function addStorage(StorageInterface $storage): void
    {
        $this->storages[] = $storage;
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
