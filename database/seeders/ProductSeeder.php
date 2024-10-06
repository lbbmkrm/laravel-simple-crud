<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = new Product();
        $product->name = 'example';
        $product->sku = uniqid();
        $product->description = fake()->text(100);
        $product->price = 1000;
        $product->image = fake()->image();
    }
}
