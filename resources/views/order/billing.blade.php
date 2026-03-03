<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('order.show', $order) }}" class="text-white hover:text-indigo-600 text-sm">← Back to
                Cart</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Billing — Order #{{ $order->id }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-300 rounded-lg text-red-700 text-sm">{{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LEFT: Billing Form --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Order Items Summary --}}
                    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2 text-gray-800">Order Items</h3>
                            <table class="min-w-full divide-y divide-gray-100 text-sm">
                                <thead>
                                    <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        <th class="pb-3">Product</th>
                                        <th class="pb-3">Qty</th>
                                        <th class="pb-3">Unit Price</th>
                                        <th class="pb-3 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td class="py-3 font-medium text-gray-900">
                                                {{ $item->product->name ?? 'Product Not Found' }}</td>
                                            <td class="py-3 text-gray-600">{{ $item->quantity }}</td>
                                            <td class="py-3 text-gray-600">${{ number_format($item->unit_price, 2) }}</td>
                                            <td class="py-3 text-right font-semibold text-gray-800">
                                                ${{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4 pt-4 border-t flex justify-between text-sm">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-semibold">${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-base font-bold mt-1">
                                <span>Total</span>
                                <span class="text-indigo-700">${{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Billing Form --}}
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <form action="{{ route('order.place', $order) }}" method="POST">
                            @csrf
                            <div class="p-6 space-y-6">
                                <h3 class="text-lg font-semibold border-b pb-2 text-gray-800">Shipping & Delivery</h3>

                                <div>
                                    <label for="shipping_address"
                                        class="block text-sm font-semibold text-gray-700 mb-1">
                                        Shipping Address <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="shipping_address" name="shipping_address" rows="3" required
                                        placeholder="Enter your full delivery address..."
                                        class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('shipping_address', $order->shipping_address !== 'Update shipping address on checkout' ? $order->shipping_address : '') }}</textarea>
                                    @error('shipping_address')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="note" class="block text-sm font-semibold text-gray-700 mb-1">
                                        Delivery Note <span class="text-gray-400 font-normal">(optional)</span>
                                    </label>
                                    <textarea id="note" name="note" rows="2"
                                        placeholder="E.g. leave at door, call on arrival..."
                                        class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('note', $order->note) }}</textarea>
                                </div>

                                <div class="pt-4 border-t">
                                    <button type="submit"
                                        class="w-full bg-indigo-600 text-white py-3 rounded-xl text-base font-bold hover:bg-indigo-700 shadow-lg transition-all tracking-wide uppercase">
                                        Place Order
                                    </button>
                                    <p class="text-center text-xs text-black mt-2">A confirmation email will be sent
                                        once your order is placed.</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- RIGHT: Order Status & Customer Card --}}
                <div class="space-y-6">

                    {{-- Order Status Timeline --}}
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2 text-gray-800">Order Status</h3>
                            @php
                                $statuses = [
                                    'pending' => ['label' => 'Draft'],
                                    'processing' => ['label' => 'Placed'],
                                    'shipped' => ['label' => 'Shipped'],
                                    'delivered' => ['label' => 'Delivered'],
                                ];
                                $currentStatusIndex = array_search($order->status->value, array_keys($statuses));
                            @endphp
                            <nav aria-label="Progress">
                                <ol role="list" class="space-y-4">
                                    @foreach($statuses as $key => $status)
                                        @php
                                            $isComplete = array_search($key, array_keys($statuses)) <= $currentStatusIndex;
                                            $isCurrent = $key === $order->status->value;
                                        @endphp
                                        <li class="relative flex items-center">
                                            <span class="flex items-center px-2 py-1 text-sm font-medium">
                                                <span
                                                    class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full {{ $isComplete ? 'bg-indigo-600 text-white' : 'border-2 border-gray-300 text-gray-400' }}">
                                                    @if($isComplete)
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    @else
                                                        <span class="text-xs font-bold">{{ $loop->iteration }}</span>
                                                    @endif
                                                </span>
                                                <span class="ml-4 flex flex-col">
                                                    <span
                                                        class="text-xs font-semibold tracking-wide uppercase {{ $isComplete ? 'text-indigo-600' : 'text-gray-500' }}">
                                                        {{ $status['label'] }}
                                                    </span>
                                                    @if($isCurrent)
                                                        <span class="text-[10px] text-gray-500">Active Stage</span>
                                                    @endif
                                                </span>
                                            </span>
                                        </li>
                                    @endforeach
                                </ol>
                            </nav>
                        </div>
                    </div>

                    {{-- Customer Details --}}
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2 text-gray-800">Customer Details</h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $order->user->name }}</p>
                                        <p class="text-gray-500">{{ $order->user->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 pt-1">
                                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-bold
                                        {{ $order->status->value === 'delivered' ? 'bg-green-100 text-green-800' : ($order->status->value === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </div>
                                <div class="pt-2 border-t text-xs text-gray-500">
                                    <p><span class="font-semibold text-gray-600">Order ID:</span> #{{ $order->id }}</p>
                                    <p class="mt-1"><span class="font-semibold text-gray-600">Date:</span>
                                        {{ $order->created_at->format('M d, Y') }}</p>
                                    <p class="mt-1"><span class="font-semibold text-gray-600">Items:</span>
                                        {{ $order->items->count() }} item(s)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>