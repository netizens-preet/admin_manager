<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate(['images.*' => 'required|image|max:2048']);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->images()->create([
                    'image_path' => $image->store('products', 'public'),
                    'is_primary' => false
                ]);
            }
        }

        return back()->with('success', 'Images added to gallery.');
    }

    public function uploadThumbnail(Request $request, Product $product)
    {
        $request->validate(['thumbnail' => 'required|image|max:2048']);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('products', 'public');

            $primary = $product->primaryimage;
            if ($primary) {
                Storage::disk('public')->delete($primary->image_path);
                $primary->update(['image_path' => $path]);
            } else {
                $product->images()->update(['is_primary' => false]);
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => true
                ]);
            }
        }

        return back()->with('success', 'Thumbnail updated successfully.');
    }

    public function setPrimary(Product $product, ProductImage $image)
    {
        $product->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return back()->with('success', 'Primary image updated.');
    }

    public function destroy(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted.');
    }
}
