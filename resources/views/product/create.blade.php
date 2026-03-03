<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 space-y-8">
                @csrf
                
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 border-b dark:border-gray-700 pb-3">Product Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2">
                        <x-input-label for="name" :value="__('Product Name')" class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                        <x-text-input id="name" name="name" type="text" class="block w-full border-gray-200 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500" :value="old('name')"
                            required />
                    </div>

                    <div>
                        <x-input-label for="category_id" :value="__('Category')" class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                        <select name="category_id"
                            class="w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="price" :value="__('Price ($)')" class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                        <x-text-input id="price" name="price" type="number" step="0.01" class="block w-full border-gray-200 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500"
                            :value="old('price')" required />
                    </div>

                    <div>
                        <x-input-label for="stock_quantity" :value="__('Stock Quantity')" class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                        <x-text-input id="stock_quantity" name="stock_quantity" type="number" class="block w-full border-gray-200 dark:border-gray-700 rounded-lg shadow-sm focus:ring-blue-500"
                            :value="old('stock_quantity')" required />
                    </div>

                    <div>
                        <x-input-label for="is_active" :value="__('Status')" class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                        <select name="is_active"
                            class="w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="description" :value="__('Description')" class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                        <textarea id="description" name="description"
                            class="block w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            rows="4">{{ old('description') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label :value="__('Product Tags')" class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                        <div
                            class="grid grid-cols-2 sm:grid-cols-3 gap-4 p-5 bg-gray-50/50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-700">
                            @foreach($tags as $tag)
                                <div
                                    class="flex flex-col gap-2 p-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 hover:border-blue-500 transition">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="tags[{{ $tag->id }}][selected]" id="tag_{{ $tag->id }}"
                                            value="1"
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                        <label for="tag_{{ $tag->id }}"
                                            class="text-sm font-bold text-gray-700 dark:text-gray-300 cursor-pointer">{{ $tag->name }}</label>
                                    </div>
                                    <div class="flex items-center gap-2 pl-6">
                                        <input type="checkbox" name="tags[{{ $tag->id }}][is_featured]"
                                            id="featured_{{ $tag->id }}"
                                            value="1"
                                            class="rounded-full w-3 h-3 border-gray-300 text-amber-500 shadow-sm focus:ring-amber-500 cursor-pointer">
                                        <label for="featured_{{ $tag->id }}"
                                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest cursor-pointer">Featured</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <h3 class="md:col-span-2 text-xl font-bold text-gray-900 dark:text-gray-100 border-b dark:border-gray-700 pb-3 mt-4">Product Media</h3>

                    <div>
                        <x-input-label for="thumbnail" :value="__('Thumbnail (Primary Image)')" class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                        <input id="thumbnail" name="thumbnail" type="file"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:uppercase file:tracking-wider file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition"
                            required />
                    </div>

                    <div>
                        <x-input-label for="gallery" :value="__('Gallery Images (Optional)')" class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" />
                        <input id="gallery" name="gallery[]" type="file" multiple
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:uppercase file:tracking-wider file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition" />
                    </div>

                    <div class="md:col-span-2 pt-8 flex items-center justify-end gap-4 border-t dark:border-gray-700">
                        <a href="{{ route('product.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                            Cancel
                        </a>
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow-lg font-bold uppercase tracking-widest transition">
                            {{ __('Create Product') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>