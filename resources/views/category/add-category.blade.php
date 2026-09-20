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

    .form-header {
        margin-bottom: 25px;
    }

    .form-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.025em;
    }

    .form-header p {
        color: #64748b;
        font-size: 0.875rem;
        margin-top: 4px;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 20px;
    }

    label.main-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 700;
        color: #334155;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    input[type="text"], 
    select, 
    textarea {
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

    input:focus, textarea:focus {
        outline: none;
        border-color: #4EA685;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(78, 166, 133, 0.1);
    }

    /* Variation Checkbox Styles */
    .variation-wrapper {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* രണ്ട് കോളമായി തിരിച്ചു */
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
    }

    .variation-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #4EA685;
    }

    /* Button Styles */
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
        box-shadow: 0 4px 6px -1px rgba(78, 166, 133, 0.2);
    }

    .btn-save:hover {
        background-color: #059669;
        transform: translateY(-1px);
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
        <h2>Add New Category</h2>
        <p>Organize your products by creating a new category.</p>
    </div>

    <form action="{{ route('categories.store') }}" method="post">
        @csrf

        @if ($errors->any())
            <div class="alert">
                <ul style="margin: 0; padding-left: 15px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label class="main-label" for="categoryName">Category Name</label>
            <input type="text" id="categoryName" name="category_name" placeholder="e.g. Summer Collection" value="{{ old('category_name') }}" required>
        </div>

        <div class="form-group">
            <label class="main-label" for="slug">URL Slug</label>
            <input type="text" id="slug" name="slug" placeholder="e.g. summer-collection" value="{{ old('slug') }}">
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
            @if($variation && isset($variation->id))
                <label class="variation-item">
                    <input type="checkbox" 
                           name="available_variations[]" 
                           value="{{ $variation->id }}" 
                           {{ is_array(old('available_variations')) && in_array($variation->id, old('available_variations')) ? 'checked' : '' }}>
                    {{ $variation->variation_name }}
                </label>
            @endif
        @endforeach
    @endif
</div>
</div>

        <div class="form-group">
            <label class="main-label" for="description">Description (Optional)</label>
            <textarea id="description" name="description" placeholder="Briefly describe what belongs in this category...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label class="main-label" for="status">Status</label>
            <select id="status" name="status">
                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            <p style="color: #64748b; font-size: 0.75rem; margin-top: 4px;">Active categories are visible to customers.</p>
        </div>

        <button type="submit" class="btn-save">
            Create Category
        </button>
    </form>
</div>
@endsection