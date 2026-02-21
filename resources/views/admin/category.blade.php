@extends('layouts.admin')

@section('content')

<style>
    .admin-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* Header & Action */
    .header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .header-bar h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    .btn-create {
        background-color: #3b82f6;
        color: white;
        text-decoration: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: background 0.2s;
    }

    .btn-create:hover {
        background-color: #2563eb;
    }

    /* Alert Success */
    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #bbf7d0;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Table Styling */
    .table-wrapper {
        background: white;
        border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background-color: #f9fafb;
        padding: 12px 20px;
        text-align: left;
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #6b7280;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e5e7eb;
    }

    td {
        padding: 15px 20px;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
        font-size: 0.95rem;
    }

    tr:last-child td {
        border-bottom: none;
    }

    /* Badge Type */
    .type-badge {
        background: #f3f4f6;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.8rem;
        color: #4b5563;
    }

    /* Action Buttons */
    .action-cell {
        display: flex;
        gap: 8px;
    }

    .btn-edit {
        background-color: #fef9c3;
        color: #854d0e;
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: background 0.2s;
    }

    .btn-edit:hover {
        background-color: #fde047;
    }

    .btn-delete {
        background-color: #fee2e2;
        color: #991b1b;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-delete:hover {
        background-color: #fecaca;
    }
</style>

<div class="admin-container">
    <div class="header-bar">
        <h1>Categories</h1>
        <a href="{{ route('categories.create') }}" class="btn-create">
            + Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td style="font-weight: 600;">{{ $category->name }}</td>
                    <td>
                        <span class="type-badge">{{ $category->type }}</span>
                    </td>
                    <td>
                        <div class="action-cell">
                            <a href="{{ route('categories.edit', $category) }}" class="btn-edit">
                                Edit
                            </a>

                            <form action="{{ route('categories.destroy', $category) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection