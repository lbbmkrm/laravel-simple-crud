<?php

namespace App\Service\ServiceImpl;

use App\Models\Product;
use App\Service\ProductService;

class ProductServiceImpl implements ProductService
{
    public function save(
        string $name,
        string $sku,
        string $description,
        string $image,
        int $price
    ) {
        $product = new Product([
            'name' => $name,
            'sku' => $sku,
            'price' => $price,
            'description' => $description,
            'image' => $image
        ]);
        $product->save();
    }

    public function removeProduct(int $id)
    {
        $product = Product::query()->find($id);
        $product->delete();
    }
}
