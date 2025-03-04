<?php

namespace App\Models;

class Laptop extends Product
{
    private string $processor;
    private int $ramSize;

    public function __construct(string $sku, string $name)
    {
        parent::__construct($sku, $name);
    }

    public function setProcessor(string $processor): self
    {
        $this->processor = $processor;
        return $this;
    }

    public function setRamSize(int $ramSize): self
    {
        $this->ramSize = $ramSize;
        return $this;
    }

    public function getProcessor(): string
    {
        return $this->processor;
    }

    public function getRamSize(): int
    {
        return $this->ramSize;
    }
}
