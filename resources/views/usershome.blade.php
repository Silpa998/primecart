<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopPro - Digital Lifestyle</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4EA685',
                        secondary: '#57B894',
                    }
                }
            }
        }
    </script>

    <style type="text/tailwindcss">
        @theme {
            --color-primary: #4EA685;
            --color-secondary: #57B894;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
        
        .hero-gradient { 
            background: radial-gradient(circle at top right, #f0f9f6 0%, #ffffff 100%); 
        }
        
        .product-card:hover .product-image { 
            transform: scale(1.05); 
        }

        .nav-link:hover { 
            color: var(--color-primary); 
        } 
    </style>
</head>
<body class="bg-white text-slate-900">

    <div class="bg-slate-900 text-white text-[11px] py-2 font-bold uppercase tracking-[0.2em] text-center">
        Free Express Shipping on orders over $150 • Shop Now
    </div>

    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-12">
                <a href="{{ route('user.home') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white shadow-lg shadow-emerald-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span class="font-extrabold text-2xl tracking-tighter">Prime<span class="text-primary">Cart</span></span>
                </a>

                <div class="hidden md:flex items-center gap-8 text-sm font-bold text-slate-500">
                    <a href="#" class="nav-link transition-colors">New Arrivals</a>
                    <a href="#" class="nav-link transition-colors">Categories</a>
                    <a href="#" class="nav-link transition-colors">Best Sellers</a>
                    <a href="#" class="nav-link transition-colors text-primary">Sale</a>
                </div>
            </div>

            <div class="flex items-center gap-5">
                <div class="hidden lg:flex relative items-center">
                    <input type="text" placeholder="Search products..." class="bg-slate-50 border-none rounded-full py-2 px-10 text-sm focus:ring-2 focus:ring-emerald-100 w-64 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                @auth
                    <div x-data="{ open: false }" class="relative inline-block">
                        <button @click="open = !open" class="flex items-center gap-2 p-2 text-slate-600 hover:bg-slate-50 rounded-full transition-all focus:outline-none">
                            <span class="text-sm font-medium ml-2">{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-lg shadow-xl py-2 z-50">
                            <div class="px-4 py-2 border-b border-slate-100">
                                <p class="text-xs text-slate-400">Signed in as</p>
                                <p class="text-sm font-bold text-slate-700 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-primary">Login</a>
                @endauth

                <a href="{{ route('wishlist.index') }}" class="p-2 text-slate-600 hover:bg-slate-50 rounded-full transition-all relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span x-text="wishlistedProducts.length" class="absolute top-1 right-1 bg-red-500 text-white text-[9px] font-black w-4 h-4 flex items-center justify-center rounded-full border-2 border-white">
                        {{ Auth::check() ? Auth::user()->wishlists()->count() : 0 }}
                    </span>
                </a>

                <a href="{{ route('cart') }}" class="p-2 text-slate-600 hover:bg-slate-50 rounded-full transition-all relative inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="absolute top-1 right-1 bg-primary text-white text-[9px] font-black w-4 h-4 flex items-center justify-center rounded-full border-2 border-white">
                        @auth
                            {{ auth()->user()->carts()->count() }}
                        @else
                            {{ count(session()->get('temp_cart', [])) }}
                        @endauth
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <section class="hero-gradient relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 pt-20 pb-32 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 z-10 text-center md:text-left">
                <span class="inline-block px-4 py-1.5 bg-emerald-50 text-primary rounded-full text-xs font-black uppercase tracking-widest mb-6">New Season 2026</span>
                <h1 class="text-5xl lg:text-7xl font-black text-slate-900 leading-[1.1] tracking-tight mb-8">
                    Elevate Your <br><span class="text-primary">Digital Lifestyle.</span>
                </h1>
                <p class="text-lg text-slate-500 font-medium mb-10 max-w-lg mx-auto md:mx-0">
                    Discover our curated collection of high-performance electronics and minimalist accessories designed for the modern workspace.
                </p>
                <div class="flex flex-col sm:flex-row items-center gap-4 justify-center md:justify-start">
                    <a href="#" class="px-10 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-slate-800 transition-all shadow-xl shadow-slate-200 active:scale-95 text-center w-full sm:w-auto">
                        Shop Collection
                    </a>
                    <a href="#" class="px-10 py-4 bg-white border border-slate-200 text-slate-900 rounded-2xl font-bold hover:bg-slate-50 transition-all active:scale-95 text-center w-full sm:w-auto">
                        View Lookbook
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 mt-16 md:mt-0 relative">
                <div class="absolute inset-0 bg-emerald-500/10 blur-[120px] rounded-full transform translate-x-12"></div>
                <div class="relative bg-white p-4 rounded-[40px] shadow-2xl border border-white rotate-3 hover:rotate-0 transition-transform duration-700">
                    <div class="bg-slate-100 w-full h-[400px] rounded-[30px] flex items-center justify-center text-slate-300">
                        <img src="{{ asset('storage/products/Online.jpg') }}" alt="Hero Image" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
                <div class="text-left">
                    <h2 class="text-4xl font-black text-slate-900 tracking-tight">Our Bestsellers</h2>
                    <div class="w-16 h-1 bg-primary mt-4 rounded-full"></div>
                </div>
                <div>
                    <a href="{{ route('products.explore') }}" class="inline-block px-10 py-4 bg-white border-2 border-slate-100 text-slate-900 rounded-2xl font-black text-sm hover:border-primary hover:text-primary transition-all shadow-sm">
                        Search With Category
                    </a>
                </div>
            </div>

            <div x-data="wishlistApp" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="product-card group cursor-pointer">
                        <div class="relative bg-white rounded-[32px] overflow-hidden border border-slate-100 p-6 shadow-sm transition-all hover:shadow-xl hover:shadow-emerald-100/50">
                            
                            {{-- New Badge --}}
                            @if($product->created_at >= now()->subDays(7))
                                <div class="absolute top-5 left-5 z-10">
                                    <span class="px-3 py-1 bg-primary text-white text-[10px] font-black uppercase tracking-wider rounded-full">New</span>
                                </div>
                            @endif

                            {{-- Action Icons --}}
                            <div class="absolute top-5 right-5 z-10 flex flex-col gap-2">
                                <button @click="addToWishlist({{ $product->id }})" 
                                        class="p-2 bg-white/80 backdrop-blur-sm rounded-full transition-colors shadow-sm hover:bg-white"
                                        :class="wishlistedProducts.includes({{ $product->id }}) ? 'text-red-500 bg-red-50' : 'text-slate-400'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :fill="wishlistedProducts.includes({{ $product->id }}) ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>

                                <button onclick="shareProduct('{{ $product->product_name }}', '{{ route('products.show', $product->id) }}')"
                                        class="p-2 bg-white/80 backdrop-blur-sm rounded-full text-slate-400 hover:text-primary transition-colors shadow-sm hover:bg-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Product Image --}}
                            <a href="{{ route('products.show', $product->id) }}" class="block group">
                                <div class="product-image w-full h-48 bg-slate-50 rounded-2xl flex items-center justify-center overflow-hidden transition-transform duration-500">
                                    @php
                                        $displayImage = $product->variations->whereNotNull('image')->first()?->image ?? $product->image;
                                    @endphp

                                    @if($displayImage)
                                        <img src="{{ asset('storage/' . $displayImage) }}" 
                                             alt="{{ $product->product_name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                            </a>

                            <div class="mt-6">
                                <p class="text-[10px] font-bold text-primary uppercase tracking-widest mb-1">
                                    {{ $product->category_name ?? 'General' }}
                                </p>
                                <h3 class="text-lg font-black text-slate-900 leading-tight mb-4 truncate">{{ $product->product_name }}</h3>
                                <div class="mb-4">
                                    @php
                                        $variationPrice = $product->variations->whereNotNull('price')->first()?->price;
                                        $displayPrice = $variationPrice ?? $product->price;
                                    
                                        // Percentage calculation logic
                                        $discountPercentage = 0;
                                        if ($variationPrice && $product->price > $variationPrice) {
                                            $discountAmount = $product->price - $variationPrice;
                                            $discountPercentage = round(($discountAmount / $product->price) * 100);
                                       }                      
                                    @endphp

                                    <span class="text-2xl font-black text-slate-900">
                                        ₹{{ number_format($displayPrice) }}
                                    </span>

                                    {{-- optional: if variation price is available and is lower than the main product price --}}
                                    @if($variationPrice && $product->price > $variationPrice)
                                        <span class="text-sm text-slate-400 line-through ml-2">
                                            ₹{{ number_format($product->price) }}
                                        </span>
                                    @endif 
                            </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-16 text-center">
                <a href="{{ route('products.explore') }}" class="inline-block px-12 py-4 bg-white border-2 border-slate-100 text-slate-900 rounded-2xl font-black text-sm hover:border-primary hover:text-primary transition-all shadow-sm">
                    Explore All Products
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-slate-100 pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-12 mb-20">
            <div class="col-span-2">
                <div class="flex items-center gap-2 mb-8">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span class="font-extrabold text-2xl tracking-tighter">Prime<span class="text-primary">Cart</span></span>
                </div>
                <p class="text-slate-500 font-medium mb-8 pr-12">Building the future of digital retail with a focus on performance, design, and user experience.</p>
            </div>
            <div>
                <h5 class="font-black text-slate-900 uppercase text-xs tracking-widest mb-6">Shop</h5>
                <ul class="space-y-4 text-sm font-bold text-slate-500">
                    <li><a href="#" class="hover:text-primary transition-colors">All Products</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        function shareProduct(title, url) {
            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url
                }).catch(console.error);
            } else {
                navigator.clipboard.writeText(url);
                alert('Link copied to clipboard!');
            }
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('wishlistApp', () => ({
                wishlistedProducts: {!! Auth::check() ? Auth::user()->wishlists->pluck('product_id')->toJson() : '[]' !!},
                isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
                async addToWishlist(productId) {
                    if (!this.isLoggedIn) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    try {
                        const response = await fetch(`/wishlist/toggle/${productId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        if (!response.ok) throw new Error('Request failed');
                        const data = await response.json();
                        if (data.status === 'added') {
                            if (!this.wishlistedProducts.includes(productId)) this.wishlistedProducts.push(productId);
                        } else {
                            this.wishlistedProducts = this.wishlistedProducts.filter(id => id !== productId);
                        }
                    } catch (error) {
                        console.error('Wishlist error:', error);
                    }
                }
            }));
        });
    </script>
</body>
</html>