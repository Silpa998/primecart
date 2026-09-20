@extends('layouts.sidebar')

@section('content')
<style>
    /* Container Styles */
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

    /* Form Header with Back Button Flexbox */
    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
    }

    .form-header-text h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.025em;
    }

    .form-header-text p {
        color: #64748b;
        font-size: 0.875rem;
        margin-top: 4px;
        margin-bottom: 0;
    }

    /* Back Button Style */
    .btn-back {
        background-color: #f1f5f9;
        color: #475569;
        padding: 8px 14px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 700;
        transition: all 0.2s;
        border: 1px solid #e2e8f0;
    }

    .btn-back:hover {
        background-color: #cbd5e1;
        color: #1e293b;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 700;
        color: #334155;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    input, select, textarea {
        width: 100%;
        padding: 12px;
        box-sizing: border-box;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s;
        background-color: #f8fafc;
        font-family: inherit;
    }

    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #4EA685;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(78, 166, 133, 0.1);
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    /* Variation Checkbox Styles */
    .variation-wrapper {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        background: #f8fafc;
        padding: 15px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
    }

    .variation-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 500;
        color: #334155;
        cursor: pointer;
        text-transform: none;
        letter-spacing: 0;
        margin-bottom: 0;
    }

    .variation-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #4EA685;
    }

    /* Save Button Styles */
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
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(78, 166, 133, 0.2);
    }

    .btn-save:hover {
        background-color: #059669;
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(78, 166, 133, 0.3);
    }

    .btn-save:active {
        transform: scale(0.98);
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 10px;
        background-color: #fee2e2;
        color: #991b1b;
        font-size: 0.875rem;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <div class="form-header-text">
            <h2>Edit Category</h2>
            <p>Modify the details for <strong>{{ $category->category_name }}</strong></p>
        </div>
        <a href="{{ route('categories.index') }}" class="btn-back">← Back</a>
    </div>

    <form action="{{ route('categories.update', $category->id) }}" method="post">     
        @csrf
        @method('PUT')
        
        @if ($errors->any())
            <div class="alert">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="categoryName">Category Name</label>
            <input type="text" id="categoryName" name="category_name" 
                   value="{{ old('category_name', $category->category_name) }}" 
                   placeholder="e.g. Summer Collection" required>
        </div>

        <div class="form-group">
            <label for="slug">URL Slug</label>
            <input type="text" id="slug" name="slug" 
                   value="{{ old('slug', $category->slug) }}" 
                   placeholder="e.g. summer-collection">
        </div>

        <div class="form-group">
            <label class="main-label">Available Variations</label>
            <div class="variation-wrapper">
                @if($all_variations->isEmpty())
                    <p style="font-size: 12px; color: #ef4444; grid-column: span 2;">
                        No variations found in database.
                    </p>
                @else
                    @foreach($all_variations as $variation)
                        @if($variation && isset($variation->variation_name))
                            <label class="variation-item">
                                <input type="checkbox"
                                       name="available_variations[]"
                                       value="{{ $variation->id }}"
                                       {{ (is_array(old('available_variations', $category->available_variations)) && in_array($variation->id, old('available_variations', $category->available_variations))) ? 'checked' : '' }}>                                
                                {{ $variation->variation_name }}
                            </label>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description (Optional)</label>
            <textarea id="description" name="description" 
                      placeholder="Briefly describe what belongs in this category...">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            <p style="color: #64748b; font-size: 0.75rem; margin-top: 4px;">Active categories are visible to customers.</p>
        </div>

        <button type="submit" class="btn-save">
            Update Category
        </button>
    </form>
</div>
@endsection