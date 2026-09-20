@extends('layouts.sidebar')

@section('title', 'Variations List')

@section('content')
<style>
    .index-container {
        max-width: 1000px;
        margin: 40px auto;
        font-family: 'Inter', sans-serif;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .page-header h2 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .btn-add {
        background-color: #4EA685;
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(78, 166, 133, 0.2);
    }
    .btn-add:hover {
        background-color: #059669;
        transform: translateY(-1px);
    }
    .table-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    th {
        background-color: #f8fafc;
        padding: 15px 20px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        font-weight: 700;
        border-bottom: 1px solid #f1f5f9;
    }
    td {
        padding: 18px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #334155;
    }
    tr:last-child td {
        border-bottom: none;
    }
    .badge {
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-transform: capitalize;
    }
    .badge-active {
        background-color: #ecfdf5;
        color: #059669;
    }
    .badge-inactive {
        background-color: #fef2f2;
        color: #dc2626;
    }
    .action-btns {
        display: flex;
        gap: 10px;
    }
    .btn-edit {
        color: #4EA685;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
    }
    .btn-delete {
        color: #ef4444;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
    }
    .empty-state {
        padding: 40px;
        text-align: center;
        color: #64748b;
    }
</style>

<div class="index-container">
    @if(session('success'))
        <div style="background-color: #ecfdf5; color: #059669; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; font-size: 14px; border: 1px solid #a7f3d0;">
            {{ session('success') }}
        </div>
    @endif

    <div class="page-header">
        <div>
            <h2>Product Variations</h2>
            <p style="color: #64748b; font-size: 0.875rem; margin-top: 4px;">Manage your product sizes, colors, and more.</p>
        </div>
        <a href="{{ route('variations.create') }}" class="btn-add">+ Add Variation</a>
    </div>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Variation Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($variations as $variation)
                <tr>
                    <td style="font-weight: 600;">{{ $variation->variation_name }}</td>
                    <td style="color: #64748b; font-family: monospace;">{{ $variation->slug }}</td>
                    <td>
                        <span class="badge {{ $variation->status == 'active' ? 'badge-active' : 'badge-inactive' }}">
                            {{ $variation->status }}
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('variations.edit', $variation->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('variations.destroy', $variation->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-state">
                        No variations found. Click "+ Add Variation" to create one.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection