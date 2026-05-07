<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .bg-mesh { 
            background-color: #ffffff;
            background-image: radial-gradient(at 0% 0%, rgba(78, 166, 133, 0.05) 0px, transparent 50%), 
                              radial-gradient(at 100% 100%, rgba(87, 184, 148, 0.05) 0px, transparent 50%);
        }
    </style> 
</head>
<body class="bg-mesh text-slate-900 selection:bg-primary selection:text-white">

    {{-- Notification Toast --}}
    @if(session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed top-5 right-5 z-50 bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <span class="text-sm font-bold">{{ session('success') }}</span>
        <button @click="show = false" class="ml-4 hover:opacity-70">✕</button>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" 
        x-show="show" 
        x-init="setTimeout(() => show = false, 3000)"
        class="fixed top-5 right-5 z-50 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3">
    
        <span class="text-sm font-bold">{{ session('error') }}</span>
        <button @click="show = false" class="ml-4">✕</button>
    </div>
    @endif

    <nav class="h-24 flex items-center">
    <div class="max-w-7xl mx-auto px-6 w-full flex justify-between items-center">
        {{-- Left Side: Back Button --}}
        <a href="{{ route('user.home') }}" class="group flex items-center gap-3">
            <div class="w-10 h-10 bg-slate-900 group-hover:bg-primary transition-colors rounded-2xl flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </div>
            <span class="hidden md:block font-bold text-sm uppercase tracking-widest text-slate-400 group-hover:text-slate-900 transition-colors">Back to Store</span>
        </a>

        {{-- Right Side: Action Buttons --}}
        <div class="flex items-center gap-3">
            {{-- Wishlist Link --}}
            <a href="{{route('wishlist.index')}}" class="h-12 px-5 bg-white border border-slate-100 rounded-2xl flex items-center gap-2 text-slate-600 hover:text-red-500 hover:border-red-100 transition-all shadow-sm font-bold text-xs uppercase tracking-wider">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                <span class="hidden sm:inline">Wishlist</span>
            </a>

            {{-- Cart Link --}}
            <a href="{{route('cart')}}" class="h-12 px-5 bg-slate-900 text-white rounded-2xl flex items-center gap-2 hover:bg-primary transition-all shadow-lg shadow-slate-200 font-bold text-xs uppercase tracking-wider">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                <span>Cart</span>
                
                {{-- Optional: Item Count Badge --}}
                @php
                    $count = auth()->check() ? \App\Models\Cart::where('user_id', auth()->id())->count() : count(session('temp_cart', []));
                @endphp
                @if($count > 0)
                    <span class="ml-1 bg-white text-slate-900 px-2 py-0.5 rounded-lg text-[10px]">{{ $count }}</span>
                @endif
            </a>
        </div>
    </div>
</nav>

   <main class="max-w-7xl mx-auto px-6 pb-24" 
      x-data="{ 
        count: 1, 
        selectedColor: '', 
        selectedSize: '', 
        selectedVariationId: null,
        currentImage: '', 
        basePrice: {{ $product->price }},
        allVariations: {{ json_encode($product->variations) }},
        productCategory: '{{ $product->category->category_name ?? $product->category->name }}',
        get currentPrice() {
            if (this.selectedVariationId) {
                let variant = this.allVariations.find(v => v.id === this.selectedVariationId);
                return variant ? variant.price : this.basePrice;
            }
            return this.basePrice;
    },
    updateVariation() {
        let variant = this.allVariations.find(v => {
            let matchColor = this.selectedColor ? v.color === this.selectedColor : true;
            // check size match if category is Clothings
            if (this.productCategory === 'Clothings') {
                let sizes = v.size ? v.size.split(',').map(s => s.trim()) : [];
                return matchColor && sizes.includes(this.selectedSize);
            }
            return matchColor;
        });

        if (variant) {
            this.selectedVariationId = variant.id;
        }
    }
    }"
    x-init="
        let firstVariant = allVariations.find(v => v.image);
        if (firstVariant) {
            currentImage = '/storage/' + firstVariant.image;
            selectedVariationId = firstVariant.id;
            selectedColor = firstVariant.color;
            if (productCategory === 'Clothings' && firstVariant.size) {
                
            } else {
                selectedSize = firstVariant.variant;
            }
        } else {
            currentImage = '{{ asset('storage/' . $product->image) }}';
        }
    ">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            {{-- Image Section --}}
            <div class="lg:col-span-7 relative">
                <h2 class="absolute -top-20 -left-10 text-[20rem] font-black text-slate-50/50 select-none z-0 pointer-events-none">
                    {{ substr($product->product_name, 0, 1) }}
                </h2>

                <div class="relative z-10 flex items-center justify-center">
                    <div class="w-full aspect-[4/5] bg-white rounded-[60px] shadow-sm border border-slate-100 p-8 flex items-center justify-center overflow-hidden group">
                        <img :src="currentImage" 
                        class="w-full h-full object-contain drop-shadow-2xl transition-transform duration-700 group-hover:scale-105" 
                        alt="{{ $product->product_name }}">
                    </div>
                </div>

                {{-- Thumbnail Gallery --}}
