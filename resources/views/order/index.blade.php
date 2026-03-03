<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()->isAdmin() ? __('Manage Orders') : __('Order History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 uppercase text-xs font-semibold text-gray-600 tracking-wider">
                                <tr>
                                    <th class="px-6 py-4 text-left">Order ID</th>
                                    @if(auth()->user()->isAdmin())
                                        <th class="px-6 py-4 text-left">Customer</th>
                                    @endif
                                    <th class="px-6 py-4 text-left">Total</th>
                                    <th class="px-6 py-4 text-left">Status</th>
                                    <th class="px-6 py-4 text-left">Created At</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">
                                            #{{ $order->id }}
                                        </td>
                                        @if(auth()->user()->isAdmin())
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-l-0">
                                                <div class="font-medium">{{ $order->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            ${{ number_format($order->total, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full 
                                                                                {{ $order->status->value === 'delivered' ? 'bg-green-100 text-green-700' : ($order->status->value === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                                {{ $order->status->label() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end items-center space-x-3">
                                                <a href="{{ route('order.show', $order) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 underline decoration-indigo-200 underline-offset-4">Details</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">No orders found.
                                            Start by creating one!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>