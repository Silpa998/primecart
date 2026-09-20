@extends('layouts.sidebar')

@section('content')
<style>
    :root {
        --primary: #4EA685;
        --primary-hover: #059669;
        --bg-light: #f8fafc;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --card-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --border-color: #e2e8f0;
    }

    /* Main Container Styles */
    .form-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 40px;
        background: #ffffff;
        border-radius: 24px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .form-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .form-header h2 {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--text-main);
        letter-spacing: -0.025em;
        margin-bottom: 8px;
    }

    .form-header p {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .form-section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 40px 0 20px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-section-title::after {
        content: "";
        height: 2px;
        flex: 1;
        background: linear-gradient(to right, var(--border-color), transparent);
    }

    /* Input Styling */
    .form-group {
        margin-bottom: 24px;
    }
    
    .form-row {
        display: flex;
        gap: 20px;
    }
    
    .flex-1 { flex: 1; }
    .flex-2 { flex: 2; }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: #475569;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    input, select {
        width: 100%;
        padding: 14px 16px;
        border: 1.5px solid var(--border-color);
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: #fbfcfd;
        color: var(--text-main);
    }

    input[type="file"] {
        padding: 12px; 
        background: #ffffff;
        cursor: pointer;
    }

    input:focus, select:focus {
        outline: none;
        border-color: var(--primary);
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(78, 166, 133, 0.15);
        transform: translateY(-1px);
    }

    .current-image-preview {
        margin-top: 10px;
        border-radius: 10px;
        width: 70px;
        height: 70px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
    }

    /* Variation Card Design */
    .variation-card {
        background: var(--bg-light);
        padding: 25px;
        border-radius: 18px;
        margin-bottom: 20px;
        border: 1px solid var(--border-color);
    }

    .btn-save {
        width: 100%;
        background: linear-gradient(135deg, var(--primary) 0%, #3d8a6e 100%);
        color: white;
        padding: 16px;
        border: none;
        border-radius: 14px;
        font-size: 17px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 10px 15px -3px rgba(78, 166, 133, 0.4);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -3px rgba(78, 166, 133, 0.5);
        filter: brightness(1.1);
    }

    .alert-danger {
        background-color: #fef2f2;
        border: 1px solid #fca5a5;
        color: #991b1b;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14px;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h2>Edit Product</h2>
        <p>Update properties and variations for <strong>{{ $product->product_name }}</strong></p>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error) 
                        <li>{{ $error }}</li> 
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ================= BASE PRODUCT INFO ================= -->
        <div class="form-group">
            <label for="productName">Product Name</label>
            <input type="text" id="productName" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group flex-1">
                <label for="price">Base Price (₹)</label>
                <input type="number" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="form-group flex-1">
                <label for="stock">Base Stock</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="productImage">Product Base Image</label>
            <input type="file" id="productImage" name="image" accept="image/*">
            @if($product->image)
                <div>
                    <p style="font-size: 0.7rem; color: #64748b; margin-top: 8px; margin-bottom: 2px;">Current Base Image:</p>
                    <img src="{{ asset('storage/' . $product->image) }}" class="current-image-preview">
                </div>
            @endif
        </div>

        <!-- ================= EDIT EXISTING VARIATIONS ================= -->
        <h3 class="form-section-title">Edit Variations</h3>

        <div id="variations-container">
            @forelse($product->variations as $index => $variant)
                <div class="variation-card">
                    <!-- Hidden field pass the ID to your Controller updates -->
                    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">

                    <div class="form-row">
                        <div class="form-group flex-2">
                            <label>Type / Classification</label>
                            <!-- Kept descriptive, set to read-only style via disabled to maintain core structure integrity -->
                            <input type="text" value="{{ ucfirst($variant->type) }}" style="background-color: #f1f5f9; color: #64748b; cursor: not-allowed;" readonly>
                            <input type="hidden" name="variants[{{ $index }}][type]" value="{{ $variant->type }}">
                        </div>
                        <div class="form-group flex-1">
                            <label>SKU (Code)</label>
                            <input type="text" name="variants[{{ $index }}][sku]" value="{{ old("variants.$index.sku", $variant->sku) }}" required>
                        </div>
                    </div>

                    <!-- Dynamic Fields rendering based on structural classification -->
                    @if($variant->type === 'clothing')
                        <div class="form-group">
                            <label>Size</label>
                            <input type="text" name="variants[{{ $index }}][size]" value="{{ old("variants.$index.size", $variant->size) }}" placeholder="e.g. XL, L, M">
                        </div>
                    @elseif($variant->type === 'mobiles' || $variant->type === 'electronics')
                        <div class="form-group">
                            <label>Variant Info (RAM/Storage)</label>
                            <input type="text" name="variants[{{ $index }}][variant]" value="{{ old("variants.$index.variant", $variant->variant) }}" placeholder="e.g. 8GB/128GB">
                        </div>
                    @endif

                    <div class="form-row" style="margin-top: 15px;">
                        <div class="form-group flex-1">
                            <label>Variation Price (₹)</label>
                            <input type="number" name="variants[{{ $index }}][price]" step="0.01" value="{{ old("variants.$index.price", $variant->price) }}" required>
                        </div>
                        <div class="form-group flex-1">
                            <label>Variation Stock</label>
                            <input type="number" name="variants[{{ $index }}][stock]" value="{{ old("variants.$index.stock", $variant->stock) }}" required>
                        </div>
                        <div class="form-group flex-1">
                            <label>Color</label>
                            <input type="text" name="variants[{{ $index }}][color]" value="{{ old("variants.$index.color", $variant->color) }}" placeholder="e.g. Black">
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 15px; margin-bottom: 0;">
                        <label>Variation Image</label>
                        <input type="file" name="variants[{{ $index }}][image]" accept="image/*">
                        @if($variant->image)
                            <div style="margin-top: 8px;">
                                <p style="font-size: 0.7rem; color: #64748b; margin-bottom: 2px;">Current Variant Image:</p>
                                <img src="{{ asset('storage/' . $variant->image) }}" class="current-image-preview">
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <p style="color: var(--text-muted); font-size: 0.9rem; text-align: center; margin: 30px 0;">
                    This product does not have any active variations assigned.
                </p>
            @endforelse
        </div>

        <button type="submit" class="btn-save" style="margin-top: 10px;">
            Update Product & Variations
        </button>
    </form>
</div>
@endsection