<x-storefront-layout>
    <div class="py-12" x-data="{ 
        mainImage: '{{ $product->primaryimage ? asset('storage/' . $product->primaryimage->image_path) : asset('placeholder.jpg') }}',
        quantity: 1
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8 text-sm font-medium" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('guest.products.index') }}"
                            class="text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]">Shop</a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-[#706f6c] opacity-30" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-[#1b1b18] dark:text-[#EDEDEC]">{{ $product->name }}</span>
                    </li>
                </ol>
            </nav>

            <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
                <!-- Image Gallery -->
                <div class="flex flex-col">
                    <div
                        class="aspect-square w-full overflow-hidden rounded-3xl bg-gray-100 border border-[#19140015] dark:border-[#ffffff10] mb-6">
                        <img :src="mainImage" alt="{{ $product->name }}"
                            class="h-full w-full object-cover object-center transition-opacity duration-300"
                            onerror="this.src='https://placehold.co/800x800?text=Image+Not+Found'">
                    </div>

                    @if($product->images->count() > 0)
                        <div class="grid grid-cols-4 gap-4">
                            @foreach($product->images as $image)
                                <button @click="mainImage = '{{ asset('storage/' . $image->image_path) }}'"
                                    class="aspect-square rounded-xl overflow-hidden border-2 transition-all"
                                    :class="mainImage === '{{ asset('storage/' . $image->image_path) }}' ? 'border-[#f53003]' : 'border-transparent hover:border-[#19140015] dark:hover:border-[#ffffff10]'">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="h-full w-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                    <div class="flex flex-col">
                        <span
                            class="text-sm font-bold text-[#f53003] uppercase tracking-widest mb-4">{{ $product->category->name ?? 'General' }}</span>
                        <h1
                            class="text-3xl font-extrabold tracking-tight text-[#1b1b18] dark:text-[#EDEDEC] sm:text-4xl mb-2">
                            {{ $product->name }}
                        </h1>

                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($product->tags as $tag)
                                <span
                                    class="inline-flex items-center gap-2 px-4 py-1.5 {{ $tag->pivot->is_featured ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-800 ring-2 ring-amber-500/20' : 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-800' }} text-xs font-bold rounded-lg border shadow-sm">
                                    <span
                                        class="w-1.5 h-1.5 {{ $tag->pivot->is_featured ? 'bg-amber-500 dark:bg-amber-400' : 'bg-indigo-500 dark:bg-indigo-400' }} rounded-full"></span>
                                    {{ $tag->name }}
                                    @if($tag->pivot->is_featured)
                                        <span
                                            class="ml-2 px-1.5 py-0.5 bg-amber-500 text-white text-[8px] rounded uppercase tracking-widest">Featured</span>
                                    @endif
                                </span>
                            @endforeach
                        </div>

                        <div class="flex items-center mb-8">
                            <p class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mr-4">
                                ${{ number_format($product->price, 2) }}</p>
                            @if($product->stock_quantity <= 0)
                                <span
                                    class="px-3 py-1 bg-[#1b1b18] text-white text-xs font-bold rounded-full uppercase tracking-wider">Out
                                    of Stock</span>
                            @else
                                <span
                                    class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full uppercase tracking-wider">In
                                    Stock</span>
                            @endif
                        </div>

                        <div
                            class="prose prose-sm dark:prose-invert max-w-none text-[#706f6c] dark:text-[#A1A09A] mb-8">
                            <p>{{ $product->description }}</p>
                        </div>

                        <!-- Order Form -->
                        @if($product->stock_quantity > 0)
                            <div class="mt-10 border-t border-[#19140015] dark:border-[#ffffff10] pt-10">
                                @if(auth()->check() && !auth()->user()->isAdmin())
                                    <form action="{{ route('guest.products.addToOrder', $product->id) }}" method="POST"
                                        class="flex flex-col gap-6">
                                        @csrf
                                        <div class="flex items-center gap-4">
                                            <label for="quantity"
                                                class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Quantity</label>
                                            <div
                                                class="flex items-center rounded-xl border border-[#19140015] dark:border-[#ffffff10] overflow-hidden">
                                                <button type="button" @click="if(quantity > 1) quantity--"
                                                    class="px-4 py-2 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">-</button>
                                                <input type="number" name="quantity" x-model="quantity" min="1"
                                                    max="{{ $product->stock_quantity }}"
                                                    class="w-16 border-none text-center focus:ring-0 bg-transparent" readonly>
                                                <button type="button"
                                                    @click="if(quantity < {{ $product->stock_quantity }}) quantity++"
                                                    class="px-4 py-2 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">+</button>
                                            </div>
                                            <span
                                                class="text-xs text-[#706f6c] dark:text-[#A1A09A]">{{ $product->stock_quantity }}
                                                units available</span>
                                        </div>

                                        <button type="submit"
                                            class="w-full bg-[#f53003] text-white py-4 px-8 rounded-2xl font-bold text-lg hover:shadow-xl hover:-translate-y-0.5 transition-all focus:ring-4 focus:ring-[#f53003]/20">
                                            Add to Cart
                                        </button>
                                    </form>
                                @elseif(!auth()->check())
                                    <div
                                        class="p-6 rounded-2xl bg-gray-50 dark:bg-white/5 border border-[#19140015] dark:border-[#ffffff10] text-center">
                                        <p class="text-[#1b1b18] dark:text-[#EDEDEC] mb-4">Please log in to place an order.</p>
                                        <a href="{{ route('login') }}"
                                            class="inline-block px-8 py-3 bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18] rounded-xl font-bold hover:opacity-90 transition-opacity">
                                            Login to Shop
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-storefront-layout>