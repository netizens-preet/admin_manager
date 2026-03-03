<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Order #' . $order->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-sm">
                    <form action="{{ route('order.update', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer Selection -->
                            <div>
                                <x-input-label for="user_id" :value="__('Customer')" />
                                <select name="user_id" id="user_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select name="status" id="status"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Shipping Address -->
                            <div class="md:col-span-2">
                                <x-input-label for="shipping_address" :value="__('Shipping Address')" />
                                <textarea name="shipping_address" id="shipping_address" rows="3"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                                <x-input-error :messages="$errors->get('shipping_address')" class="mt-2" />
                            </div>

                            <!-- Finacials -->
                            <div>
                                <x-input-label for="subtotal" :value="__('Subtotal')" />
                                <x-text-input id="subtotal" class="block mt-1 w-full" type="number" name="subtotal"
                                    :value="old('subtotal', $order->subtotal)" step="0.01" required />
                                <x-input-error :messages="$errors->get('subtotal')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="total" :value="__('Total')" />
                                <x-text-input id="total" class="block mt-1 w-full" type="number" name="total"
                                    :value="old('total', $order->total)" step="0.01" required />
                                <x-input-error :messages="$errors->get('total')" class="mt-2" />
                            </div>

                            <!-- Note -->
                            <div class="md:col-span-2">
                                <x-input-label for="note" :value="__('Order Note')" />
                                <textarea name="note" id="note" rows="2"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('note', $order->note) }}</textarea>
                                <x-input-error :messages="$errors->get('note')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-4">
                            <a href="{{ route('order.show', $order) }}"
                                class="text-gray-600 hover:text-gray-900">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Order Details') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-6 bg-yellow-50 p-4 rounded-lg text-yellow-800 text-sm border-l-4 border-yellow-400">
                <strong>Warning:</strong> Changing the status manually here will trigger the status transition rules and
                email notifications. To manage specific items, use the "Details" dashboard.
            </div>
        </div>
    </div>
</x-app-layout>