<x-storefront-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <h1 class="text-4xl font-bold tracking-tight text-[#1b1b18] dark:text-[#EDEDEC]">Our Products</h1>
                <p class="mt-4 text-lg text-[#706f6c] dark:text-[#A1A09A]">Explore our curated selection of high-quality
                    products.</p>
            </div>

            @if($products->isEmpty())
                <div
                    class="text-center py-20 bg-white dark:bg-[#161615] rounded-3xl border border-dashed border-[#19140015] dark:border-[#ffffff10]">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 h-12 text-[#706f6c] opacity-20" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <p class="text-[#706f6c] dark:text-[#A1A09A]">No products found. Please check back later.</p>
                </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                <div
                    class="group relative flex flex-col bg-white dark:bg-[#161615] rounded-2xl overflow-hidden border border-[#19140015] dark:border-[#ffffff10] transition-all hover:shadow-2xl hover:-translate-y-1">
                    <a href="{{ route('guest.products.show', $product->id) }}" class="block">
                        <div class="aspect-square w-full overflow-hidden bg-gray-100 relative">
                            <img src="{{ $product->primaryimage ? asset('storage/' . $product->primaryimage->image_path) : asset('placeholder.jpg') }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
                                onerror="this.src='https://placehold.co/600x600?text={{ urlencode($product->name) }}'">
                            @if($product->stock_quantity <= 0)
                                <div
                                    class="absolute inset-0 bg-white/60 dark:bg-black/60 backdrop-blur-[2px] flex items-center justify-center">
                                    <span
                                        class="px-3 py-1 bg-[#1b1b18] text-white text-xs font-bold rounded-full uppercase tracking-wider">Out
                                        of Stock</span>
                                </div>
                            @endif
                        </div>
                    </a>
                    <div class="flex flex-1 flex-col p-6">
                        <p class="text-xs font-semibold text-[#f53003] uppercase tracking-widest mb-2">
                            {{ $product->category->name ?? 'General' }}
                        </p>
                        <h3 class="text-lg font-bold text-[#1b1b18] dark:text-[#EDEDEC] line-clamp-2">
                            <a href="{{ route('guest.products.show', $product->id) }}">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <div class="flex flex-wrap gap-1 mt-2">
                            @foreach($product->tags as $tag)
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 {{ $tag->pivot->is_featured ? 'bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-800 animate-pulse' : 'bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-800' }} text-[10px] font-medium rounded-full border">
                                    <span
                                        class="w-1 h-1 {{ $tag->pivot->is_featured ? 'bg-amber-500 dark:bg-amber-400' : 'bg-indigo-500 dark:bg-indigo-400' }} rounded-full"></span>
                                    {{ $tag->name }}
                                    @if($tag->pivot->is_featured)
                                        <span class="ml-1 text-[8px] font-bold uppercase">FEATURED</span>
                                    @endif
                                </span>
                            @endforeach
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <p class="text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">
                                ${{ number_format($product->price, 2) }}</p>

                            @if(auth()->check() && !auth()->user()->isAdmin())
                                <a href="{{ route('guest.products.show', $product) }}"
                                    class="p-2 rounded-full border border-[#19140015] dark:border-[#ffffff10] hover:bg-[#f53003] hover:text-white hover:border-[#f53003] transition-all"
                                    title="View & Add to Cart">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </a>
                            @elseif(!auth()->check())
                                                <button disabled
                                                    class="p-2 rounded-full border border-[#19140015] dark:border-[#ffffff10] opacity-20 cursor-not-allowed">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="mt-12">
                                    {{ $products->links() }}
                                </div>
                            @endif
        </div>
    </div>
</x-storefront-layout>