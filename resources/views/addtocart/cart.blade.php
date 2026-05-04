<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - PrimeCart Digital</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="text-slate-900">

    <nav class="py-8 px-6 max-w-7xl mx-auto flex justify-between items-center">
        <a href="/" class="flex items-center gap-2">
            <div class="w-10 h-10 bg-[#4EA685] rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <span class="font-extrabold text-2xl tracking-tighter uppercase">Prime<span class="text-[#4EA685]">Cart</span></span>
        </a>
        <a href="{{ route('user.home') }}" class="text-xs font-black uppercase tracking-widest text-slate-900 hover:text-[#4EA685] transition-all">
            ← Back to Home
        </a>   
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="grid grid-cols-12 gap-12">
            
            {{-- Cart Items Section --}}
            <div class="col-span-12 lg:col-span-8">
                <div class="flex items-baseline justify-between mb-8">
                    <h1 class="text-5xl font-black tracking-tight">Cart.</h1>
                    <span class="text-slate-400 font-bold uppercase tracking-widest text-xs">
                        {{ count($cartItems) }} Items
                    </span>
                </div>

                <div class="space-y-4">
                    @php $total = 0; @endphp

                    @forelse($cartItems as $id => $item)
                        @php 
                            $isLoggedIn = Auth::check();
                            
                            if($isLoggedIn) {
                                $productId    = $item->product_id;
                                $variant      = $item->variation;

                                $productName  = $item->product->product_name;
                                $categoryName = $item->product->category->category_name ?? '';
                                $quantity     = $item->quantity;
                                $variant      = $item->variation; 
                                
                                $displayPrice = ($item->variation && $item->variation->price) ? $item->variation->price : $item->product->price;
                               
                                $image        = ($item->variation && $item->variation->image) ? $item->variation->image : $item->product->image;
                               
                                $selColor     = $item->selected_color;
                                $selSize      = $item->selected_size;
                                $selVariant   = $item->selected_variant;
                                $deleteId = $item->id;
                            } else {
                                $productId    = $item['product_id'];
                                $vId          = $item['variant_id'] ?? null;
                                $variant      = $vId ? \App\Models\ProductVariation::find($vId) : null;
                                
                                $productName  = $item['product_name'];
                                $quantity     = $item['quantity'];
                                $displayPrice = $item['price'] ?? 0;

                                if ($variant && $variant->image) {
                                    $image = $variant->image;
                                } else {
                                    $prod = \App\Models\Product::find($productId);
                                    $image = $item['image'] ?? ($prod ? $prod->image : '');
                                }
                                
                                $prod         = \App\Models\Product::with('category')->find($productId);
                                $categoryName = $prod->category->category_name ?? '';

                                $deleteId = $id;
                                
                                 
                                if(!$variant && $prod && $prod->variations->count() > 0) {
                                      $variant = $prod->variations->first();
                             }
                                // $displayPrice = ($variant && $variant->price) ? $variant->price : ($item['price'] ?? 0);
                                // $image        = ($variant && $variant->image) ? $variant->image : ($item['image'] ?? '');
                                
                                $selColor     = $item['selected_color'] ?? null;                             
                                $selSize      = $item['selected_size'] ?? ($variant ? $variant->size : null);
                                $selVariant   = $item['selected_variant'] ?? ($variant ? $variant->variant_name : null);
                            }
                            $removeId   = ($variant && isset($variant->id)) ? $variant->id : $productId;
                            $removeType = ($variant && isset($variant->id)) ? 'variant' : 'product';
                            $sessionKey = $id;

                            $subtotal = $displayPrice * $quantity;
                            $total += $subtotal;
                        @endphp

                        <div class="group bg-white rounded-[32px] p-4 flex items-center gap-6 border border-slate-100">
                            <div class="w-32 h-32 bg-slate-50 rounded-[24px] overflow-hidden flex-shrink-0">
                                <img src="{{ $image ? asset('storage/' . $image) : asset('images/no-image.png') }}" 
                                    alt="{{ $productName }}"
                                    class="w-full h-full object-cover">
                            </div>

                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-slate-900 mb-1">{{ $productName }}</h3>
                                
                                {{-- Variants Display Logic --}}
                                <div class="mt-2 flex flex-wrap gap-2">
                                    {{-- Variants Display Logic --}}
<div class="mt-2 flex flex-wrap gap-2">
    @if($categoryName === 'Clothings')
        {{-- Color --}}
        @if($selColor)
            <div class="px-2 py-1 bg-slate-50 text-slate-600 text-[10px] font-bold uppercase rounded border border-slate-100">
                Color: {{ $selColor }}
            </div>
        @endif

        {{-- Size: users select cheythillelum nammal PHP-yil set cheytha default size ivide varum --}}
        @if($selSize)
            <span class="px-2 py-1 bg-slate-50 text-slate-600 text-[10px] font-bold uppercase rounded border border-slate-100">
                Size: {{ $selSize }}
            </span>
        @endif

    @elseif($categoryName === 'Mobile')
        {{-- Mobile Logic (Same as before) --}}
        @if($selColor)
            <div class="px-2 py-1 bg-slate-50 text-slate-600 text-[10px] font-bold uppercase rounded border border-slate-100">
                Color: {{ $selColor }}
            </div>
        @endif
        @if($selVariant)
            <span class="px-2 py-1 bg-emerald-50 text-[#4EA685] text-[10px] font-bold uppercase rounded border border-emerald-100">
                {{ $selVariant }}
            </span>
        @endif

    @else
        {{-- Default logic --}}
        @if($selVariant)
            <span class="px-2 py-1 bg-slate-50 text-slate-600 text-[10px] font-bold uppercase rounded border border-slate-100">
                {{ $selVariant }}
            </span>
        @endif
    @endif
</div>
                                </div>

                                <p class="text-slate-400 text-sm mt-2">₹{{ number_format($displayPrice) }} / unit</p>            
                                
                                <div class="flex items-center gap-4 mt-4">
                                    <div class="flex items-center border border-slate-100 rounded-lg bg-white overflow-hidden">
                                        <button class="px-3 py-1 update-cart-minus" data-id="{{ $productId }}">−</button>
                                        <span class="px-4 py-1 text-sm font-bold quantity-value">{{ $quantity }}</span>
                                        <button class="px-3 py-1 update-cart-plus" data-id="{{ $productId }}">+</button>
                                    </div>

                                    <a href="{{ route('checkout.single', $productId) }}" class="px-5 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-[#4EA685] transition-all active:scale-95 flex items-center gap-2">
                                        Checkout
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" /></svg>
                                    </a>
                                </div>
                            </div>

                            <div class="text-right pr-4">
                                <p class="text-slate-400 text-sm">Total</p>
                                <p class="text-2xl font-black text-slate-900">₹{{ number_format($subtotal) }}</p>
                                <a href="{{ route('remove.from.cart', [$deleteId, $isLoggedIn ? 'auth' : 'guest']) }}" 
                                    class="text-red-400 hover:text-red-600 font-bold uppercase text-[10px] tracking-widest">
                                    Remove
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="py-20 text-center bg-white rounded-[40px] border border-dashed border-slate-200">
                            <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Your cart is empty</p>
                        </div>
                    @endforelse
                </div>
            </div> 

            {{-- Summary Section --}}
            <div class="col-span-12 lg:col-span-4">
                <div class="bg-white rounded-[40px] p-10 border border-slate-100 shadow-sm sticky top-10">
                    <h2 class="text-2xl font-black mb-8 italic">Summary</h2>
                    <div class="space-y-6">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-bold uppercase text-[11px] tracking-widest">Subtotal</span>
                            <span class="font-bold text-lg text-slate-900">₹{{ number_format($total) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-bold uppercase text-[11px] tracking-widest">Shipping</span>
                            <span class="font-bold text-emerald-500 tracking-widest text-xs">FREE</span>
                        </div>
                        <div class="h-px bg-slate-100 my-2"></div>
                        <div>
                            <span class="text-slate-400 font-bold uppercase text-[11px] tracking-widest">Total Amount</span>
                            <p class="text-4xl font-black text-slate-900">₹{{ number_format($total) }}</p>
                        </div>

                        @if(count($cartItems) > 0)
                            <a href="{{ Auth::check() ? route('checkout') : route('login', ['message' => 'checkout']) }}" class="block">
                                <button type="button" class="w-full py-6 bg-[#4EA685] text-white rounded-[24px] font-black text-lg uppercase tracking-tighter hover:bg-[#3d8b6e] shadow-xl shadow-emerald-100 transition-all active:scale-95 flex items-center justify-center gap-3">
                                    {{ Auth::check() ? 'Checkout Now' : 'Checkout' }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                </button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.querySelectorAll('.update-cart-plus, .update-cart-minus').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const quantityElement = this.parentElement.querySelector('.quantity-value');
                let currentQuantity = parseInt(quantityElement.innerText);
                const newQuantity = this.classList.contains('update-cart-plus') ? currentQuantity + 1 : (currentQuantity > 1 ? currentQuantity - 1 : 1);

                fetch("{{ route('update.cart') }}", {
                    method: "PATCH",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                    body: JSON.stringify({ id: id, quantity: newQuantity })
                })
                .then(response => response.json())
                .then(data => location.reload())
                .catch(error => console.error('Error:', error));
            });
        });
    </script>     
</body>
</html>