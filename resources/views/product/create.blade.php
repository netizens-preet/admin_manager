<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-100 dark:border-gray-700">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input-label for="name" :value="__('Product Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')"
                            required />
                    </div>

                    <div>
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select name="category_id"
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="price" :value="__('Price ($)')" />
                        <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full"
                            :value="old('price')" required />
                    </div>

                    <div>
                        <x-input-label for="stock_quantity" :value="__('Stock Quantity')" />
                        <x-text-input id="stock_quantity" name="stock_quantity" type="number" class="mt-1 block w-full"
                            :value="old('stock_quantity')" required />
                    </div>

                    <div>
                        <x-input-label for="is_active" :value="__('Status')" />
                        <select name="is_active"
                            class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <x-input-label for="thumbnail" :value="__('Thumbnail (Primary Image)')" />
                        <input id="thumbnail" name="thumbnail" type="file"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                            required />
                    </div>

                    <div>
                        <x-input-label for="gallery" :value="__('Gallery Images')" />
                        <input id="gallery" name="gallery[]" type="file" multiple
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                    </div>

                    <div class="md:col-span-2 pt-4">
                        <x-primary-button
                            class="w-full justify-center py-3">{{ __('Create Product') }}</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>