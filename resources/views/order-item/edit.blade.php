<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Item from Order #' . $orderItem->order_id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('order-item.update', $orderItem) }}" method="POST" class="max-w-xl">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="order_id" value="{{ $orderItem->order_id }}">

                        <div class="mb-4">
                            <x-input-label for="product_id" :value="__('Product')" />
                            <select name="product_id" id="product_id"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ $product->id == $orderItem->product_id ? 'selected' : '' }}>
                                        {{ $product->name }} (${{ number_format($product->price, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="quantity" :value="__('Quantity')" />
                            <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity"
                                value="{{ $orderItem->quantity }}" min="1" required />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="unit_price" :value="__('Unit Price')" />
                            <x-text-input id="unit_price" class="block mt-1 w-full" type="number" name="unit_price"
                                value="{{ $orderItem->unit_price }}" step="0.01" required />
                            <x-input-error :messages="$errors->get('unit_price')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Item') }}</x-primary-button>
                            <a href="{{ route('order.show', $orderItem->order_id) }}"
                                class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('product_id').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            if (price) {
                document.getElementById('unit_price').value = price;
            }
        });
    </script>
</x-app-layout>