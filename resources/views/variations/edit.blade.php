@extends('layouts.sidebar')

@section('title', 'Edit Variation')

@section('content')
<style>
    .form-container {
        max-width: 600px;
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
        display: flex;
        justify-content: space-between;
        align-items: center;
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
    select, input {
        width: 100%;
        padding: 12px;
        box-sizing: border-box;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s;
        background-color: #f8fafc;
        font-family: inherit;
        appearance: none;
    }
    select:focus, input:focus {
        outline: none;
        border-color: #4EA685;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(78, 166, 133, 0.1);
    }
    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 25px;
    }
    .btn-save {
        flex: 2;
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
    .btn-cancel {
        flex: 1;
        background-color: #f1f5f9;
        color: #64748b;
        padding: 14px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-save:hover {
        background-color: #059669;
        transform: translateY(-1px);
    }
    .btn-cancel:hover {
        background-color: #e2e8f0;
        color: #334155;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <div>
            <h2>Edit Variation</h2>
            <p>Modify your product variation details.</p>
        </div>
        <a href="{{ route('variations.index') }}" style="color: #64748b; text-decoration: none; font-size: 13px; font-weight: 600;">
            ← Back
        </a>
    </div>

    @if ($errors->any())
        <div style="background-color: #fef2f2; color: #dc2626; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('variations.update', $variation->id) }}" method="POST">
        @csrf
        @method('PUT') 

        <div class="form-group">
            <label for="variation_name">Variation Name</label>
            <input type="text" name="variation_name" id="variation_name"
                   value="{{ old('variation_name', $variation->variation_name) }}" required>
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" name="slug" id="slug"
                   value="{{ $variation->slug }}" readonly
                   style="background:#f1f5f9; color:#94a3b8; cursor:not-allowed;">
        </div>
        
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="active" {{ old('status', $variation->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $variation->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="btn-group">
            <a href="{{ route('variations.index') }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-save">Update Variation</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('variation_name').addEventListener('input', function () {
        document.getElementById('slug').value = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-');
    });
</script>
@endsection