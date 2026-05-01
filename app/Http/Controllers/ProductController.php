<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;  // ← IDAGDAG ITO
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products   = Product::all();
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'  => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Product updated!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }
   public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string',
        'brand'    => 'required|string',
        'category' => 'required|string',
        'size'     => 'required|string',
        'price'    => 'required|numeric',
        'stock'    => 'required|integer',
    ]);

    Product::create([
        'product_code' => $request->product_code,
        'name'         => $request->name,
        'brand'        => $request->brand,
        'category'     => $request->category,
        'size'         => $request->size,
        'price'        => $request->price,
        'stock'        => $request->stock,
        'min_stock'    => $request->min_stock ?? 5,
        'supplier'     => $request->supplier,
    ]);

    return redirect()->route('products.index')->with('success', 'Product added!');
}

}