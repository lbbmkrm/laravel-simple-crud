<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Service\ServiceImpl\ProductServiceImpl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private ProductServiceImpl $productService;
    public function __construct(ProductServiceImpl $productServiceImpl)
    {
        $this->productService = $productServiceImpl;
    }

    public function index(): Response
    {
        return response()->view('product.index', [
            'tittle' => 'Products',
            'products' => $this->productService->getAll()
        ]);
    }

    public function save(): Response
    {
        return response()->view('product.save', ['tittle' => 'Save Product']);
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => 'required',
            'sku' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return redirect()->route('product.save')->withErrors($validation);
        };

        $imagePath = null;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $imageName = $request->sku . '.' . $extension;
            $imagePath = $request->file('image')->storeAs('img', $imageName, 'public');
        }

        $this->productService->save(
            name: $request['name'],
            sku: $request['sku'],
            description: $request['description'],
            image: $imagePath,
            price: $request['price']
        );

        return redirect()->route('product.index')->with('success', 'Product saved successfully');
    }

    public function edit($id): Response
    {
        $product = Product::find($id);
        return response()->view('product.edit', [
            'tittle' => 'Update Product',
            'product' => $product
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $rules = [
            'name' => 'required',
            'sku' => 'required',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $product = Product::findOrFail($id);

        // Update data produk
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $imageName = $request->sku . '.' . $extension;
            $imagePath = $request->file('image')->storeAs('img', $imageName, 'public');
            $product->image = $imagePath;
        }

        $product->save();
        return redirect()->route('product.index')->with('success', 'Product update successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $this->productService->removeProduct($id);
        return redirect()->route('product.index')->with('success', 'Product delete successfully');
    }
}
