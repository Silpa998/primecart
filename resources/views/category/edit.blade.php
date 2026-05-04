@extends('layouts.sidebar')

@section('content')
<style>
    /* Reusing your beautiful styles */
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
        <h2>Edit Category</h2>
        <p>Modify the details for <strong>{{ $category->category_name }}</strong></p>
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
            <label for="description">Description (Optional)</label>
            <textarea id="description" name="description" 
                      placeholder="Briefly describe what belongs in this category...">{{ old('description', $category->description) }}</textarea>
        </div>

        <button type="submit" class="btn-save">
            Update Category
        </button>
    </form>
</div>
@endsection