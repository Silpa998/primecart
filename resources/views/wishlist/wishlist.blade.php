<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopPro - Digital Lifestyle</title>
    
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style type="text/tailwindcss">
        @theme {
            --color-primary: #4EA685;
            --color-secondary: #57B894;
        }

        /* Standard CSS using the new variables */
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

    <div x-data="{ show: false, message: '' }" 
         x-on:wishlist-updated.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000)"
         x-show="show" 
         x-transition
         class="fixed top-24 right-6 z-[60] bg-slate-900 text-white px-6 py-3 rounded-2xl shadow-2xl font-bold text-sm flex items-center gap-3"
         style="display: none;">
        <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
        <span x-text="message"></span>
    </div>

    <div class="bg-slate-900 text-white text-[11px] py-2 font-bold uppercase tracking-[0.2em] text-center">
        Free Express Shipping on orders over $150 • Shop Now
    </div>

    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-12">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white shadow-lg shadow-emerald-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span class="font-extrabold text-2xl tracking-tighter">Prime<span class="text-primary">Cart</span></span>
                </a>
                <div class="hidden md:flex items-center gap-8 text-sm font-bold text-slate-500">
                    <a href="/" class="hover:text-primary transition-colors">Home</a>
                    <a href="#" class="hover:text-primary transition-colors">Categories</a>
                    <a href="#" class="hover:text-primary transition-colors">New Drops</a>
                </div>
            </div>

            <div class="flex items-center gap-5">
                @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 p-2 text-slate-600 hover:bg-slate-50 rounded-full transition-all">
                        <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </button>
                </div>
                @endauth
                
                <a href="{{ route('wishlist.index') }}" class="p-2 text-primary bg-emerald-50 rounded-full relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-black w-4 h-4 flex items-center justify-center rounded-full border-2 border-white">
                        {{ $wishlistItems->count() }}
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <section class="wishlist-gradient py-24 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div class="space-y-4">
                    <nav class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                        <a href="/" class="hover:text-primary transition-colors">Home</a>
                        <span class="w-1.5 h-1.5 bg-slate-200 rounded-full"></span>
                        <span class="text-primary">Wishlist</span>
                    </nav>
                    <h1 class="text-6xl font-black text-slate-900 tracking-tighter">
                        My <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-emerald-600">Wishlist</span>
                    </h1>
                    <p class="text-slate-500 font-medium text-lg">
                        You have <span class="text-slate-900 font-bold">{{ $wishlistItems->count() }}</span> items saved in your collection.
                    </p>
                </div>
                
                @if(!$wishlistItems->isEmpty())
                    <a href="/" class="group flex items-center gap-3 px-8 py-4 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-900 hover:border-primary transition-all shadow-sm active:scale-95">
                        Continue Shopping
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                @endif
            </div>

            @if($wishlistItems->isEmpty())
                <div class="bg-white rounded-[50px] border border-slate-100 p-20 text-center shadow-sm">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-slate-50 rounded-[30px] flex items-center justify-center mx-auto mb-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-slate-900 mb-4 tracking-tight">Your collection is empty</h3>
                        <p class="text-slate-500 mb-10 font-medium">Start adding some digital gems to your wishlist!</p>
                        <a href="/" class="inline-block px-10 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-primary transition-all shadow-xl shadow-slate-200">
                            Explore Products
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($wishlistItems as $item)
                        @php $product = $item->product; @endphp
                        
                        <div x-data="{ removed: false }" 
                             x-show="!removed" 
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="group relative bg-white rounded-[32px] overflow-hidden border border-slate-100 p-5 shadow-sm transition-all hover:shadow-xl hover:shadow-emerald-100/50 hover:-translate-y-1">
                            
                            <button @click="
                                fetch('{{ route('wishlist.toggle', $product->id) }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if(data.status === 'removed') {
                                        removed = true; 
                                        $dispatch('wishlist-updated', { message: 'Item removed from wishlist' });
                                    }
                                })"
                                class="absolute top-5 right-5 z-20 p-2.5 bg-white/90 backdrop-blur-md rounded-full text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm border border-slate-100 active:scale-90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                </svg>
                            </button>

                            <a href="{{ route('wishlist.show', $product->id) }}" class="block group">
                                <div class="product-image w-full h-48 bg-slate-50 rounded-2xl flex items-center justify-center overflow-hidden transition-transform duration-500">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                            </a>

                            <div class="space-y-1 mb-6">
                                <h3 class="text-lg font-black text-slate-900 truncate">{{ $product->product_name }}</h3>
                                <p class="text-2xl font-black text-slate-900">₹{{ number_format($product->price) }}</p>
                            </div>

                            <form action="{{ route('wishlist.move', $item->product_id) }}" method="POST" class="w-full">
                               @csrf
                               <button type="submit" class="w-full group flex items-center justify-center gap-2 py-4 bg-slate-900 text-white rounded-2xl text-sm font-bold hover:bg-primary transition-all shadow-lg shadow-slate-200 active:scale-[0.98]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                        Move to Cart
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <footer class="bg-white border-t border-slate-100 pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-12 mb-20">
            <div class="col-span-2">
                <div class="flex items-center gap-2 mb-8">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    </div>
                    <span class="font-extrabold text-2xl tracking-tighter">Prime<span class="text-primary">Cart</span></span>
                </div>
                <p class="text-slate-500 font-medium pr-12">Elevating your digital lifestyle with premium tech and minimal design.</p>
            </div>
            <div>
                <h5 class="font-black text-slate-900 uppercase text-xs tracking-widest mb-6">Support</h5>
                <ul class="space-y-4 text-sm font-bold text-slate-500">
                    <li><a href="#" class="hover:text-primary transition-colors">Shipping</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Returns</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 pt-10 border-t border-slate-50 text-center">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">© 2026 PRIMECART. ALL RIGHTS RESERVED.</p>
        </div>
    </footer>

</body>
</html>