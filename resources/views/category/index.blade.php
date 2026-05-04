@extends('layouts.sidebar')

@section('content')
<style>
    .index-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 30px;
        background-color: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 20px;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }
    .index-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    .index-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
    }
    .btn-create {
        background-color: #4EA685;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    .btn-create:hover {
        background-color: #059669;
        transform: translateY(-1px);
    }
    .category-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .category-table th {
        text-align: left;
        padding: 12px 15px;
        background-color: #f8fafc;
        color: #64748b;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e2e8f0;
    }
    .category-table td {
        padding: 15px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.9rem;
    }
    .category-table tr:hover {
        background-color: #fcfdfe;
    }
    .badge-slug {
        background: #e2e8f0;
        color: #475569;
        padding: 4px 8px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 0.8rem;
    }
    .action-links {
        display: flex;
        gap: 10px;
    }
    .edit-link { color: #4EA685; text-decoration: none; font-weight: 600; }
    .delete-link { color: #ef4444; text-decoration: none; font-weight: 600; }
</style>

<div class="index-container">
    <div class="index-header">
        <div>
            <h2>Categories</h2>
            <p style="color: #64748b; font-size: 0.875rem; margin-top: 4px;">Manage your store's product groupings.</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn-create">+ New Category</a>
        
    </div>

    @if(session('success'))
        <div style="padding: 12px; background: #dcfce7; color: #166534; border-radius: 10px; margin-bottom: 20px; font-size: 0.875rem;">
            {{ session('success') }}
        </div>
    @endif

    <table class="category-table">
        <thead>
            <tr>
                {{-- <th>ID</th> --}}
                <th>Category Name</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    {{-- <td>#{{ $category->id }}</td> --}}
                    <td style="font-weight: 700;">{{ $category->category_name }}</td>
                    <td><span class="badge-slug">{{ $category->slug }}</span></td>
                    <td style="color: #64748b;">{{ Str::limit($category->description, 50) }}</td>
                    <td class="action-links">
                        <a href="{{ route('categories.edit', $category->id) }}" class="edit-link">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id)}}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="delete-link" style="background:none; border:none; cursor:pointer; padding:0; font-family:inherit;">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                        No categories found. Start by adding one!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection