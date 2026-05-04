@extends('layouts.sidebar')

@section('content')
<style>
    .form-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 30px;
        background-color: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 20px;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }
    .form-header { margin-bottom: 25px; }
    .form-header h2 { margin: 0; font-size: 1.5rem; font-weight: 800; color: #0f172a; }
    .form-group { margin-bottom: 20px; }
    label { display: block; margin-bottom: 8px; font-weight: 700; color: #334155; font-size: 0.85rem; text-transform: uppercase; }
    input, select { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; background-color: #f8fafc; }
    input:focus { outline: none; border-color: #4EA685; background-color: #fff; box-shadow: 0 0 0 4px rgba(78, 166, 133, 0.1); }
    
    .current-image-preview {
        margin-top: 10px;
        border-radius: 10px;
        width: 100px;
        height: 100px;
        object-cover: cover;
        border: 1px solid #e2e8f0;
    }

    .btn-save {
        width: 100%;
        background-color: #4EA685;
        color: white;
        padding: 14px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-save:hover { background-color: #059669; transform: translateY(-1px); }
</style>

<div class="form-container">
    <div class="form-header">
        <h2>Edit Product</h2>
        <p>Update the details for <strong>{{ $product->product_name }}</strong></p>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') @if ($errors->any())
            <div style="color: red; margin-bottom: 15px; font-size: 0.8rem;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="productName">Product Name</label>
            <input type="text" id="productName" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category_id">
                @foreach($categories as $category)
                <option value="{{ $category->id }}" 
                    {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
                @endforeach
            </select>
        </div>

        <div style="display: flex; gap: 15px;">
            <div class="form-group" style="flex: 1;">
                <label for="price">Price ($)</label>
                <input type="number" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
            </div>
            
            <div class="form-group" style="flex: 1;">
                <label for="stock">Stock Quantity</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
            </div>
        </div>

        <div class="form-group">
    <label for="productImage">Update Product Image</label>
    <input type="file" id="productImage" name="productImage" accept="image/*">
    
    @if($product->image)
        {{-- show current main image(products table) --}}
        <div style="margin-top: 10px;">
            <p style="font-size: 0.7rem; color: #64748b; margin-bottom: 5px;">Current Main Image:</p>
            <img src="{{ asset('storage/' . $product->image) }}" class="current-image-preview" style="height: 80px; width: 80px; object-cover; border-radius: 8px;">
        </div>
    @else
        {{-- check for image in variations --}}
        @php
            $variantWithImage = $product->variations->whereNotNull('image')->first();
        @endphp

        @if($variantWithImage)
            <div style="margin-top: 10px;">
                <p style="font-size: 0.7rem; color: #64748b; margin-bottom: 5px;">Current Image:</p>
                <img src="{{ asset('storage/' . $variantWithImage->image) }}" class="current-image-preview" style="height: 80px; width: 80px; object-cover; border-radius: 8px;">
            </div>
        @else
            {{-- both main image and variant images are missing --}}
            <div style="margin-top: 10px;">
                <p style="font-size: 0.7rem; color: #94a3b8;">No current image available.</p>
            </div>
        @endif
    @endif
</div>

        <button type="submit" class="btn-save">
            Update Product
        </button>
    </form>
</div>
@endsection