<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function getSku(): string;
    public function getName(): string;
    public function getPrice(): float;
    public function getBrand(): object;

    public function __toString(): string;
}
