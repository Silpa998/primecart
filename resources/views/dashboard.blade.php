@extends('layouts.sidebar')

@section('title', 'Dashboard')

@section('content')
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard</h1>
            <p class="text-slate-500 font-medium">Monitoring sales, inventory, and users in real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <button
                class="flex items-center gap-2 bg-white border border-slate-200 px-4 py-2 rounded-lg font-bold text-slate-600 hover:bg-slate-50 transition-all text-sm shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export
            </button>
            <a href="{{ route('products.create') }}" 
                class="flex items-center gap-2 bg-[#4EA685] hover:bg-emerald-600 text-white px-5 py-2.5 rounded-lg font-bold transition-all shadow-md shadow-emerald-100 active:scale-95 text-sm inline-flex">
    
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
    
                Add Product
            </a>
        </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-emerald-50 text-[#4EA685] rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-md">+12.5%</span>
            </div>
            <p class="text-sm text-slate-400 font-bold uppercase tracking-wider">Total Sales</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">$45,285</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-blue-50 text-blue-500 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-md">Pending</span>
            </div>
            <p class="text-sm text-slate-400 font-bold uppercase tracking-wider">Active Orders</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">124</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-orange-50 text-orange-500 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-md">Urgent</span>
            </div>
            <p class="text-sm text-slate-400 font-bold uppercase tracking-wider">Low Stock</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">8 Items</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-emerald-50 text-[#4EA685] rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-md">Total</span>
            </div>
            <p class="text-sm text-slate-400 font-bold uppercase tracking-wider">Total Users</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">1,842</h3>
        </div>
    </div>

    <div
        class="bg-emerald-50 border border-emerald-100 p-5 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm shadow-emerald-50">
        <div class="flex items-center gap-4">
            <div class="bg-white p-3 rounded-xl text-[#4EA685] shadow-sm border border-emerald-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-emerald-900 leading-tight">Stock Insights Available</h4>
                <p class="text-emerald-700 text-sm mt-0.5">Your inventory levels are healthy, but 5 products are trending
                    fast. Consider restock soon.</p>
            </div>
        </div>
        <button
            class="whitespace-nowrap bg-white text-[#4EA685] px-6 py-2 rounded-xl text-sm font-bold border border-emerald-200 hover:bg-emerald-100 transition-all shadow-sm active:scale-95">
            Manage Stock
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-extrabold text-slate-900 text-lg">Recent Orders</h3>
                <div class="relative">
                    <input type="text" placeholder="Search orders..."
                        class="pl-9 pr-4 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-100 w-48 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-3 top-2.5 text-slate-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead
                        class="bg-slate-50 text-[10px] text-slate-400 uppercase font-black tracking-widest border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4 font-bold text-slate-900 text-sm">#ORD-9442</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-xs font-bold text-[#4EA685] uppercase">
                                        SJ</div>
                                    <span class="text-sm text-slate-600 font-medium">Sarah Jenkins</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-3 py-1 bg-emerald-50 text-[#4EA685] rounded-full text-[10px] font-black uppercase tracking-wider border border-emerald-100">Delivered</span>
                            </td>
                            <td class="px-6 py-4 text-right font-extrabold text-slate-900 text-sm">$299.00</td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4 font-bold text-slate-900 text-sm">#ORD-9441</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 uppercase">
                                        MC</div>
                                    <span class="text-sm text-slate-600 font-medium">Michael Chen</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-wider border border-blue-100">Shipped</span>
                            </td>
                            <td class="px-6 py-4 text-right font-extrabold text-slate-900 text-sm">$1,245.50</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="p-4 mt-auto border-t border-slate-50 text-center">
                <a href="#" class="text-[#4EA685] text-sm font-bold hover:underline">View All Orders</a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-extrabold text-slate-900 text-lg">Top Categories</h3>
            </div>
            <div class="p-6 space-y-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4EA685]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Electronics</p>
                            <p class="text-[11px] text-slate-400 font-medium">842 items sold</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-black text-emerald-500">+18%</p>
                        <div class="w-20 bg-slate-100 h-1.5 rounded-full mt-1">
                            <div class="bg-[#4EA685] h-1.5 rounded-full w-[80%]"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 pt-0 mt-auto">
                <button
                    class="w-full py-3 border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:bg-emerald-50 hover:text-[#4EA685] transition-all flex items-center justify-center gap-2">
                    Manage Categories
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div
            class="bg-gradient-to-br from-emerald-800 to-emerald-950 p-8 rounded-3xl text-white flex items-center justify-between shadow-xl shadow-emerald-200">
            <div>
                <h3 class="text-2xl font-black mb-1">New Team Member?</h3>
                <p class="text-emerald-200 text-sm max-w-[240px]">Quickly add new employees or administrators to your
                    platform.</p>
                <button
                    class="mt-6 px-6 py-2.5 bg-white text-emerald-900 rounded-xl font-black text-sm hover:scale-105 transition-all active:scale-95 shadow-lg shadow-black/20">Add
                    User Account</button>
            </div>
            <div class="hidden sm:block opacity-20 transform rotate-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>

        <div
            class="bg-[#4EA685] p-8 rounded-3xl text-white flex items-center justify-between shadow-xl shadow-emerald-200">
            <div>
                <h3 class="text-2xl font-black mb-1">Stock Refill</h3>
                <p class="text-emerald-100 text-sm max-w-[240px]">Batch upload new arrivals or update existing product
                    quantities.</p>
                <button
                    class="mt-6 px-6 py-2.5 bg-white text-[#4EA685] rounded-xl font-black text-sm hover:scale-105 transition-all active:scale-95 shadow-lg shadow-emerald-900/20">Import
                    Products</button>
            </div>
            <div class="hidden sm:block opacity-20 transform -rotate-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
        </div>
    </div>

    </div>
@endsection