<div class="flex gap-4 mt-8 justify-center flex-wrap">
    
    {{-- 1. Main Product Image Thumbnail - @if condition add cheyyuka --}}
    @if($product->image)
    <div @click="currentImage = '{{ asset('storage/' . $product->image) }}'; selectedVariationId = null; selectedColor = '';"
        :class="currentImage === '{{ asset('storage/' . $product->image) }}' ? 'border-primary' : 'border-slate-100'"
        class="w-20 h-20 rounded-2xl border-2 p-2 bg-white cursor-pointer transition-all shadow-sm">
        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover rounded-lg">
    </div> 
    @endif

    {{-- 2. Loop through Variations --}}
    @foreach($product->variations as $variant)
        @if($variant->image) 
            <div @click="currentImage = '{{ asset('storage/' . $variant->image) }}'; 
                        selectedColor = '{{ $variant->color }}';
                        selectedVariationId = {{ $variant->id }}; 
                        selectedSize = '{{ $variant->variant_name ?? $variant->variant }}';" {{-- Update selectedSize here --}}
                :class="currentImage === '{{ asset('storage/' . $variant->image) }}' ? 'border-primary' : 'border-slate-100'"
                class="w-20 h-20 rounded-2xl border-2 p-2 bg-white/50 hover:bg-white transition-all cursor-pointer group">
                <img src="{{ asset('storage/' . $variant->image) }}" 
                     class="w-full h-full object-cover rounded-lg opacity-80 group-hover:opacity-100 transition-opacity">
            </div>
        @endif
    @endforeach
</div>
</div>


            {{-- Product Info Section --}}
            <div class="lg:col-span-5 space-y-10">
                <div x-data="{ activeTab: 'desc' }">
                    <div class="mb-4">
                        <span class="text-primary font-black text-xs uppercase tracking-widest">{{ $product->category->category_name ?? 'Collection' }}</span>
                        <h1 class="text-5xl font-black text-slate-900 mt-2 tracking-tight">{{ $product->product_name }}</h1>
                    </div>

                    <div class="flex items-baseline gap-4 mb-8">
                        <span class="text-4xl font-black text-slate-900 tracking-tighter">
                            ₹<span x-text="new Intl.NumberFormat('en-IN').format(currentPrice)"></span>
                        </span>

                        <span class="text-slate-400 line-through text-lg font-medium">
                            ₹<span x-text="new Intl.NumberFormat('en-IN').format(currentPrice * 1.2)"></span>
                        </span>
                    </div>

                    <div class="border-b border-slate-100 flex gap-8 mb-6">
                        <button @click="activeTab = 'desc'" :class="activeTab === 'desc' ? 'border-primary text-slate-900' : 'border-transparent text-slate-400'" class="pb-4 text-xs font-black uppercase tracking-widest border-b-2 transition-all">Description</button>
                        <button @click="activeTab = 'spec'" :class="activeTab === 'spec' ? 'border-primary text-slate-900' : 'border-transparent text-slate-400'" class="pb-4 text-xs font-black uppercase tracking-widest border-b-2 transition-all">Details</button>
                    </div>

                    <div class="min-h-[100px]">
                        <p x-show="activeTab === 'desc'" class="text-slate-500 leading-relaxed font-medium">
                            {{ $product->description ?? 'Experience premium quality and timeless design with our latest collection.' }}
                        </p>
                        <div x-show="activeTab === 'spec'" class="space-y-3">
                            <div class="flex justify-between text-sm"><span class="text-slate-400 font-bold uppercase tracking-tighter">Availability</span><span class="text-emerald-600 font-bold uppercase tracking-tighter">In Stock</span></div>
                            <div class="flex justify-between text-sm"><span class="text-slate-400 font-bold uppercase tracking-tighter">Product ID</span><span class="text-slate-900 font-bold tracking-tighter">#PC-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</span></div>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    {{-- Color Selection --}}
                    @php 
    $colors = $product->variations->whereNotNull('color')->unique('color'); 
