<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'primaryimage'])->get();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        if ($request->hasFile('thumbnail')) {
            $product->images()->create([
                'image_path' => $request->file('thumbnail')->store('products', 'public'),
                'is_primary' => true
            ]);
        }

        $gallery = collect($request->file('gallery', []))->map(fn($img) => [
            'image_path' => $img->store('products', 'public'),
            'is_primary' => false
        ]);

        $product->images()->createMany($gallery->toArray());

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'images', 'primaryimage']);
        return view('product.show', compact('product'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');
        return view('product.edit', compact('product', 'categories'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {

        $product->update($request->validated());
        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->orderItems()->exists()) {
            return back()->with('error', 'Cannot delete! This product is linked to existing orders.');
        }
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('status_changed', 'Product visibility updated.');
    }
}
