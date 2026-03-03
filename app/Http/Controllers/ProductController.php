<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // if (!auth()->user()->isAdmin())
        //     abort(403);
        $categories = Category::all();
        $tags = Tag::all();
        return view('product.create', compact('categories', 'tags'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());
        $product->tags()->sync($request->tags ?? []);

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
        // if (!auth()->user()->isAdmin())
        //     abort(403);
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
        // if (!auth()->user()->isAdmin())
        //     abort(403);

        $product->update($request->validated());
        $product->tags()->sync($request->tags ?? []);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // if (!auth()->user()->isAdmin())
        //     abort(403);
        if ($product->orderItems()->exists()) {
            return back()->with('error', 'Cannot delete! This product is linked to existing orders.');
        }
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }
    public function toggleStatus(Product $product)
    {
        // if (!auth()->user()->isAdmin())
        //     abort(403);
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
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$order) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
                'subtotal' => 0,
                'total' => 0,
                'shipping_address' => 'Update shipping address on checkout',
            ]);
        }

        $order->items()->create([
            'product_id' => $product->id,
            'quantity' => $request->input('quantity', 1),
            'unit_price' => $product->price,
            'total_price' => $product->price * $request->input('quantity', 1),
        ]);

        $newTotal = $order->items()->sum('total_price');
        $order->update([
            'subtotal' => $newTotal,
            'total' => $newTotal,
        ]);

        return redirect()->route('order.show', $order->id)
            ->with('success', '✓ ' . $product->name . ' added to your cart.');
    }
}
