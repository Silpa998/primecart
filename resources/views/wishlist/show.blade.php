<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->product_name }} - PrimeCart</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style type="text/tailwindcss">
        @theme {
            --color-primary: #4EA685;
            --color-secondary: #57B894;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    
    </style>
</head>
<body class="bg-white text-slate-900">

    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white shadow-lg shadow-emerald-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <span class="font-extrabold text-2xl tracking-tighter">Prime<span class="text-primary">Cart</span></span>
            </a>
            



            <div x-data="{ 
    isLiked: {{ $isWishlisted ? 'true' : 'false' }},
    async toggleWishlist() {
        try {
            const response = await fetch('{{ route('wishlist.toggle', $product->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
            const data = await response.json();
            this.isLiked = (data.status === 'added');
        } catch (error) {
            console.error('Error toggling wishlist:', error);
        }
    }
}" class="flex items-center gap-5">
    <button @click="toggleWishlist()" 
            :class="isLiked ? 'text-red-500 bg-red-50' : 'text-slate-300 bg-slate-50 hover:bg-red-50 hover:text-red-400'"
            class="p-2 rounded-full transition-all duration-300 cursor-pointer outline-none">
        
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="h-6 w-6" 
             :fill="isLiked ? 'currentColor' : 'none'" 
             viewBox="0 0 24 24" 
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </button>
</div>





        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <div class="relative group">
                <div class="absolute -inset-4 bg-gradient-to-tr from-emerald-50 to-slate-50 rounded-[60px] -z-10 opacity-50 group-hover:opacity-100 transition-duration-700"></div>
                <div class="aspect-square bg-slate-50 rounded-[48px] overflow-hidden border border-slate-100 shadow-2xl flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-24 h-24 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    @endif
                </div>
            </div>

            <div class="space-y-10">
                <div class="space-y-4">
                    <nav class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                        <a href="/" class="hover:text-primary transition-colors">Shop</a>
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <span class="text-primary">Details</span>
                    </nav>
                    <h1 class="text-5xl font-black text-slate-900 tracking-tighter leading-tight">
                        {{ $product->product_name }}
                    </h1>
                    <div class="flex items-center gap-4">
                        <span class="text-4xl font-black text-slate-900">₹{{ number_format($product->price) }}</span>
                        <span class="px-3 py-1 bg-emerald-100 text-primary text-[10px] font-black uppercase tracking-widest rounded-full">In Stock</span>
                    </div>
                </div>

                <div class="space-y-6">
                    <p class="text-lg text-slate-500 font-medium leading-relaxed">
                        {{ $product->description ?? 'Experience the next level of digital innovation with the ' . $product->product_name . '. Crafted for those who value both form and function.' }}
                    </p>
                    
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-sm font-bold text-slate-700">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Premium Build Quality
                        </li>
                        <li class="flex items-center gap-3 text-sm font-bold text-slate-700">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            2-Year Extended Warranty
                        </li>
                    </ul>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <form action="{{ route('wishlist.move', $product->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-bold hover:bg-primary transition-all shadow-xl shadow-slate-200 flex items-center justify-center gap-3 active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Add to cart
                        </button>
                    </form>
                    
                    <a href="{{ route('wishlist.index') }}" class="px-8 py-5 border border-slate-200 rounded-2xl font-bold text-slate-600 hover:bg-slate-50 transition-all text-center">
                        Back to Wishlist
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-100 py-10 text-center">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">© 2026 PRIMECART. ALL RIGHTS RESERVED.</p>
    </footer>

</body>
</html>