@endphp

@if($colors->count() > 0)
<div class="space-y-3">
    <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">
        Color: <span class="text-slate-900" x-text="selectedColor"></span>
    </span>
    
    <div class="flex gap-3">
        @foreach($colors as $variant)
            <button type="button" 
                {{-- Click Event: Color, ID, and Image update cheyyunnu --}}
                @click="
                    selectedColor = '{{ $variant->color }}'; 
                    selectedVariationId = {{ $variant->id }};
                    @if($variant->image) 
                        currentImage = '{{ asset('storage/' . $variant->image) }}'; 
                    @endif
                "
                {{-- Dynamic Class: Select cheytha color-ine highlight cheyyunnu --}}
                :class="selectedColor === '{{ $variant->color }}' ? 'ring-2 ring-blue-600 ring-offset-2 scale-110 border-transparent' : 'border-slate-200'"
                
                class="w-8 h-8 rounded-full border shadow-sm transition-all"
                style="background-color: {{ $variant->color }};"
                title="{{ $variant->color }}">
            </button>
        @endforeach
    </div>
</div>
@endif

                    {{-- Individual Size/Variant Selection --}}
<div class="space-y-4">
    <div class="flex justify-between items-center">
        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">
            <span x-text="productCategory === 'Clothings' ? 'Select Size:' : 'Select Variant:'"></span>
            <span class="text-slate-900 ml-2" x-text="selectedSize"></span>
        </span>
    </div>

    <div class="flex flex-wrap gap-3">
        {{-- CASE 1: if selected Variantion  --}}
        <template x-if="selectedVariationId">
            <div class="flex flex-wrap gap-3">
                <template x-for="variant in allVariations.filter(v => v.id === selectedVariationId)" :key="variant.id">
                    <div class="flex flex-wrap gap-3">
                        <template x-if="productCategory === 'Clothings'">
                            <template x-for="size in (variant.size ? variant.size.split(',').map(s => s.trim()) : [])" :key="size">
                                <button type="button" 
                                    @click="selectedSize = size; updateVariation();"
                                    :class="selectedSize === size ? 'border-primary bg-primary/5 text-primary' : 'border-slate-200 text-slate-600'"
                                    class="min-w-[56px] h-12 pxds-3 border-2 rounded-xl text-sm font-bold transition-all flex items-center justify-center active:scale-95 uppercase"
                                    x-text="size">
                                </button>
                            </template>
                        </template>

                        {{-- Mobile Variant Selection --}}
                        <template x-if="productCategory === 'Mobile'">
                            <button type="button" 
                                @click="selectedSize = variant.variant; selectedVariationId = variant.id;"                                 
                                :class="selectedSize === variant.variant ? 'border-primary bg-primary/5 text-primary' : 'border-slate-200 text-slate-600'"
                                class="min-w-[80px] h-12 px-4 border-2 rounded-xl text-sm font-bold transition-all flex items-center justify-center active:scale-95 uppercase" 
                                x-text="variant.variant">
                            </button>
                        </template>
                    </div>
                </template>
            </div>
        </template>

        {{-- CASE 2: did not select a variation --}}
        <template x-if="!selectedVariationId">
            <div class="flex flex-wrap gap-3">
                @if(($product->category->category_name ?? $product->category->name) == 'Clothings')
                    @php
                        $allSizes = $product->variations->flatMap(fn($v) => explode(',', $v->size))->map(fn($s) => trim($s))->filter()->unique();
                    @endphp
                    @foreach($allSizes as $size)
                        <button type="button" @click="selectedSize = '{{ $size }}'"
                            class="min-w-[56px] h-12 px-3 border-2 border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:border-slate-400 uppercase">
                            {{ $size }}
                        </button>
                    @endforeach
                @elseif(($product->category->category_name ?? $product->category->name) == 'Mobile')
                    @foreach($product->variations as $variant)
                        <button type="button" @click="selectedSize = '{{ $variant->variant_name ?? $variant->name }}'"
                            class="min-w-[80px] h-12 px-4 border-2 border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:border-slate-400 uppercase">
                            {{ $variant->variant_name ?? $variant->name }}
                        </button>
                    @endforeach
                @endif
            </div>
        </template>
    </div>
