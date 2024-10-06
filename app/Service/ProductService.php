<?php

namespace App\Service;

interface ProductService
{
    public function save(
        string $name,
        string $sku,
        string $description,
        string $image,
        int $price
    );

    public function removeProduct(int $id);
}
