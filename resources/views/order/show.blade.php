<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Details #' . $order->id) }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('order.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded text-sm hover:bg-gray-600">Back to List</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Order Information -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold">Order Items</h3>
                                @if($order->status->value === 'pending' && auth()->user()->id === $order->user_id)
                                    <a href="{{ route('guest.products.index') }}"
                                        class="text-sm bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">+ Add
                                        Item</a>
                                @endif
                            </div>

                            @if($order->status->value === 'pending')
                                <div
                                    class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg flex items-center justify-between">
                                    <div>
                                        <h4 class="text-yellow-800 font-bold">This is a Draft Order</h4>
                                        <p class="text-yellow-700 text-sm">It will not appear in the main orders list until
                                            you place it.</p>
                                    </div>
                                    @if(auth()->user()->id === $order->user_id)
                                        <a href="{{ route('order.billing', $order) }}"
                                            class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-indigo-700 shadow-lg transition-all">
                                            Proceed to Billing
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="text-left py-2">Product</th>
                                        <th class="text-left py-2">Qty</th>
                                        <th class="text-left py-2">Price</th>
                                        <th class="text-left py-2">Total</th>
                                        @if($order->status->value === 'pending' && auth()->user()->id === $order->user_id)
                                            <th class="text-right py-2">Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td class="py-3">{{ $item->product->name ?? 'Product Not Found' }}</td>
                                            <td class="py-3">{{ $item->quantity }}</td>
                                            <td class="py-3">${{ number_format($item->unit_price, 2) }}</td>
                                            <td class="py-3 font-medium">${{ number_format($item->total_price, 2) }}</td>
                                            @if($order->status->value === 'pending' && auth()->user()->id === $order->user_id)
                                                <td class="py-3 text-right text-sm">
                                                    <a href="{{ route('order-item.edit', $item) }}"
                                                        class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                    <form action="{{ route('order-item.destroy', $item) }}" method="POST"
                                                        class="inline ml-2" onsubmit="return confirm('Remove this item?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900">Remove</button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-6 text-right border-t pt-4">
                                <p class="text-gray-600">Subtotal: ${{ number_format($order->subtotal, 2) }}</p>
                                <p class="text-2xl font-bold mt-1">Total: ${{ number_format($order->total, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="space-y-6">
                    <!-- Order Status Timeline -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Order Status</h3>
                            <div class="relative">
                                @php
                                    $statuses = [
                                        'pending' => ['label' => 'Draft', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                        'processing' => ['label' => 'Placed', 'icon' => 'M5 13l4 4L19 7'],
                                        'shipped' => ['label' => 'Shipped', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                                        'delivered' => ['label' => 'Delivered', 'icon' => 'M5 13l4 4L19 7'],
                                    ];
                                    $currentStatusIndex = array_search($order->status->value, array_keys($statuses));
                                    if ($order->status->value === 'cancelled')
                                        $currentStatusIndex = -1;
                                @endphp

                                @if($order->status->value === 'cancelled')
                                    <div class="flex items-center text-red-600 bg-red-50 p-3 rounded-lg">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-bold">ORDER CANCELLED</span>
                                    </div>
                                @else
                                    <nav aria-label="Progress">
                                        <ol role="list" class="space-y-4">
                                            @foreach($statuses as $key => $status)
                                                @php
                                                    $isComplete = array_search($key, array_keys($statuses)) <= $currentStatusIndex;
                                                    $isCurrent = $key === $order->status->value;
                                                @endphp
                                                <li class="relative flex items-center group">
                                                    <span class="flex items-center px-4 py-2 text-sm font-medium">
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
                                                                class="text-xs font-semibold tracking-wide uppercase {{ $isComplete ? 'text-indigo-600' : 'text-gray-500' }}">{{ $status['label'] }}</span>
                                                            @if($isCurrent)
                                                                <span class="text-[10px] text-gray-500 font-normal">Active
                                                                    Stage</span>
                                                            @endif
                                                        </span>
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </nav>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Customer & Shipping -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Customer & Shipping</h3>
                            <div class="space-y-3 text-sm">
                                <p><strong>Name:</strong> {{ $order->user->name }}</p>
                                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                                <p><strong>Status:</strong>
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-bold {{ $order->status->value === 'delivered' ? 'bg-green-100 text-green-800' : ($order->status->value === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </p>
                                <div class="mt-4">
                                    <strong>Shipping Address:</strong>
                                    <p class="text-gray-600 mt-1 whitespace-pre-line">{{ $order->shipping_address }}</p>
                                </div>
                                @if($order->note)
                                    <div class="mt-4">
                                        <strong>Notes:</strong>
                                        <p class="text-gray-600 mt-1 italic">"{{ $order->note }}"</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->isAdmin())
                        <!-- Admin Actions -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 border-b pb-2 text-indigo-600">Admin Actions</h3>

                                <!-- Update Status Form -->
                                <div class="mt-6 border-gray-100">
                                    <h4 class="text-sm font-bold mb-3">Update Status</h4>
                                    <form action="{{ route('order.update', $order) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <div class="space-y-4">
                                            <select name="status" class="w-full border-gray-300 rounded-md shadow-sm" {{ $order->status->value === 'cancelled' ? 'disabled' : '' }}>
                                                <option value="pending" {{ $order->status->value == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="processing" {{ $order->status->value == 'processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="shipped" {{ $order->status->value == 'shipped' ? 'selected' : '' }}>
                                                    Shipped</option>
                                                <option value="delivered" {{ $order->status->value == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            </select>
                                            @if($order->status->value !== 'cancelled')
                                                <button type="submit"
                                                    class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 text-sm font-bold uppercase transition">
                                                    Apply Status Update
                                                </button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Customer Member Actions -->
                        @if(!in_array($order->status->value, ['delivered', 'cancelled']))
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold mb-4 border-b pb-2 text-red-600">Manage Order</h3>
                                    <form action="{{ route('order.cancel', $order) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 text-sm font-bold">
                                            Cancel Order
                                        </button>
                                        <p class="text-[10px] text-gray-500 mt-2 italic text-center">Note: Orders cannot be
                                            cancelled once delivered.</p>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>