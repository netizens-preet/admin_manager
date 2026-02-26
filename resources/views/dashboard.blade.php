@php
    use App\Models\Product;
    use App\Models\Order;

    $totalProducts = Product::count();
    $totalOrders   = Order::count();
    $totalRevenue  = Order::where('status', 'delivered')->sum('total');
    $pendingOrders = Order::where('status', 'pending')->count();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Store Overview") }}
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg border-b-4 border-indigo-500">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Total Products</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalProducts }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg border-b-4 border-green-500">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Total Orders</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalOrders }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg border-b-4 border-yellow-500">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Total Revenue</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                        ${{ number_format($totalRevenue, 2) }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg border-b-4 border-red-500">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Pending Orders</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $pendingOrders }}</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
