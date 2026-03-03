<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="md:col-span-2">
                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                    class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 mb-8 space-y-8">
                    @csrf @method('PUT')
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 border-b dark:border-gray-700 pb-3">
                        Edit Product Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <x-input-label for="name" :value="__('Product Name')"
                                class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                            <x-text-input id="name" name="name" type="text"
                                class="block w-full border-gray-200 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500"
                                :value="old('name', $product->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="category_id" :value="__('Category')"
                                class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                            <select name="category_id"
                                class="w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="price" :value="__('Price ($)')"
                                class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                            <x-text-input id="price" name="price" type="number" step="0.01"
                                class="block w-full border-gray-200 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500"
                                :value="old('price', $product->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="stock_quantity" :value="__('Stock Quantity')"
                                class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                            <x-text-input id="stock_quantity" name="stock_quantity" type="number"
                                class="block w-full border-gray-200 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500"
                                :value="old('stock_quantity', $product->stock_quantity)" required />
                            <x-input-error :messages="$errors->get('stock_quantity')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="is_active" :value="__('Status')"
                                class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                            <select name="is_active"
                                class="w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">
                                <option value="1" {{ old('is_active', $product->is_active) ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ !old('is_active', $product->is_active) ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="description" :value="__('Description')"
                                class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                            <textarea id="description" name="description"
                                class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                rows="4">{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-1" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label :value="__('Product Tags')"
                                class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                            <div
                                class="grid grid-cols-2 sm:grid-cols-3 gap-4 p-5 bg-gray-50/50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-700">
                                @foreach($tags as $tag)
                                    @php
                                        $attachedTag = $product->tags->where('id', $tag->id)->first();
                                        $isAttached = (bool) $attachedTag;
                                        $isFeatured = $attachedTag ? (bool) $attachedTag->pivot->is_featured : false;
                                    @endphp
                                    <div
                                        class="flex flex-col gap-2 p-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 hover:border-blue-500 transition">
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" name="tags[{{ $tag->id }}][selected]"
                                                id="tag_{{ $tag->id }}" value="1"
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                                {{ $isAttached ? 'checked' : '' }}>
                                            <label for="tag_{{ $tag->id }}"
                                                class="text-sm font-bold text-gray-700 dark:text-gray-300 cursor-pointer">{{ $tag->name }}</label>
                                        </div>
                                        <div class="flex items-center gap-2 pl-6">
                                            <input type="checkbox" name="tags[{{ $tag->id }}][is_featured]"
                                                id="featured_{{ $tag->id }}" value="1"
                                                class="rounded-full w-3 h-3 border-gray-300 text-amber-500 shadow-sm focus:ring-amber-500 cursor-pointer"
                                                {{ $isFeatured ? 'checked' : '' }}>
                                            <label for="featured_{{ $tag->id }}"
                                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest cursor-pointer">Featured</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div
                            class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t dark:border-gray-700">
                            <div>
                                <x-input-label for="thumbnail" :value="__('Update Primary Thumbnail')"
                                    class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                                <input type="file" id="thumbnail" name="thumbnail"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:uppercase file:tracking-wider file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                                <x-input-error :messages="$errors->get('thumbnail')" class="mt-1" />
                            </div>
                            <div>
                                <x-input-label for="gallery" :value="__('Add to Gallery')"
                                    class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                                <input type="file" id="gallery" name="gallery[]" multiple
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:uppercase file:tracking-wider file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                                <x-input-error :messages="$errors->get('gallery')" class="mt-1" />
                            </div>
                        </div>

                        <div
                            class="md:col-span-2 pt-8 flex items-center justify-end gap-4 border-t dark:border-gray-700">
                            <a href="{{ route('product.index') }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                                Cancel
                            </a>
                            <x-primary-button
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow-lg font-bold uppercase tracking-widest transition">
                                Update Product details
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 h-fit">
                <h3 class="text-xl font-bold mb-6 text-gray-900 dark:text-gray-100 border-b dark:border-gray-700 pb-3">
                    Product Images</h3>

                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">Current
                        Gallery</h4>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($product->images as $image)
                            <div class="relative group aspect-square">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                    class="w-full h-full object-cover rounded-xl border-4 {{ $image->is_primary ? 'border-blue-600' : 'border-transparent' }} shadow-md">

                                @if($image->is_primary)
                                    <span
                                        class="absolute -top-2 -left-2 bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded shadow-lg">Primary</span>
                                @else
                                    <div
                                        class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition rounded-xl flex flex-col items-center justify-center gap-2 p-2">
                                        <form action="{{ route('product-images.primary', [$product->id, $image->id]) }}"
                                            method="POST" class="w-full">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="w-full bg-white text-gray-900 text-[10px] font-black uppercase tracking-widest py-1.5 rounded hover:bg-blue-50 transition">Set
                                                Primary</button>
                                        </form>
                                        <form action="{{ route('product-images.destroy', $image->id) }}" method="POST"
                                            class="w-full">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="w-full bg-red-600 text-white text-[10px] font-black uppercase tracking-widest py-1.5 rounded hover:bg-red-700 transition"
                                                onclick="return confirm('Remove image?')">Delete</button>
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