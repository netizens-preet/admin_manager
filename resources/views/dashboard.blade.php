<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 rounded-lg p-8 mb-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

               <div class="bg-blue-50 dark:bg-blue-900/20 p-6 shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Total Products</h3>
                    <p class="mt-2 text-3xl font-bold dark:text-gray-100">{{ $totalProducts }}</p>
                </div>

                <div class="bg-green-50 dark:bg-green-900/20 p-6 shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Total Orders</h3>
                    <p class="mt-2 text-3xl font-bold dark:text-gray-100">{{ $totalOrders }}</p>
                </div>

                <div class="bg-purple-50 dark:bg-purple-900/20 p-6 shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Total Revenue</h3>
                    <p class="mt-2 text-3xl font-bold dark:text-gray-100">
                        ${{ number_format($totalRevenue, 2) }}
                    </p>
                </div>

                <div class="bg-orange-50 dark:bg-orange-900/20 p-6 shadow-sm sm:rounded-lg border-l-4 border-orange-500">
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Pending Orders</h3>
                    <p class="mt-2 text-3xl font-bold dark:text-gray-100">{{ $pendingOrders }}</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