</div>
                    {{-- Quantity --}}
                    <div class="space-y-3">
                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Quantity</span>
                        <div class="flex items-center gap-4 bg-slate-50 w-32 justify-between p-1 rounded-2xl border border-slate-100">
                            <button @click="if(count > 1) count--" class="w-8 h-8 flex items-center justify-center bg-white rounded-xl shadow-sm hover:text-primary transition-colors">-</button>
                            <span class="font-bold text-sm" x-text="count"></span>
                            <button @click="count++" class="w-8 h-8 flex items-center justify-center bg-white rounded-xl shadow-sm hover:text-primary transition-colors">+</button>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="space-y-4">
                        <form action="{{ route('add.to.cart', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="variation_id" :value="selectedVariationId">
                            {{-- Mobile aanenkil selectedSize (variant name) store cheyyuka --}}
                            <input type="hidden" name="variant_name" :value="productCategory === 'Mobile' ? selectedSize : ''">
                            <input type="hidden" name="quantity" :value="count">
                            <input type="hidden" name="size" :value="productCategory === 'Clothings' ? selectedSize : ''">
                            <input type="hidden" name="color" :value="selectedColor">
                            
                            <button class="w-full py-6 bg-slate-900 text-white rounded-3xl font-black text-sm uppercase tracking-[0.2em] shadow-xl hover:bg-primary transition-all active:scale-95 flex items-center justify-center gap-3">
                                Buy It Now
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </button>
                        </form>

                        <div class="grid grid-cols-5 gap-3">
                            <form action="{{ route('add.to.cart', $product->id) }}" method="POST" class="col-span-4">
                                @csrf    
                                <input type="hidden" name="variation_id" :value="selectedVariationId">
                                <input type="hidden" name="variant_name" :value="productCategory === 'Mobile' ? selectedSize : ''">
                                <input type="hidden" name="quantity" :value="count">
                                <input type="hidden" name="color" :value="selectedColor">
                                <input type="hidden" name="size" :value="productCategory === 'Clothings' ? selectedSize : ''">
                                
                                <button class="w-full py-6 bg-white border-2 border-slate-100 text-slate-900 rounded-3xl font-black text-sm uppercase tracking-[0.2em] hover:border-primary transition-all active:scale-95 flex items-center justify-center gap-3">
                                    Add to cart
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 100-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" /></svg>
                                </button>
                            </form>

                            <!-- Wishlist Button - scope 'main' tag-il ulla 'selectedVariationId' upayogikkunnu -->
<button 
    x-data="{ 
        liked: {{ (auth()->check() && auth()->user()->wishlist && auth()->user()->wishlist->contains('product_id', $product->id)) ? 'true' : 'false' }},
        
        async toggle() {
            @if(!auth()->check()) 
                window.location.href = '{{ route('login') }}'; 
                return; 
            @endif

            try {
                // Main scope-il ulla selectedVariationId ivide kittiye pattu
                let vId = this.selectedVariationId; 

                let response = await fetch('{{ route('wishlist.toggle', $product->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Direct CSRF token ivide nalkunnu
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        variation_id: vId // Selected variation id ayaykkunnu
                    })
                });

                if (response.ok) {
                    let data = await response.json();
                    this.liked = (data.status === 'added');
                }
            } catch (error) { 
                console.error('Error:', error); 
            }
        }
    }" 
    @click="toggle()"
    :class="liked ? 'border-red-500 bg-red-50' : 'border-slate-100 hover:border-primary'"
    class="col-span-1 flex items-center justify-center border-2 rounded-3xl transition-all duration-300 group active:scale-95"
>
    <svg xmlns="http://www.w3.org/2000/svg" 
         :class="liked ? 'text-red-500 fill-red-500' : 'text-slate-300 group-hover:text-red-500'" 
         class="h-6 w-6 transition-all duration-300" 
         fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
</button>
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex gap-10 border-t border-slate-100">
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-black uppercase text-slate-300 tracking-widest">Shipping</span>
                        <span class="text-xs font-bold">Standard Delivery</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-black uppercase text-slate-300 tracking-widest">Returns</span>
                        <span class="text-xs font-bold">30 Days</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-black uppercase text-slate-300 tracking-widest">Quality</span>
                        <span class="text-xs font-bold">Genuine Product</span>
                    </div>
                </div>
            </div> 
        </div> 
    </main>
</body>
</html>