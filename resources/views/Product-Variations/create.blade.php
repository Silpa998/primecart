@extends('layouts.sidebar')

@section('content')
<style>
    :root {
        --g: #4EA685;
        --gd: #3a7d64;
        --b: #f9fafb;
        --c2: #e5e7eb;
        --c5: #6b7280;
        --c7: #374151;
        --c9: #111827;
    }

    .form-container {
        max-width: 600px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 16px;
        border: 1px solid var(--c2);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        font-family: 'Inter', sans-serif;
    }

    .form-header {
        margin-bottom: 24px;
        border-bottom: 1px solid var(--c2);
        padding-bottom: 16px;
    }

    .form-header h2 {
        font-size: 20px;
        color: var(--c9);
        margin: 0;
    }

    .form-header p {
        font-size: 13px;
        color: var(--c5);
        margin: 4px 0 0 0;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--c7);
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        font-size: 14px;
        border: 1px solid var(--c2);
        border-radius: 8px;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        border-color: var(--g);
    }

    .row-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .btn-submit {
        background: var(--g);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        width: 100%;
        transition: background 0.15s;
    }

    .btn-submit:hover {
        background: var(--gd);
    }

    .text-danger {
        color: #ef4444;
        font-size: 12px;
        margin-top: 4px;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h2>Add New Variation</h2>
        <p>Product: <strong>{{ $product->product_name }}</strong></p>
    </div>

    <form action="{{ route('product-variations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Hidden input for product_id -->
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div class="row-grid">
            <div class="form-group">
                <label for="type">Variation Type * (e.g., electronics, clothing)</label>
                <input type="text" name="type" id="type" class="form-control" value="{{ old('type') }}" placeholder="Enter variation type" required>
                @error('type') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="sku">SKU Code (Optional)</label>
                <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku') }}" placeholder="e.g. SKU-1234">
                @error('sku') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row-grid">
            <div class="form-group">
                <label for="color">Color (Optional)</label>
                <input type="text" name="color" id="color" class="form-control" value="{{ old('color') }}" placeholder="e.g. Red, Blue">
                @error('color') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="size">Size (Optional)</label>
                <input type="text" name="size" id="size" class="form-control" value="{{ old('size') }}" placeholder="e.g. M, XL, L">
                @error('size') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="variant">Variant Name (Optional)</label>
            <input type="text" name="variant" id="variant" class="form-control" value="{{ old('variant') }}" placeholder="e.g. 64GB, 128GB">
            @error('variant') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="row-grid">
            <div class="form-group">
                <label for="price">Price (₹) *</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price', '0.00') }}" required>
                @error('price') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="stock">Stock Quantity *</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', '0') }}" required>
                @error('stock') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="image">Variation Image (Optional)</label>
            <input type="file" name="image" id="image" class="form-control">
            @error('image') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn-submit">Save Variation</button>
    </form>
</div>
@endsection