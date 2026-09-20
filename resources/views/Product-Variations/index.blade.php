@extends('layouts.sidebar')

@section('content')
<style>
    :root {
        --g: #4EA685;
        --gd: #3a7d64;
        --gs: #f0faf5;
        --b: #f9fafb;
        --c1: #f3f4f6;
        --c2: #e5e7eb;
        --c3: #d1d5db;
        --c4: #9ca3af;
        --c5: #6b7280;
        --c7: #374151;
        --c9: #111827;
    }
    
    /* Split Layout Grid Fixed */
    .split-container {
        display: flex;
        background: #f0f2f5;
        margin: -24px; 
        height: calc(100vh - 60px);
        overflow: hidden;
        font-family: 'Inter', sans-serif;
    }

    /* Product List Sidebar */
    .pl-sidebar {
        width: 300px;
        flex-shrink: 0;
        background: #fff;
        border-right: 1px solid var(--c2);
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .pl-h {
        padding: 20px;
        border-bottom: 1px solid var(--c1);
    }
    .pl-h h2 {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--c4);
    }
    .sb-x {
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--b);
        border: 1px solid var(--c2);
        border-radius: 9px;
        padding: 8px 12px;
    }
    .sb-x input {
        border: none;
        background: none;
        outline: none;
        font-size: 13px;
        color: var(--c7);
        width: 100%;
    }
    .pl-items {
        flex: 1;
        overflow-y: auto;
    }
    .pi-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--c1);
        cursor: pointer;
        transition: background .12s;
        text-decoration: none;
    }
    .pi-item:hover { background: var(--b); }
    .pi-item.active {
        background: var(--gs);
        border-left: 3px solid var(--g);
    }
    .pi-th {
        width: 44px;
        height: 44px;
        border-radius: 9px;
        border: 1px solid var(--c2);
        overflow: hidden;
        flex-shrink: 0;
        background: var(--b);
    }
    .pi-th img { width: 100%; height: 100%; object-fit: cover; }
    .pi-in { flex: 1; min-width: 0; }
    .pi-n { font-size: 13px; font-weight: 600; color: var(--c9); truncate: true; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .pi-m { font-size: 11px; color: var(--c4); margin-top: 2px; }
    .vb-badge { flex-shrink: 0; background: var(--c1); color: var(--c5); font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 99px; }
    .pi-item.active .vb-badge { background: #c6eed9; color: var(--gd); }

    /* Main Variation Panel */
    .vp-panel {
        flex: 1;
        overflow-y: auto;
        padding: 24px;
        background: #f0f2f5;
        height: 100%;
    }
    .ph-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        background: #fff;
        padding: 16px 20px;
        border-radius: 16px;
        border: 1px solid var(--c2);
    }
    .ph-i { display: flex; align-items: center; gap: 14px; }
    .ph-th { width: 54px; height: 54px; border-radius: 12px; border: 1px solid var(--c2); overflow: hidden; background: #fff; }
    .ph-th img { width: 100%; height: 100%; object-fit: cover; }
    .ph-n { font-size: 18px; font-weight: 700; color: var(--c9); }
    .ph-s { font-size: 12px; color: var(--c4); margin-top: 2px; }

    /* Horizontal Variations Table View */
    .table-wrapper {
        background: #fff;
        border: 1px solid var(--c2);
        border-radius: 16px;
        overflow-x: auto;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .v-table { width: 100%; border-collapse: collapse; text-align: left; min-width: max-content; }
    .v-table th {
        background: var(--b);
        padding: 14px 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--c5);
        border-bottom: 1px solid var(--c2);
        border-right: 1px solid var(--c2);
    }
    .v-table td {
        padding: 20px;
        border-bottom: 1px solid var(--c1);
        border-right: 1px solid var(--c2);
        vertical-align: top;
        text-align: center;
    }
    .v-img-box {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        border: 1px solid var(--c2);
        overflow: hidden;
        margin: 0 auto 10px;
        background: var(--b);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .v-img-box img { width: 100%; height: 100%; object-fit: cover; }
    .v-sku { font-family: monospace; font-size: 11px; font-weight: 700; background: var(--c1); padding: 2px 6px; border-radius: 4px; color: var(--c7); }
    
    /* Action Row Inside Table Column */
    .v-actions {
        margin-top: 12px;
        padding-top: 8px;
        border-top: 1px solid var(--c1);
        display: flex;
        justify-content: center;
        gap: 12px;
        font-size: 12px;
    }
    .action-btn-edit { color: #4EA685; font-weight: 600; text-decoration: none; }
    .action-btn-edit:hover { color: var(--gd); }
    .action-btn-del { color: #ef4444; font-weight: 600; background: none; border: none; cursor: pointer; }
    .action-btn-del:hover { color: #b91c1c; }

    /* Styled Buttons */
    .btn-add {
        background: var(--g);
        color: #fff;
        font-size: 12.5px;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background .15s;
    }
    .btn-add:hover { background: var(--gd); }

    /* Hidden Utility Class */
    .hidden { display: none !important; }
    
    /* Extra styling for variation details */
    .v-details { text-align: left; font-size: 12px; margin: 8px 0; color: var(--c7); line-height: 1.5; }
    .v-details span { font-weight: 600; color: var(--c5); }
</style>

<div class="split-container">
    
    <div class="pl-sidebar">
        <div class="pl-h">
            <h2>All Products</h2>
            <div class="sb-x">
                <i class="fa-solid fa-magnifying-glass" style="color: var(--c4); font-size: 12px;"></i>
                <input type="text" id="prodSearch" onkeyup="filterProducts()" placeholder="Search products…"/>
            </div>
        </div>
        <div class="pl-items">
            @foreach($products as $index => $product)
                <a href="javascript:void(0)" 
                   class="pi-item {{ $index === 0 ? 'active' : '' }}" 
                   id="p-item-{{ $product->id }}"
                   onclick="showVariations('{{ $product->id }}', this)">
                    <div class="pi-th">
                        <img src="{{ asset('storage/' . ($product->image ?? $product->variations->whereNotNull('image')->first()?->image ?? 'default.png')) }}" alt="">
                    </div>
                    <div class="pi-in">
                        <div class="pi-n">{{ $product->product_name }}</div>
                        <div class="pi-m">Price: ₹{{ number_format($product->price ?? 0, 2) }}</div>
                    </div>
                    <div class="vb-badge">{{ $product->variations->count() }}</div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="vp-panel">
        @foreach($products as $index => $product)
            <div class="product-variant-section {{ $index === 0 ? '' : 'hidden' }}" id="variant-section-{{ $product->id }}">
                
                <div class="ph-header">
                    <div class="ph-i">
                        <div class="ph-th">
                            <img src="{{ asset('storage/' . ($product->image ?? $product->variations->whereNotNull('image')->first()?->image ?? 'default.png')) }}" alt="">
                        </div>
                        <div>
                            <div class="ph-n">{{ $product->product_name }}</div>
                            <div class="ph-s">{{ $product->category->category_name ?? 'No Category' }} · {{ $product->variations->count() }} Variations</div>
                        </div>
                    </div>
                    <a href="{{ route('product-variations.create', ['product_id' => $product->id]) }}" class="btn-add">
                        <i class="fa-solid fa-plus"></i> Add Variation
                    </a>
                </div>

                <div class="table-wrapper">
                    <table class="v-table">
                        <thead>
                            <tr>
                                <th style="width: 200px;">Product Info</th>
                                @forelse($product->variations as $vIndex => $variation)
                                    <th>Variation {{ $vIndex + 1 }} ({{ ucfirst($variation->type) }})</th>
                                @empty
                                    <th>No Variations</th>
                                @endforelse
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="background: var(--b); font-weight: bold; text-align: center;">
                                    <div class="v-img-box" style="width: 100px; height: 100px;">
                                        <img src="{{ asset('storage/' . ($product->image ?? $product->variations->whereNotNull('image')->first()?->image ?? 'default.png')) }}" alt="">
                                    </div>
                                    <span style="font-size: 13px; color: var(--c9);">{{ $product->product_name }}</span>
                                </td>

                                @forelse($product->variations as $variation)
                                    <td>
                                        <div class="v-img-box">
                                            @if($variation->image)
                                                <img src="{{ asset('storage/' . $variation->image) }}" alt="">
                                            @else
                                                <span style="font-size: 10px; color: var(--c4); font-weight: bold;">NO IMAGE</span>
                                            @endif
                                        </div>
                                        
                                        <div style="margin-bottom: 6px;">
                                            <span class="v-sku">{{ $variation->sku ?? 'NO SKU' }}</span>
                                        </div>

                                        <div class="v-details">
                                            @if($variation->color) <div><span>Color:</span> {{ $variation->color }}</div> @endif
                                            @if($variation->size) <div><span>Size:</span> {{ $variation->size }}</div> @endif
                                            @if($variation->variant) <div><span>Variant:</span> {{ $variation->variant }}</div> @endif
                                            <div><span>Price:</span> ₹{{ number_format($variation->price, 2) }}</div>
                                        </div>

                                        <div style="font-size: 12px; color: var(--c5); font-weight: 500;">
                                            Stock: 
                                            @if($variation->stock <= 5)
                                                <span style="color: #ef4444; font-weight: bold;">{{ $variation->stock }} left</span>
                                            @else
                                                <span style="color: #4EA685; font-weight: bold;">{{ $variation->stock }}</span>
                                            @endif
                                        </div>

                                        <div class="v-actions">
                                            <a href="{{ route('product-variations.edit', $variation->id) }}" class="action-btn-edit">
                                                <i class="fa-solid fa-pen" style="font-size: 10px;"></i> Edit
                                            </a>
                                            <span style="color: var(--c2)">|</span>
                                            <form action="{{ route('product-variations.destroy', $variation->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this variation?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn-del">
                                                    <i class="fa-solid fa-trash" style="font-size: 10px;"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @empty
                                    <td style="color: var(--c4); font-style: italic; font-size: 13px; text-align: left; padding: 40px;">
                                        <i class="fa-solid fa-box-open"></i> This product has no variations configured yet.
                                    </td>
                                @endforelse
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        @endforeach
    </div>

</div>

<script>
    function showVariations(productId, element) {
        // Hide all variants sections
        document.querySelectorAll('.product-variant-section').forEach(section => {
            section.classList.add('hidden');
        });
        // Remove active class from all sidebar list items
        document.querySelectorAll('.pi-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Show selected section and activate clicked item
        document.getElementById('variant-section-' + productId).classList.remove('hidden');
        element.classList.add('active');
    }

    function filterProducts() {
        let input = document.getElementById('prodSearch').value.toLowerCase();
        let items = document.querySelectorAll('.pi-item');
        
        items.forEach(item => {
            let text = item.querySelector('.pi-n').textContent.toLowerCase();
            if(text.includes(input)) {
                item.style.display = "flex";
            } else {
                item.style.display = "none";
            }
        });
    }
</script>
@endsection