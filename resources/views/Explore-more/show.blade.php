<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->product_name }} - PrimeCart</title>
    
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900" x-data="productDetail()">

    <div class="max-w-7xl mx-auto px-6 py-12">
        <a href="{{ route('products.explore') }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-emerald-600 mb-8 transition-colors group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Explore
        </a>

        <div class="bg-white rounded-[40px] p-8 md:p-12 shadow-sm border border-slate-100 flex flex-col md:flex-row gap-12">
            
            <div class="w-full md:w-1/2">
                <div class="bg-slate-50 rounded-3xl overflow-hidden aspect-square shadow-inner">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}" 
                         alt="{{ $product->product_name }}" 
                         class="w-full h-full object-cover">
                </div>
            </div>

            <div class="w-full md:w-1/2 flex flex-col justify-center">
                <span class="text-primary font-black text-xs uppercase tracking-widest">
                    {{ $product->category->category_name ?? 'New Arrival' }}
                </span>
                
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 leading-tight">
                    {{ $product->product_name }}
                </h1>
                
                <p class="text-slate-500 text-lg mb-8 leading-relaxed">
                    {{ $product->description ?? 'This premium product is crafted with care to ensure the highest quality and satisfaction.' }}
                </p>

                <div class="flex items-center gap-6 mb-10">
                    <span class="text-4xl font-black text-slate-900">₹{{ number_format($product->price) }}</span>
                    <span class="px-4 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold italic">In Stock</span>
                </div>

                <div class="flex gap-4">
                    <button @click="addToCart" 
                            class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-200 transition-all active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Add to Cart
                    </button>

                    <button @click="toggleWishlist" 
                            :class="isInWishlist ? 'text-red-500 bg-red-50' : 'text-slate-600 bg-slate-100'"
                            class="p-4 rounded-2xl hover:bg-red-50 hover:text-red-500 transition-colors cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :fill="isInWishlist ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function productDetail() {
            return {
                id: @json($product->id),
                name: @json($product->product_name),
                wishlist: JSON.parse(localStorage.getItem('wishlist') || '[]'),
                
                get isInWishlist() {
                    return this.wishlist.some(item => item.id === this.id);
                },

                async addToCart() {
                    try {
                        const response = await fetch(`/cart/add/${this.id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ quantity: 1 })
                        });

                        if (response.ok) {
                            alert(this.name + " added to cart!");
                        }
                    } catch (error) {
                        console.error("Cart Error:", error);
                    }
                },

                async toggleWishlist() {
                    try {
                        const response = await fetch(`/wishlist/toggle/${this.id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        });

                        if (response.ok) {
                            const index = this.wishlist.findIndex(item => item.id === this.id);
                            if (index > -1) {
                                this.wishlist.splice(index, 1);
                            } else {
                                this.wishlist.push({ id: this.id });
                            }
                            localStorage.setItem('wishlist', JSON.stringify(this.wishlist));
                        }
                    } catch (error) {
                        console.error("Wishlist Error:", error);
                    }
                }
            }
        }
    </script>
</body>
</html>