<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Service\ServiceImpl\ProductServiceImpl;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    private ProductServiceImpl $productService;
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM products");
        $this->productService = $this->app->make(ProductServiceImpl::class);
    }

    public function testIndex()
    {
        $this->get('/product')->assertStatus(200)
            ->assertSee('Products');
    }

    public function testSave()
    {
        $this->get('/save')->assertStatus(200)
            ->assertSee('Save Product');
    }

    public function testStore()
    {
        $data = [
            'name' => 'example',
            'sku' => '12341234',
            'price' => 100000,
            'description' => 'description',
            'image' => UploadedFile::fake()->image('product.png') //gunakan UploadedFile karena form image harus file
        ];
        $this->post('/product', $data)->assertRedirect('/save');
        self::assertDatabaseHas('products', [
            'name' => 'example',
            'sku' => '12341234',
            'price' => 100_000,
            'description' => 'description'
        ]);
    }

    public function testUpdatePage()
    {
        $this->seed(ProductSeeder::class);
        $product = new Product([
            'id' => 1,
            'name' => 'example',
            'sku' => '1234',
            'price' => 100_000,
            'description' => 'description',
            'image' => UploadedFile::fake()->image('product.jpg')
        ]);
        $product->save();
        $this->get("/product/{$product->id}/edit")
            ->assertStatus(200)->assertSee('Update Product');
    }

    public function testDelete()
    {
        $this->seed(ProductSeeder::class);
        $product = Product::where('name', '=', 'example')->first();
        self::assertNotNull($product);
        self::assertDatabaseCount('products', 1);

        $this->delete("/product/{$product->id}/delete")
            ->assertRedirect(route('product.index'));

        self::assertDatabaseEmpty('products');
    }
}
