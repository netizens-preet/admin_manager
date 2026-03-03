<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $product->name }}
            </h2>
            <a href="{{ route('product.index') }}"
                class="text-gray-600 hover:text-gray-900 border border-gray-300 px-4 py-2 rounded text-sm transition">Back
                to Products</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 border border-gray-100 dark:border-gray-700">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Left: Images Section -->
                    <div class="space-y-6">
                        <!-- Main Thumbnail -->
                        <div
                            class="aspect-square w-full rounded-2xl overflow-hidden border-2 border-indigo-100 shadow-md">
                            <img src="{{ $product->primaryimage ? asset('storage/' . $product->primaryimage->image_path) : asset('placeholder.jpg') }}"
                                class="w-full h-full object-cover tray-image" id="main-product-image">
                        </div>

                        <!-- Gallery Grid -->
                        @if($product->images->count() > 0)
                            <div class="grid grid-cols-4 gap-4">
                                @foreach($product->images as $image)
                                    <div class="aspect-square cursor-pointer rounded-lg overflow-hidden border transition hover:border-indigo-500 {{ $image->is_primary ? 'border-indigo-600' : 'border-gray-200' }}"
                                        onclick="document.getElementById('main-product-image').src = '{{ asset('storage/' . $image->image_path) }}'">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Right: Product Info -->
                    <div class="flex flex-col">
                        <div class="mb-4">
                            <span
                                class="px-3 py-1 text-xs font-semibold bg-indigo-100 text-indigo-700 rounded-full uppercase tracking-wider">
                                {{ $product->category->name }}
                            </span>
                        </div>

                        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">{{ $product->name }}</h1>

                        <div class="flex items-baseline gap-4 mb-6">
                            <span
                                class="text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</span>
                            <span
                                class="text-sm font-medium {{ $product->stock_quantity > 0 ? 'text-green-600' : 'text-red-500' }}">
                                {{ $product->stock_quantity > 0 ? 'In Stock (' . $product->stock_quantity . ' units)' : 'Out of Stock' }}
                            </span>
                        </div>

                        <div class="prose dark:prose-invert max-w-none mb-8 text-gray-600 dark:text-gray-400">
                            <h3 class="text-lg font-semibold mb-2">Description</h3>
                            <p>{{ $product->description ?: 'No description available for this product.' }}</p>
                        </div>

                        <div class="mt-auto pt-8 border-t border-gray-100 dark:border-gray-700 grid grid-cols-2 gap-4">
                            <a href="{{ route('product.edit', $product->id) }}"
                                class="flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition">
                                Edit Product
                            </a>
                            <button
                                class="flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                                Share Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>