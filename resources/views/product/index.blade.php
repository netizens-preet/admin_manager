<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Products</h2>
            <a href="{{ route('product.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs uppercase">Add
                Product</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3">Image</th>
                            <th class="px-6 py-3">Product Info</th>
                            <th class="px-6 py-3">Price</th>
                            <th class="px-6 py-3">Stock</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($products as $product)
                            <tr>
                                <td class="px-6 py-4">
                                    <a href="{{ route('product.show', $product->id) }}">
                                        <img src="{{ $product->primaryimage ? asset('storage/' . $product->primaryimage->image_path) : asset('placeholder.jpg') }}"
                                            class="w-16 h-16 rounded shadow-sm object-cover hover:opacity-75 transition">
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('product.show', $product->id) }}"
                                        class="hover:text-indigo-600 transition">
                                        <div class="font-bold text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
                                    </a>
                                    <div class="text-xs text-gray-500">{{ $product->category->name }}</div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-800 dark:text-gray-200">
                                    ${{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs rounded {{ $product->stock_quantity > 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->stock_quantity }} in stock
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('product.toggleStatus', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 text-xs rounded-full border transition {{ $product->is_active ? 'bg-green-500 text-white border-green-600' : 'bg-gray-200 text-gray-600 border-gray-300' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('product.edit', $product->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium"
                                            onclick="return confirm('Delete this product?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>