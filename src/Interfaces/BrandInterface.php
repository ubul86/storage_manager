<?php

namespace App\Interfaces;

interface BrandInterface
{
    public function getName(): string;
    public function getQualityCategory(): int;
}
