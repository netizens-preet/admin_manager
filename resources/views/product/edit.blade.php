<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="md:col-span-2">
                <form action="{{ route('product.update', $product->id) }}" method="POST" class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-100 dark:border-gray-700 mb-8">
                    @csrf @method('PUT')
                    <h3 class="text-xl font-bold mb-6 text-gray-900 dark:text-gray-100 border-b pb-2">Edit Product Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <x-input-label for="name" :value="__('Product Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product->name)" required />
                        </div>

                        <div>
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select name="category_id" class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="price" :value="__('Price ($)')" />
                            <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" :value="old('price', $product->price)" required />
                        </div>

                        <div>
                            <x-input-label for="stock_quantity" :value="__('Stock Quantity')" />
                            <x-text-input id="stock_quantity" name="stock_quantity" type="number" class="mt-1 block w-full" :value="old('stock_quantity', $product->stock_quantity)" required />
                        </div>

                        <div>
                            <x-input-label for="is_active" :value="__('Status')" />
                            <select name="is_active" class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm">
                                <option value="1" {{ $product->is_active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm" rows="4">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <x-primary-button class="w-full justify-center py-3">Update Product Details</x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-100 dark:border-gray-700">
                <h3 class="text-xl font-bold mb-6 text-gray-900 dark:text-gray-100 border-b pb-2">Product Images</h3>

                <div class="mb-8">
                    <h4 class="text-sm font-semibold mb-3 text-gray-600 dark:text-gray-400">Add More Images</h4>
                    <form action="{{ route('product-images.store', $product->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3">
                        @csrf
                        <input type="file" name="images[]" multiple class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" required>
                        <x-secondary-button type="submit" class="justify-center">Upload to Gallery</x-secondary-button>
                    </form>
                </div>

                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-400">Current Gallery</h4>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($product->images as $image)
                            <div class="relative group aspect-square">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-full object-cover rounded-lg border-2 {{ $image->is_primary ? 'border-indigo-600' : 'border-transparent' }}">
                                
                                @if($image->is_primary)
                                    <span class="absolute top-2 left-2 bg-indigo-600 text-white text-[10px] px-2 py-0.5 rounded shadow">Primary</span>
                                @else
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition rounded-lg flex items-center justify-center gap-2">
                                        <form action="{{ route('product-images.primary', [$product->id, $image->id]) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="bg-white text-gray-900 text-[10px] font-bold px-2 py-1 rounded hover:bg-indigo-50 transition">Set Primary</button>
                                        </form>
                                        <form action="{{ route('product-images.destroy', $image->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded hover:bg-red-700 transition" onclick="return confirm('Remove image?')">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
