<?php

namespace App\Models;

class Mobile extends Product
{
    public string $screenSize;

    public function __construct(string $sku, string $name)
    {
        parent::__construct($sku, $name);
    }

    public function setScreenSize(string $screenSize): self
    {
        $this->screenSize = $screenSize;
        return $this;
    }

    public function getScreenSize(): string
    {
        return $this->screenSize;
    }
}
