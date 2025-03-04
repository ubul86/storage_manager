<?php

namespace App\Services;

use App\Models\Shop;

class ShopService
{
    /**
     * @param array{ name: string, location: string } $data
     * @return Shop
     */
    public function createShop(array $data): Shop
    {
        $name = $data['name'];
        $location = $data['location'];

        return new Shop($name, $location);
    }
}
