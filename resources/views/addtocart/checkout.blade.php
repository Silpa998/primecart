<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - PrimeCart Digital</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Plus Jakarta Sans', ui-sans-serif, system-ui;
            --color-brand: #4EA685;
            --color-brandHover: #3d8b6e;
        }

        @layer base {
            body { 
                @apply bg-[#f8fafc] text-slate-900 antialiased; 
            }
        }
    </style>
</head>
<body>

    <nav class="py-8 px-6 max-w-7xl mx-auto flex justify-between items-center">
        <a href="/" class="flex items-center gap-2">
            <div class="w-10 h-10 bg-brand rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <span class="font-extrabold text-2xl tracking-tighter uppercase">Prime<span class="text-brand">Cart</span></span>
        </a>
        <a href="{{ route('cart') }}" class="text-xs font-black uppercase tracking-widest text-slate-900 hover:text-brand transition-all">
            &larr; Back to Cart
        </a>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-6">
        <form action="" method="POST">
            @csrf
            <div class="grid grid-cols-12 gap-12">
                
                <div class="col-span-12 lg:col-span-8 space-y-8">
                    <h1 class="text-5xl font-black tracking-tight mb-8">Checkout.</h1>

                    <div class="bg-white rounded-[32px] p-8 border border-slate-100 shadow-sm">
                        <h2 class="text-xl font-bold mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 bg-emerald-100 text-brand rounded-full flex items-center justify-center text-sm font-black">1</span>
                            Shipping Information
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400">Full Name</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" required 
                                    class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400">Phone Number</label>
                                <input type="text" name="phone" required placeholder="0000 000 000"
                                    class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
                            </div>
                            <div class="col-span-full space-y-2">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400">Shipping Address</label>
                                <textarea name="address" rows="3" required placeholder="Street address, City, Pincode"
                                    class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-[32px] p-8 border border-slate-100 shadow-sm">
                        <h2 class="text-xl font-bold mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 bg-emerald-100 text-brand rounded-full flex items-center justify-center text-sm font-black">2</span>
                            Payment Method
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="relative flex items-center p-5 border-2 border-brand bg-emerald-50/30 rounded-2xl cursor-pointer">
                                <input type="radio" name="payment_method" value="cod" checked class="w-4 h-4 accent-brand">
                                <div class="ml-4">
                                    <p class="font-bold text-slate-900">Cash on Delivery</p>
                                    <p class="text-xs text-slate-500">Pay when you receive the product</p>
                                </div>
                            </label>
                            
                            <div class="relative flex items-center p-5 border-2 border-slate-100 rounded-2xl opacity-50 cursor-not-allowed">
                                <div class="w-4 h-4 border-2 border-slate-200 rounded-full"></div>
                                <div class="ml-4">
                                    <p class="font-bold text-slate-400">Online Payment</p>
                                    <p class="text-xs text-slate-400">Coming soon</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-4">
                    <div class="bg-white rounded-[40px] p-8 border border-slate-100 shadow-sm sticky top-10">
                        <h2 class="text-2xl font-black mb-6 italic">Summary</h2>
                        
                        <div class="space-y-4 mb-6 max-h-48 overflow-y-auto pr-2">
                            @foreach($cartItems as $item)
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 font-bold truncate max-w-[150px]">{{ $item->product->product_name }}</span>
                                <span class="text-slate-400 text-[10px] mx-2">x{{ $item->quantity }}</span>
                                <span class="font-black text-slate-900">₹{{ number_format($item->product->price * $item->quantity) }}</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="space-y-4 pt-6 border-t border-slate-100">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Subtotal</span>
                                <span class="font-bold text-slate-900">₹{{ number_format($total) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Shipping</span>
                                <span class="font-bold text-emerald-500">FREE</span>
                            </div>
                            
                            <div class="h-px bg-slate-100 my-2"></div>
                            
                            <div class="flex justify-between items-end pb-4">
                                <div>
                                    <span class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Total Amount</span>
                                    <p class="text-3xl font-black text-slate-900">₹{{ number_format($total) }}</p>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-5 bg-brand text-white rounded-2xl font-black text-lg uppercase tracking-tighter hover:bg-brandHover shadow-xl shadow-emerald-100 transition-all active:scale-95 flex items-center justify-center gap-3">
                                Confirm Order
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

</body>
</html>