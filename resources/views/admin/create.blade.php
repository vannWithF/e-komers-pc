@extends('layouts.admin')

@section('content')

<style>
    .admin-container {
        max-width: 600px; /* Dibuat lebih ramping untuk form tunggal */
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .card {
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid #e5e7eb;
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .form-header h1 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .btn-back {
        text-decoration: none;
        font-size: 0.85rem;
        color: #6b7280;
        transition: color 0.2s;
    }

    .btn-back:hover {
        color: #111827;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    /* Input & Select Styling */
    input[type="text"],
    select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #1f2937;
        background-color: #fff;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    input[type="text"]:focus,
    select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Button Styling */
    .btn-save {
        background-color: #3b82f6;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        width: 100%;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        margin-top: 10px;
    }

    .btn-save:hover {
        background-color: #2563eb;
    }

    .btn-save:active {
        transform: scale(0.98);
    }

    /* Help Text (Opsional) */
    .help-text {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 4px;
    }
</style>

<div class="admin-container">
    <div class="card">
        <div class="form-header">
            <h1>Create Category</h1>
            <a href="{{ route('categories.index') }}" class="btn-back">
                &larr; Back to List
            </a>
        </div>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" id="name" name="name" placeholder="Enter category name" required autofocus>
                <p class="help-text">Gunakan nama yang unik dan deskriptif.</p>
            </div>

            <div class="form-group">
                <label for="type">Category Type</label>
                <select id="type" name="type" required>
                    <option value="" disabled selected>Select a type...</option>
                    <option value="component">Component</option>
                    <option value="peripheral">Peripheral</option>
                    <option value="furniture">Furniture</option>
                </select>
            </div>

            <button type="submit" class="btn-save">
                Save Category
            </button>
        </form>
    </div>
</div>

@endsection