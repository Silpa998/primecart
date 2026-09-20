<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Admin Panel</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-active { background-color: #ecfdf5; color: #10b981; border-right: 4px solid #4EA685; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
    </style>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { emerald_custom: '#4EA685' } } }
        }
    </script>
</head>
<body class="bg-[#fcfcfc] text-slate-800">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col sticky top-0 h-screen shadow-sm z-50">
            <div class="p-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-[#4EA685] rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-extrabold text-xl tracking-tight leading-tight">Prime<span class="text-[#4EA685]">Cart</span></h2>
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Control Panel</p>
                </div>
            </div>

            <nav class="flex-grow px-4 space-y-1 overflow-y-auto custom-scrollbar pt-2">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-gray-500 hover:bg-emerald-50 hover:text-[#4EA685] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('user.home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-gray-500 hover:bg-emerald-50 hover:text-[#4EA685] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    <span>Home</span>

                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-gray-500 hover:bg-emerald-50 hover:text-[#4EA685] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    <span>Orders</span>

                </a>
                
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'sidebar-active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-gray-500 hover:bg-emerald-50 hover:text-[#4EA685] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    <span>Products</span>
                </a>

                <a href="{{route('product-variations.index')}}" class="{{ request()->routeIs('product-variations.*') ? 'sidebar-active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-gray-500 hover:bg-emerald-50 hover:text-[#4EA685] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                    </svg>
                    <span>Product Variations</span>
                </a>

                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'sidebar-active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-gray-500 hover:bg-emerald-50 hover:text-[#4EA685] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01M3 21h18M3 7a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" /></svg>
                    <span>Categories</span>
                </a>

                <a href="{{ route('variations.index' )}}" class=" flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-gray-500 hover:bg-emerald-50 hover:text-[#4EA685] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Variations</span>
                </a>

                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'sidebar-active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-gray-500 hover:bg-emerald-50 hover:text-[#4EA685] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <span>Users</span>
                </a>

                <a href="#" class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-bold text-gray-500 hover:bg-emerald-50 hover:text-[#4EA685] transition-all">
                    <div class="flex items-center gap-3">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                        <span>Notifications</span>

                    </div>
                    <span class="bg-[#4EA685] text-white text-[10px] px-2 py-0.5 rounded-full ring-2 ring-white font-bold">4</span>
                </a>
                <a href="" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-gray-500 hover:bg-emerald-50 hover:text-[#4EA685] transition-all">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Roles</span>
                </a>
                </nav>

            <div class="p-4 border-t border-gray-100 bg-white">
                <div class="p-3 bg-gray-50 rounded-2xl flex items-center justify-between gap-2">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 flex-shrink-0 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center text-[#4EA685] font-bold text-xs">AD</div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-gray-900 truncate">Admin</p>
                            <p class="text-[10px] text-gray-400 truncate">admin@shop.pro</p>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                    <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="p-2 text-gray-400 hover:text-[#4EA685] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    </button>
                </div>
            </div>
        </aside>
        <main class="flex-grow p-8">
            <div class="max-w-6xl mx-auto space-y-8">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>