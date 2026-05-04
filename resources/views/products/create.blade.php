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
    }

    html { scroll-behavior: smooth; }

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

    .form-header h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-main);
        margin-top: 40px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-header h3::after {
        content: "";
        height: 2px;
        flex: 1;
        background: linear-gradient(to right, #e2e8f0, transparent);
    }

    .form-header p {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    /* Input Styling */
    .form-group {
        margin-bottom: 24px;
    }

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
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: #fbfcfd;
        color: var(--text-main);
    }

    input:focus, select:focus {
        outline: none;
        border-color: var(--primary);
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(78, 166, 133, 0.15);
        transform: translateY(-1px);
    }

    input[type="file"] {
        border: 2px dashed #cbd5e1;
        padding: 25px;
        background: #f8fafc;
        text-align: center;
        cursor: pointer;
    }

    /* Variation Card Design */
    .variation-card {
        background: #f8fafc;
        padding: 25px;
        border-radius: 18px;
        margin-bottom: 20px;
        position: relative;
        border: 1px solid #e2e8f0;
        animation: slideIn 0.4s ease-out;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .remove-var {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #ef4444;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(239, 68, 68, 0.3);
        transition: all 0.2s;
    }

    .remove-var:hover { transform: scale(1.1); background: #dc2626; }

    /* Button Styling */
    .add-another-btn {
        width: 100%;
        background: #f1f5f9;
        color: #475569;
        padding: 12px;
        border-radius: 12px;
        border: 2px dashed #cbd5e1;
        margin-bottom: 30px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
    }

    .add-another-btn:hover {
        background: #e2e8f0;
        color: var(--text-main);
        border-color: #94a3b8;
    }

    .btn-save {
        width: 100%;
        background: linear-gradient(135deg, #4EA685 0%, #3d8a6e 100%);
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

    .btn-save:active { transform: scale(0.98); }

    hr {
        border: 0;
        height: 1px;
        background: #e2e8f0;
        margin: 40px 0;
    }

    .alert-danger {
        background: #fef2f2;
        border-left: 4px solid #ef4444;
        padding: 15px;
        border-radius: 8px;
        color: #b91c1c;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h2>Add New Product</h2>
        <p>List a new item with all its variations in one go.</p>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0; padding-left: 20px;">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="productName">Product Name</label>
            <input type="text" id="productName" name="product_name" placeholder="e.g. Premium Wireless Headphones" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category_id" required>
                <option value="">Select a Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label for="price">Base Price ($)</label>
                <input type="number" id="price" name="price" step="0.01" placeholder="0.00" required>
            </div>
            <div class="form-group" style="flex: 1;">
                <label for="stock">Initial Stock</label>
                <input type="number" id="stock" name="stock" placeholder="0" required>
            </div>
        </div>

        {{-- <div class="form-group">
            <label for="productImage">Product Image</label>
            <input type="file" name="productImage" accept="image/*">
        </div> --}}

        <div class="form-header">
    <h3>Product Variations</h3>
</div>

<div id="variations-container">
    <div class="variation-card">
        <div style="display: flex; gap: 15px;">
            <div class="form-group" style="flex: 2;">
                <label>Type</label>
                <select name="variants[0][type]" class="type-select" required onchange="toggleFields(this)">
                    <option value="">Choose Type</option>
                    <option value="home_kitchen">Home & Kitchen</option>
                    <option value="electronics">Electronics</option>
                    <option value="clothing">Clothing</option>
                    <option value="beauty_skin_care">Beauty & Skin care</option>
                    <option value="accessories">Accessories</option>
                    <option value="mobiles">Mobiles</option>
                </select>
            </div>
            <div class="form-group" style="flex: 1;">
                <label>SKU (Code)</label>
                <input type="text" name="variants[0][sku]" placeholder="e.g. WH-BLK-01">
            </div>
        </div>

        <div class="dynamic-fields"></div>

        <div style="display: flex; gap: 15px; margin-top: 15px;">
            <div class="form-group" style="flex: 1;">
                <label>Variation Price ($)</label>
                <input type="number" name="variants[0][price]" step="0.01" placeholder="0.00" required>
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Variation Stock</label>
                <input type="number" name="variants[0][stock]" placeholder="0" required>
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Color</label>
                <input type="text" name="variants[0][color]" placeholder="e.g. Black">
            </div>
        </div>

        <div class="form-group" style="margin-top:15px; margin-bottom:0;">
            <label>Variation Image</label>
            <input type="file" name="variants[0][image]" accept="image/*" style="padding: 10px; border: 1.5px solid #e2e8f0; border-style: solid; background: #fff;">
        </div>
    </div>
</div>

<button type="button" class="add-another-btn" id="add-variant-btn">
    + Add Another Variation
</button>

<button type="submit" class="btn-save">
            Save Product & All Variations
</button>
</form>

<script>
    let variantCount = 1;

    function toggleFields(selectElement) {
        const type = selectElement.value;
        const container = selectElement.closest('.variation-card').querySelector('.dynamic-fields');
        const index = selectElement.name.match(/\d+/)[0];

        let html = '';
        if (type === 'clothing') {
            html = `
                <div class="form-group">
                    <label>Size</label>
                    <input type="text" name="variants[${index}][size]" placeholder="e.g. XL, L, M">
                </div>`;
        } else if (type === 'mobiles' || type === 'electronics') {
            html = `
                <div class="form-group">
                    <label>Variant Info (RAM/Storage)</label>
                    <input type="text" name="variants[${index}][variant]" placeholder="e.g. 8GB/128GB">
                </div>`;
        }
        container.innerHTML = html;
    }

    document.getElementById('add-variant-btn').addEventListener('click', function() {
        const container = document.getElementById('variations-container');
        const newCard = document.createElement('div');
        newCard.className = 'variation-card';
        newCard.innerHTML = `
            <span class="remove-var" onclick="this.parentElement.remove()">✕</span>
            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 2;">
                    <label>Type</label>
                    <select name="variants[${variantCount}][type]" class="type-select" required onchange="toggleFields(this)">
                        <option value="">Choose Type</option>
                        <option value="home_kitchen">Home & Kitchen</option>
                        <option value="electronics">Electronics</option>
                        <option value="clothing">Clothing</option>
                        <option value="beauty_skin_care">Beauty & Skin care</option>
                        <option value="accessories">Accessories</option>
                        <option value="mobiles">Mobiles</option>
                    </select>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>SKU (Code)</label>
                    <input type="text" name="variants[${variantCount}][sku]" placeholder="SKU">
                </div>
            </div>
            <div class="dynamic-fields"></div>
            <div style="display: flex; gap: 15px; margin-top: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label>Price</label>
                    <input type="number" name="variants[${variantCount}][price]" step="0.01" placeholder="0.00" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Stock</label>
                    <input type="number" name="variants[${variantCount}][stock]" placeholder="0" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Color</label>
                    <input type="text" name="variants[${variantCount}][color]" placeholder="Color">
                </div>
            </div>
            <div class="form-group" style="margin-bottom:0; margin-top:15px;">
                <label>Variation Image</label>
                <input type="file" name="variants[${variantCount}][image]" accept="image/*" style="padding: 10px; border: 1.5px solid #e2e8f0; border-style: solid; background: #fff;">
            </div>
        `;
        container.appendChild(newCard);
        variantCount++;
    });
</script>
@endsection

 