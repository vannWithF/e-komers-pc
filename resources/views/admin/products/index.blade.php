@extends('layouts.app')

@section('content')

<style>
    .container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    h1 {
        font-size: 1.8rem;
        color: #1a202c;
        margin: 0;
    }

    /* Button Tambah */
    .btn-add {
        background-color: #4A90E2;
        color: white;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: background 0.3s;
        box-shadow: 0 4px 6px rgba(74, 144, 226, 0.2);
    }

    .btn-add:hover {
        background-color: #357ABD;
    }

    /* Table Design */
    .table-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        border: 1px solid #edf2f7;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    thead {
        background-color: #f7fafc;
    }

    th {
        padding: 18px 20px;
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #718096;
        font-weight: 700;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #edf2f7;
    }

    td {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f7;
        color: #4a5568;
        font-size: 0.95rem;
        vertical-align: middle;
    }

    /* Hover effect */
    tr:hover td {
        background-color: #f8fafc;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #a0aec0;
        font-style: italic;
    }

    /* Badge Stok */
    .stok-badge {
        background: #e2e8f0;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* Tombol Aksi */
    .btn-edit {
        color: #4A90E2;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: color 0.2s;
    }

    .btn-edit:hover {
        color: #2c5282;
        text-decoration: underline;
    }

    @media (max-width: 600px) {
        .header-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }
    }
</style>

<div class="container">
    <div class="header-section">
        <h1>Daftar Produk</h1>
        <a href="{{ route('admin.products.create') }}" class="btn-add">
            + Tambah Produk
        </a>
    </div>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th style="text-align: center;">Stock</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td style="font-weight: 600; color: #2d3748;">{{ $product->name }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td style="text-align: center;">
                            <span class="stok-badge">{{ $product->stock }}</span>
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            Belum ada produk tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection