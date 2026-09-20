@extends('layouts.sidebar')

@section('content')
<!-- Tom Select CSS (For Tag-styled Multi-select) -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

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

    .form-header p {
        color: var(--text-muted);
        font-size: 0.95rem;
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

    /* Customizing Tom Select Tags to match your green theme */
    .ts-wrapper.multi .ts-control > div {
        background: var(--primary) !important;
        color: #fff !important;
        border-radius: 8px !important;
        padding: 3px 10px !important;
    }
    .ts-control {
        border-radius: 12px !important;
        padding: 10px 14px !important;
        background-color: #fbfcfd !important;
        border: 1.5px solid var(--border-color) !important;
    }
    .ts-focused .ts-control {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 4px rgba(78, 166, 133, 0.15) !important;
    }

    /* Variation Card Design */
    .variation-card {
        background: var(--bg-light);
        padding: 25px;
        border-radius: 18px;
        margin-bottom: 20px;
        position: relative;
        border: 1px solid var(--border-color);
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

    .btn-save:active { transform: scale(0.98); }
    
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
        <h2>Add New Product</h2>
        <p>List a new item with all its variations in one go.</p>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error) 
                        <li>{{ $error }}</li> 
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="productName">Product Name</label>
            <input type="text" id="productName" name="product_name" placeholder="e.g. Premium Wireless Headphones" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category_id" required onchange="updateVariationDropdowns()">
                <option value="">Select a Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" data-variations='{!! json_encode($category->mapped_variations ?? []) !!}'>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group flex-1">
                <label for="price">Base Price (₹)</label>
                <input type="number" id="price" name="price" step="0.01" placeholder="0.00" required>
            </div>
            <div class="form-group flex-1">
                <label for="stock">Initial Stock</label>
                <input type="number" id="stock" name="stock" placeholder="0" required>
            </div>
        </div>

        <div class="form-group">
            <label for="productImage">Product Base Image</label>
            <input type="file" id="productImage" name="image" accept="image/*">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="1">Active</option>
                <option value="0" selected>Inactive</option>
            </select>
        </div>

        <h3 class="form-section-title">Product Variations</h3>

        <div id="variations-container">
            <div class="variation-card">
                <div class="form-row">
                    <div class="form-group flex-2">
                        <label>Type (Select Multiple)</label>
                        <select name="variants[0][type][]" class="type-select" multiple required onchange="toggleFields(this)">
                            <!-- Options dynamically loaded from category -->
                        </select>
                    </div>
                    <div class="form-group flex-1">
                        <label>SKU (Code)</label>
                        <input type="text" name="variants[0][sku]" placeholder="e.g. WH-BLK-01" required>
                    </div>
                </div>

                <div class="dynamic-fields form-row" style="flex-wrap: wrap; margin-top: 15px;"></div>

                <div class="form-row" style="margin-top: 15px;">
                    <div class="form-group flex-1">
                        <label>Variation Price (₹)</label>
                        <input type="number" name="variants[0][price]" step="0.01" placeholder="0.00" required>
                    </div>
                    <div class="form-group flex-1">
                        <label>Variation Stock</label>
                        <input type="number" name="variants[0][stock]" placeholder="0" required>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 15px; margin-bottom: 0;">
                    <label>Variation Image</label>
                    <input type="file" name="variants[0][image]" accept="image/*">
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
</div>

<!-- Tom Select JS JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    let variantCount = 1;
    let tomSelectInstances = {};
    let currentCategoryVariations = []; 

    function initTomSelect(element) {
        if (element.tomselect) {
            element.tomselect.destroy();
        }
        return new TomSelect(element, {
            plugins: ['remove_button'],
            create: false,
            maxItems: null,
            placeholder: 'Choose Types...',
            valueField: 'value',
            labelField: 'text',
            searchField: 'text'
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        const firstSelect = document.querySelector('.type-select');
        tomSelectInstances[0] = initTomSelect(firstSelect);
        updateVariationDropdowns();
    });

    function updateVariationDropdowns() {
        const categorySelect = document.getElementById('category');
        const selectedOption = categorySelect.options[categorySelect.selectedIndex];
        
        if (selectedOption && selectedOption.dataset.variations) {
            try {
                currentCategoryVariations = JSON.parse(selectedOption.dataset.variations);
            } catch (e) {
                currentCategoryVariations = [];
            }
        } else {
            currentCategoryVariations = [];
        }

        let selectOptions = [];
        if (Array.isArray(currentCategoryVariations)) {
            selectOptions = currentCategoryVariations.map(v => {
                return { value: v.slug, text: v.name }; 
            });
        }

        const typeSelects = document.querySelectorAll('.type-select');
        
        typeSelects.forEach((select) => {
            const nameMatch = select.name.match(/\d+/);
            const currentIdx = nameMatch ? nameMatch[0] : 0;
            
            const tsInstance = tomSelectInstances[currentIdx];
            if (tsInstance) {
                let currentValues = tsInstance.getValue();
                if(!Array.isArray(currentValues)) currentValues = currentValues ? [currentValues] : [];

                tsInstance.clear();        
                tsInstance.clearOptions();
                
                if (selectOptions.length > 0) {
                    tsInstance.addOption(selectOptions);
                    tsInstance.refreshOptions(false);
                    
                    let validValues = currentValues.filter(val => selectOptions.some(opt => opt.value === val));
                    tsInstance.setValue(validValues);
                }
            }
            toggleFields(select);
        });
    }

    function toggleFields(selectElement) {
        const nameMatch = selectElement.name.match(/\d+/);
        const index = nameMatch ? nameMatch[0] : 0;
        
        let selectedSlugs = [];
        if (tomSelectInstances[index]) {
            selectedSlugs = tomSelectInstances[index].getValue();
            if(!Array.isArray(selectedSlugs)) selectedSlugs = selectedSlugs ? [selectedSlugs] : [];
        }

        const container = selectElement.closest('.variation-card').querySelector('.dynamic-fields');
        let html = '';
        
        selectedSlugs.forEach(slug => {
            const matchedVar = currentCategoryVariations.find(v => v.slug === slug);
            const labelName = matchedVar ? matchedVar.name : (slug.charAt(0).toUpperCase() + slug.slice(1));

            html += `
                <div class="form-group flex-1" style="min-width: 150px;">
                    <label>${labelName}</label>
                    <input type="text" 
                           name="variants[${index}][${slug}]" 
                           placeholder="Enter ${labelName}" 
                           required>
                </div>`;
        });
        
        container.innerHTML = html;
    }

    document.getElementById('add-variant-btn').addEventListener('click', function() {
        const container = document.getElementById('variations-container');
        const newCard = document.createElement('div');
        newCard.className = 'variation-card';
        
        const currentCount = variantCount;

        newCard.innerHTML = `
            <span class="remove-var" onclick="deleteCard(this, ${currentCount})">✕</span>
            <div class="form-row">
                <div class="form-group flex-2">
                    <label>Type (Select Multiple)</label>
                    <select name="variants[${currentCount}][type][]" class="type-select" multiple required onchange="toggleFields(this)">
                        <!-- Dynamic Options -->
                    </select>
                </div>
                <div class="form-group flex-1">
                    <label>SKU (Code)</label>
                    <input type="text" name="variants[${currentCount}][sku]" placeholder="SKU" required>
                </div>
            </div>
            
            <div class="dynamic-fields form-row" style="flex-wrap: wrap; margin-top: 15px;"></div>
            
            <div class="form-row" style="margin-top: 15px;">
                <div class="form-group flex-1">
                    <label>Price</label>
                    <input type="number" name="variants[${currentCount}][price]" step="0.01" placeholder="0.00" required>
                </div>
                <div class="form-group flex-1">
                    <label>Stock</label>
                    <input type="number" name="variants[${currentCount}][stock]" placeholder="0" required>
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 0; margin-top: 15px;">
                <label>Variation Image</label>
                <input type="file" name="variants[${currentCount}][image]" accept="image/*">
            </div>
        `;
        container.appendChild(newCard);
        
        const newSelect = newCard.querySelector('.type-select');
        tomSelectInstances[currentCount] = initTomSelect(newSelect);

        updateVariationDropdowns();
        variantCount++;
    });

    function deleteCard(element, index) {
        if (tomSelectInstances[index]) {
            tomSelectInstances[index].destroy();
            delete tomSelectInstances[index];
        }
        element.parentElement.remove();
    }
</script>
@endsection