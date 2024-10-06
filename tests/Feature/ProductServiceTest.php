<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Service\ServiceImpl\ProductServiceImpl;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    private ProductServiceImpl $productService;
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM products");
        $this->productService = $this->app->make(ProductServiceImpl::class);
    }

    public function testSave()
    {
        self::assertDatabaseEmpty('products');

        $this->productService->save(
            name: 'example',
            sku: uniqid(),
            price: 100000,
            description: fake()->sentence(10),
            image: fake()->image()
        );

        self::assertDatabaseHas('products', [
            'name' => 'example',
            'price' => 100000
        ]);
    }

    public function testRemove()
    {
        $product = new Product([
            'name' => 'example',
            'sku' => uniqid(),
            'price' => 1000000,
            'description' => fake()->sentence(10),
            'image' => fake()->image()
        ]);
        $product->save();
        self::assertNotNull(Product::all());

        $product = Product::where('name', 'example')->first();
        $this->productService->removeProduct($product->id);
    }
}
