<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\ProductImage;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'primaryimage', 'tags'])->get();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = Category::all();
        $tags = Tag::all();
        return view('product.create', compact('categories', 'tags'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // validate request
        $validateData = $request->validated();



        // Create Product
        $product = Product::create([
            'category_id' => $validateData['category_id'],
            'name' => $validateData['name'],
            'price' => $validateData['price'],
            'stock_quantity' => $validateData['stock_quantity'],
            'description' => $validateData['description'],
            'is_active' => $validateData['is_active'],
        ]);

        // Sync tags
        $tags = $request->input('tags', []);
        $formattedTags = [];
        foreach ($tags as $tagId => $tagData) {
            if (isset($tagData['selected'])) {
                $formattedTags[$tagId] = [
                    'is_featured' => isset($tagData['is_featured'])
                ];
            }
        }
        $product->tags()->sync($formattedTags);


        // Check for thumbnail image
        if ($request->hasFile('thumbnail')) {
            // create thumbnail image
            $product->images()->create([
                'image_path' => $request->file('thumbnail')->store('products', 'public'),
                'is_primary' => true
            ]);
        }

        // Check for gallery image
        if ($request->hasFile('gallery')) {
            // Map gallery images
            $gallery = collect($request->file('gallery', []))->map(fn($img) => [
                'image_path' => $img->store('products', 'public'),
                // 'is_primary' => false
            ]);

            $product->images()->createMany($gallery->toArray());
        }

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        $categories = Category::all();
        $tags = Tag::all();
        $product->load(['images', 'tags']);
        return view('product.edit', compact('product', 'categories', 'tags'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        // validate request
        $validateData = $request->validated();

        // Update product
        $product->update([
            'category_id' => $validateData['category_id'],
            'name' => $validateData['name'],
            'price' => $validateData['price'],
            'stock_quantity' => $validateData['stock_quantity'],
            'description' => $validateData['description'],
            'is_active' => $validateData['is_active'],
        ]);

        // sync tag
        $tags = $request->input('tags', []);
        $formattedTags = [];
        foreach ($tags as $tagId => $tagData) {
            if (isset($tagData['selected'])) {
                $formattedTags[$tagId] = [
                    'is_featured' => isset($tagData['is_featured'])
                ];
            }
        }
        $product->tags()->sync($formattedTags);

        // Handle thumbnail update
        if ($request->hasFile('thumbnail')) {
            $newFile = $request->file('thumbnail');
            $thumbnailRecord = ProductImage::where('product_id', $product->id)
                ->where('is_primary', true)
                ->first();

            if ($thumbnailRecord) {
                $oldPath = $thumbnailRecord->image_path;
                $newFileHash = md5_file($newFile->getRealPath());
                $oldFileHash = Storage::disk('public')->exists($oldPath)
                    ? md5(Storage::disk('public')->get($oldPath))
                    : null;

                if ($newFileHash !== $oldFileHash) {
                    Storage::disk('public')->delete($oldPath);
                    $newPath = $newFile->store('products', 'public');
                    $thumbnailRecord->update(['image_path' => $newPath]);
                }
            }
        }

        // Handle gallery update
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $product->images()->create([
                    'image_path' => $img->store('products', 'public'),
                    'is_primary' => false
                ]);
            }
        }

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

    /**
     * Shop methods moved from GuestProductController
     */
    public function shopIndex()
    {
        $products = Product::with(['primaryimage', 'category', 'tags'])
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('guest.products.index', compact('products'));
    }

    public function shopShow(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        $product->load(['category', 'images', 'primaryimage', 'tags']);
        return view('guest.products.show', compact('product'));
    }

    public function addToOrder(Request $request, Product $product)
    {
        $order = Order::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 'pending'],
            ['shipping_address' => 'Update shipping address on checkout', 'subtotal' => 0, 'total' => 0]
        );

        $order->items()->create([
            'product_id' => $product->id,
            'quantity' => $request->input('quantity', 1),
            'unit_price' => $product->price,
            'total_price' => $product->price * $request->input('quantity', 1),
        ]);

        $order->syncTotals();

        return redirect()->route('order.show', $order->id)
            ->with('success', '✓ ' . $product->name . ' added to your cart.');
    }
}
