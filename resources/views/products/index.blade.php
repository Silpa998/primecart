@extends('layouts.sidebar')

@section('content')

<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($products as $product)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <img src="{{ asset('storage/' . ($product->image ?? $product->variations->whereNotNull('image')->first()?->image)) }}" 
                        class="h-12 w-12 object-cover rounded">                </td>
                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                    {{ $product->product_name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                    {{ $product->category->category_name ?? 'No Category' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                    ${{ number_format($product->price, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($product->stock <= 5)
                        <span class="text-red-600 font-bold">Only {{ $product->stock }} left!</span>
                    @else
                        <span class="text-gray-600">{{ $product->stock }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex items-center gap-4"> 
                   {{-- Edit Route: products.edit --}}
                    <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">
                      <i class="fa-solid fa-pen"></i>
                    </a>

                    {{-- Delete Route: products.destroy --}}
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this product?')">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection