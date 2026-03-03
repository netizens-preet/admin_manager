<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ auth()->user()->isAdmin() ? __('Admin Dashboard') : __('My Experience') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(auth()->user()->isAdmin())
                <!-- Admin Dashboard Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Products -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-blue-500">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500 uppercase">Total Products</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalProducts }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Orders -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-green-500">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500 uppercase">Total Orders</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalOrders }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Revenue -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-purple-500">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500 uppercase">Total Revenue</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($totalRevenue, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Customers -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-orange-500">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900/40 text-orange-600 dark:text-orange-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500 uppercase">Customers</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalCustomers }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Global Recent Orders -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">Recent Global Activity</h3>
                            <a href="{{ route('order.index') }}" class="text-sm text-indigo-600 font-semibold italic">Orders List →</a>
                        </div>
                        <div class="overflow-x-auto text-sm">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 dark:bg-gray-900/50 text-xs text-gray-500 uppercase">
                                    <tr>
                                        <th class="px-4 py-3">Order</th>
                                        <th class="px-4 py-3">Customer</th>
                                        <th class="px-4 py-3 text-right">Total</th>
                                        <th class="px-4 py-3 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach($recentOrders as $order)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                            <td class="px-4 py-4 font-bold text-indigo-600">#{{ $order->id }}</td>
                                            <td class="px-4 py-4">{{ $order->user->name }}</td>
                                            <td class="px-4 py-4 text-right font-bold">${{ number_format($order->total, 2) }}</td>
                                            <td class="px-4 py-4 text-center">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Managed Products -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">Recent Inventory</h3>
                            <a href="{{ route('product.index') }}" class="text-sm text-indigo-600 font-semibold italic">Products →</a>
                        </div>
                        <div class="p-6 space-y-4">
                            @foreach($recentProducts as $product)
                                <div class="flex items-center justify-between p-3 border dark:border-gray-700 rounded-xl">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 bg-indigo-50 dark:bg-indigo-900 rounded-lg flex items-center justify-center font-bold text-indigo-600">{{ substr($product->name, 0, 1) }}</div>
                                        <div class="ml-3">
                                            <div class="text-sm font-bold dark:text-white">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-400">Stock: {{ $product->stock_quantity ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-bold dark:text-white">${{ number_format($product->price, 2) }}</div>
                                        <div class="text-[10px] text-gray-500 uppercase font-bold">{{ $product->category->name ?? 'None' }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Featured Products Section -->
                    <div class="bg-indigo-900 dark:bg-indigo-950 overflow-hidden shadow-2xl sm:rounded-lg lg:col-span-2 text-white border-t-8 border-amber-500">
                        <div class="p-8 border-b border-white/10 flex justify-between items-center">
                            <div>
                                <h3 class="text-2xl font-black tracking-tight">⭐ Featured Product Selection</h3>
                                <p class="text-indigo-300 text-sm font-medium mt-1">Inventory marked with featured tags for promotional highlights.</p>
                            </div>
                            <div class="px-4 py-2 bg-amber-500 text-indigo-950 rounded-full font-bold text-xs uppercase animate-bounce">Top Picks</div>
                        </div>
                        <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($featuredInventory as $product)
                                <div class="bg-white/5 border border-white/10 p-5 rounded-2xl hover:bg-white/10 transition group cursor-pointer">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($product->tags as $tag)
                                                @if($tag->pivot->is_featured)
                                                    <span class="px-2 py-0.5 bg-amber-500 text-indigo-950 text-[8px] font-black rounded-full uppercase tracking-widest">{{ $tag->name }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                        <h4 class="text-lg font-black">${{ number_format($product->price, 2) }}</h4>
                                    </div>
                                    <div class="mb-4 aspect-square bg-indigo-800 rounded-xl overflow-hidden relative">
                                        @if($product->primaryimage)
                                            <img src="{{ Storage::url($product->primaryimage->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/80 to-transparent flex items-end p-4">
                                            <span class="text-sm font-bold truncate">{{ $product->name }}</span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-indigo-300 font-bold uppercase tracking-tighter">{{ $product->category->name ?? 'General' }}</span>
                                        <a href="{{ route('product.edit', $product) }}" class="p-2 bg-indigo-500 hover:bg-indigo-400 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-12 text-center text-indigo-400 font-bold italic border-2 border-dashed border-white/10 rounded-2xl">
                                    No products are currently marked as featured.
                                </div>
                            @endforelse
                        </div>
                    </div>

            @else
                <!-- Customer Dashboard Section -->
                <div class="mb-8 p-8 bg-gradient-to-br from-indigo-700 via-indigo-600 to-purple-700 rounded-3xl shadow-xl text-white relative overflow-hidden group">
                    <div class="relative z-10">
                        <h3 class="text-3xl font-black mb-2 tracking-tight">Bonjour, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-indigo-100 text-lg opacity-90 max-w-lg font-medium leading-relaxed">
                            Welcome to your personalized portal. Track your orders, view your history, and find your next favorite items.
                        </p>
                        <div class="mt-8 flex space-x-4">
                            <a href="{{ route('guest.products.index') }}" class="bg-white text-indigo-600 px-6 py-3 rounded-xl font-bold hover:bg-indigo-50 transition-colors shadow-lg">Start Shopping</a>
                            <a href="{{ route('order.index') }}" class="bg-indigo-500/30 border border-indigo-400/30 px-6 py-3 rounded-xl font-bold hover:bg-indigo-500/50 transition-colors">Order History</a>
                        </div>
                    </div>
                </div>

                <!-- Personal Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-bold uppercase tracking-widest mb-1">Total Orders</p>
                            <p class="text-4xl font-black text-gray-900">{{ $myOrdersCount }}</p>
                        </div>
                        <div class="h-16 w-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                    </div>
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-bold uppercase tracking-widest mb-1">Lifetime Spent</p>
                            <p class="text-4xl font-black text-gray-900">${{ number_format($myTotalSpent, 2) }}</p>
                        </div>
                        <div class="h-16 w-16 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Prominent Featured Products Section for Customers -->
                @if($featuredProducts->isNotEmpty())
                    <div class="mb-12 bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gray-100 dark:border-gray-700">
                        <div class="p-10 border-b border-gray-50 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
                            <div>
                                <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">⭐ Featured Selection</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mt-1">Our top picks, specifically chosen for their quality and style.</p>
                            </div>
                            <a href="{{ route('guest.products.index') }}" class="px-8 py-4 bg-amber-500 text-white font-black rounded-2xl hover:bg-amber-600 transition-all shadow-lg shadow-amber-500/20 uppercase tracking-widest text-xs">Exclusives</a>
                        </div>
                        <div class="p-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            @foreach($featuredProducts as $product)
                                <div class="group relative bg-gray-50 dark:bg-gray-900/50 rounded-3xl p-6 hover:bg-white dark:hover:bg-gray-700 border-2 border-transparent hover:border-amber-400 transition-all duration-300">
                                    <div class="aspect-square rounded-2xl overflow-hidden mb-6 relative">
                                        @if($product->primaryimage)
                                            <img src="{{ Storage::url($product->primaryimage->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-4xl font-black text-indigo-300 uppercase">{{ substr($product->name, 0, 1) }}</div>
                                        @endif
                                        <div class="absolute top-4 left-4">
                                            @foreach($product->tags as $tag)
                                                @if($tag->pivot->is_featured)
                                                    <span class="px-3 py-1 bg-amber-500 text-white text-[9px] font-black rounded-full shadow-lg uppercase tracking-widest ring-2 ring-white animate-bounce">Featured</span>
                                                    @break
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <h4 class="text-sm font-black text-gray-900 dark:text-white truncate mb-1">{{ $product->name }}</h4>
                                    <div class="flex justify-between items-center">
                                        <span class="text-indigo-600 dark:text-indigo-400 font-bold text-lg">${{ number_format($product->price, 2) }}</span>
                                        <a href="{{ route('guest.products.show', $product) }}" class="p-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Recent Personal History -->
                    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 flex justify-between items-center">
                            <h3 class="font-black text-gray-800 dark:text-white">Recent Purchase History</h3>
                            <a href="{{ route('order.index') }}" class="text-xs font-black text-indigo-600 uppercase tracking-widest hover:underline">View Full History →</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                                    @forelse($recentMyOrders as $order)
                                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/50 transition-colors">
                                            <td class="px-6 py-5 font-black text-gray-700 dark:text-gray-300 uppercase tracking-tighter">#{{ $order->id }}</td>
                                            <td class="px-6 py-5 text-sm text-gray-500 font-medium">{{ $order->created_at->format('F d, Y') }}</td>
                                            <td class="px-6 py-5 text-right font-black text-gray-900 dark:text-white tracking-tight">${{ number_format($order->total, 2) }}</td>
                                            <td class="px-6 py-5 text-right">
                                                <a href="{{ route('order.show', $order) }}" class="px-4 py-2 bg-indigo-50 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 rounded-xl text-xs font-black hover:bg-indigo-100 transition-colors">DETAILS</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-20 text-center text-gray-400 italic font-medium">Your purchase history starts here. Browse our shop to get started!</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Side Stats or Banner -->
                    <div class="bg-gradient-to-br from-indigo-900 to-indigo-800 rounded-3xl shadow-xl p-8 text-white flex flex-col justify-between overflow-hidden relative">
                        <div class="relative z-10">
                            <h3 class="text-2xl font-black mb-4">Style Updates</h3>
                            <p class="text-indigo-200 text-sm font-medium leading-relaxed mb-6">
                                We've updated our collection with new trends. Check out the featured items selected just for you.
                            </p>
                            <a href="{{ route('guest.products.index') }}" class="inline-block bg-white text-indigo-900 px-6 py-3 rounded-2xl font-black text-sm hover:bg-indigo-50 transition-colors">SHOP ALL</a>
                        </div>
                        <div class="absolute -bottom-10 -right-10 opacity-10">
                            <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Active Tracking -->
                @if($activeOrders->count() > 0)
                    <div class="mt-12">
                        <h3 class="text-xl font-black text-gray-800 dark:text-white mb-6 flex items-center">
                            <span class="w-2 h-8 bg-indigo-600 rounded-full mr-3"></span>
                            Active Orders Progress
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($activeOrders as $order)
                                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow relative overflow-hidden">
                                     <div class="flex justify-between items-start mb-6">
                                        <div>
                                            <a href="{{ route('order.show', $order) }}" class="text-xl font-black text-indigo-600 dark:text-indigo-400 hover:underline">#ORDER-{{ $order->id }}</a>
                                            <p class="text-xs text-gray-500 font-bold mt-1 uppercase">{{ $order->items->count() }} Items • ${{ number_format($order->total, 2) }}</p>
                                        </div>
                                        <span class="px-4 py-2 rounded-xl bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-400 text-xs font-black uppercase tracking-wider">
                                            {{ $order->status }}
                                        </span>
                                     </div>
                                     <div class="w-full bg-gray-100 dark:bg-gray-700 h-2 rounded-full overflow-hidden mt-2">
                                        @php
                                            $statusVal = $order->status->value ?? $order->status;
                                            $barWidth = match ($statusVal) {
                                                'processing' => '40%',
                                                'shipped' => '75%',
                                                'delivered' => '100%',
                                                default => '5%',
                                            };
                                        @endphp
                                        <div class="h-full bg-indigo-600 rounded-full transition-all duration-700" style="width: {{ $barWidth }}"></div>
                                     </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
