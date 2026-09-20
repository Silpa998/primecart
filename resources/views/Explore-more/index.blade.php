<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Products - PrimeCart</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @theme {
            --color-primary: #4EA685;
            --color-secondary: #57B894;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .category-pill.active { @apply bg-primary text-white border-primary; } 
    </style>
</head>
<body class="bg-slate-50 text-slate-900" x-data="productFilter()">

    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('products.explore') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <span class="font-extrabold text-2xl tracking-tighter">Prime<span class="text-primary">Cart</span></span>
            </a>
            
            <div class="hidden md:flex items-center gap-8 text-sm font-bold text-slate-500">
                <a href="#" class="hover:text-primary transition-colors">New Arrivals</a>
                <a href="#" class="text-primary">Explore</a>
                <a href="#" class="hover:text-primary transition-colors">Support</a>
            </div>

            <div class="flex items-center gap-1 md:gap-4">
                <!-- Wishlist Icon -->
                <a href="{{ route('wishlist.index') }}" class="relative p-2 text-slate-500 hover:text-red-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    @auth
                        @if(auth()->user()->wishlists()->count() > 0)
                            <span class="absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold h-4 w-4 flex items-center justify-center rounded-full border-2 border-white">
                                {{ auth()->user()->wishlists()->count() }}
                            </span>
                        @endif
                    @endauth
                </a>

                <!-- Cart Icon -->
                <a href="{{ route('cart') }}" class="relative inline-block">
                    <button class="p-2 text-slate-500 hover:text-primary transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <template x-if="cart.length > 0">
                            <span x-text="cart.length" class="absolute top-1 right-1 bg-primary text-white text-[10px] font-bold h-4 w-4 flex items-center justify-center rounded-full border-2 border-white"></span>
                        </template>
                    </button>
                </a>

                <div class="relative hidden sm:block">
                    <input type="text" x-model="search" placeholder="Search..." class="bg-slate-100 border-none rounded-full py-2 px-8 text-sm focus:ring-2 focus:ring-primary/20 w-40 md:w-64 transition-all">
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Sidebar -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="sticky top-32">
                    <h2 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Categories</h2>
                    <ul class="space-y-2">
                        <li>
                            <button @click="selectedCategory = 'all'" 
                                :class="selectedCategory === 'all' ? 'bg-primary text-white shadow-lg' : 'bg-white text-slate-600'"
                                class="w-full text-left px-5 py-3 rounded-2xl text-sm font-bold transition-all">
                                All Products
                            </button>
                        </li>
                        <template x-for="cat in categories" :key="cat.id">
                            <li>
                                <button @click="selectedCategory = cat.category_name" 
                                    :class="selectedCategory === cat.category_name ? 'bg-primary text-white shadow-lg' : 'bg-white text-slate-600'"
                                    class="w-full text-left px-5 py-3 rounded-2xl text-sm font-bold transition-all capitalize"
                                    x-text="cat.category_name">
                                </button>
                            </li>
                        </template>
                    </ul>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl font-black text-slate-900">
                        <span x-text="selectedCategory === 'all' ? 'All Collections' : selectedCategory"></span>
                        <span class="text-slate-300 ml-2" x-text="filteredProducts.length"></span>
                    </h1>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <div class="bg-white rounded-[32px] border border-slate-100 p-5 shadow-sm hover:shadow-xl hover:shadow-emerald-100/50 transition-all group relative">
                            
                            <!-- Product Image Container -->
                            <div class="relative aspect-square bg-slate-50 rounded-2xl mb-5 overflow-hidden">
                                <a :href="'/product/' + product.id">
                                    <img :src="product.image" :alt="product.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </a>

                                <!-- Hover Actions -->
                                <div class="absolute top-3 right-3 flex flex-col gap-2 translate-x-12 group-hover:translate-x-0 transition-transform duration-300">
                                    <button @click="toggleWishlist(product)"
                                        class="p-2.5 bg-white/90 backdrop-blur-md rounded-xl shadow-sm transition-colors"
                                        :class="isInWishlist(product.id) ? 'text-red-500' : 'text-slate-600 hover:text-red-500 hover:bg-white'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :fill="isInWishlist(product.id) ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>

                                    <button class="p-2.5 bg-white/90 backdrop-blur-md text-slate-600 rounded-xl shadow-sm hover:text-primary hover:bg-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <p class="text-[10px] font-bold text-primary uppercase tracking-widest mb-1" x-text="product.category"></p>
                            <a :href="'/product/' + product.id" class="block group">
                                <h3 class="text-lg font-black text-slate-900 mb-2 truncate group-hover:text-primary transition-colors" x-text="product.name"></h3>
                            </a>
                            <p class="text-2xl font-black text-slate-900 mb-5">₹<span x-text="product.price.toLocaleString()"></span></p>
                        </div>
                    </template>
                </div>

                <div x-show="filteredProducts.length === 0" class="text-center py-20">
                    <p class="text-slate-400 font-bold">No products found in this category.</p>
                </div>
            </main>
        </div>
    </div>

<script>
function productFilter() {
    return {
        selectedCategory: 'all',
        search: '',
        categories: @json($categories),
        wishlist: JSON.parse(localStorage.getItem('wishlist') || '[]'),
        cart: Object.values(@json(session()->get('cart', []))),

        products: @json($products).map(p => {
            const hasVariation = p.variations && p.variations.length > 0;
            const variation = hasVariation ? p.variations[0] : null;

            return {
                id: p.id,
                variation_id: variation ? variation.id : null,
                name: p.product_name,
                category: p.category?.category_name || 'Uncategorized',
                price: variation ? variation.price : p.price,
                image: (variation && variation.image) 
                    ? `/storage/${variation.image}` 
                    : (p.image ? `/storage/${p.image}` : '/images/placeholder.jpg'),
                hasVariation: hasVariation
            };
        }),

        get filteredProducts() {
            const searchTerm = this.search.toLowerCase();
            return this.products.filter(p => {
                const categoryMatch = this.selectedCategory === 'all' || p.category === this.selectedCategory;
                const searchMatch = p.name.toLowerCase().includes(searchTerm);
                return categoryMatch && searchMatch;
            });
        },

        async toggleWishlist(product) {
            try {
                const response = await fetch(`/wishlist/toggle/${product.id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Wishlist sync failed');

                const index = this.wishlist.findIndex(item => item.id === product.id);
                if (index > -1) {
                    this.wishlist.splice(index, 1);
                } else {
                    this.wishlist.push(product);
                }
                this.syncWishlist();
            } catch (error) {
                console.error("Wishlist Error:", error);
                alert("Wishlist update failed.");
            }
        },

        isInWishlist(productId) {
            return this.wishlist.some(item => item.id === productId);
        },

        syncWishlist() {
            localStorage.setItem('wishlist', JSON.stringify(this.wishlist));
        },

        async addToCart(product) {
            try {
                const response = await fetch(`/cart/add/${product.id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ quantity: 1 })
                });

                if (!response.ok) throw new Error('Cart sync failed');

                const existingItem = this.cart.find(item => item.id === product.id);
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    this.cart.push({ ...product, quantity: 1 });
                }
                this.syncCart();
            } catch (error) {
                console.error("Cart Error:", error);
                alert("Could not add items to the cart.");
            }
        },

        syncCart() {
            localStorage.setItem('cart', JSON.stringify(this.cart));
        }
    }
}
</script>
</body>
</html>