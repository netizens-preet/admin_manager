<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(ProductImageRequest $request, Product $product)
    {
        $Images = $product->images()->count() === 0;

        $images = collect($request->file('images', []))->map(fn($file, $index) => [  //index means position of that image check wether it is primary or not
            'image_path' => $file->store('products', 'public'),
            'is_primary' => $Images && $index === 0,
        ]);

        $product->images()->createMany($images->toArray());

        return back()->with('success', 'Images uploaded successfully.');
    }

    public function update(ProductImageRequest $request, ProductImage $image)
    {
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($image->image_path);
            $image->update([
                'image_path' => $request->file('image')->store('products', 'public')
            ]);
        }

        return back()->with('success', 'Image updated.');
    }

    public function destroy(ProductImage $image)
    {
        if ($image->is_primary && $image->product->images()->count() > 1) {
            return back()->with('error', 'Set another image as primary before deleting this one.');
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image removed.');
    }

    public function setPrimary(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id)
            abort(403);

        $product->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return back()->with('success', 'Primary image updated.');
    }
}
