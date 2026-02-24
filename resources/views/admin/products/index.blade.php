@extends('layouts.admin') {{-- Otomatis menggunakan Sidebar Floating yang kita buat tadi --}}

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-orange: #e85a24;
        --glass-bg: rgba(255, 255, 255, 0.3);
        --glass-border: rgba(255, 255, 255, 0.5);
        --text-main: #2d1a12;
    }

    .page-container {
        animation: liquidEntrance 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    /* HEADER: Clean & Minimalist */
    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
    }

    .title-group h1 {
        font-size: 2.2rem;
        font-weight: 900;
        letter-spacing: -1.5px;
        color: var(--text-main);
    }

    /* Floating Add Button */
    .btn-add-liquid {
        background: linear-gradient(135deg, var(--titanium-orange), var(--deep-orange));
        color: white;
        text-decoration: none;
        padding: 14px 28px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 25px rgba(232, 90, 36, 0.25);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .btn-add-liquid:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 30px rgba(232, 90, 36, 0.35);
    }

    /* LIST STRUCTURE: Horizontal Tiles */
    .product-list-wrapper {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .product-tile {
        background: var(--glass-bg);
        backdrop-filter: blur(25px) saturate(180%);
        -webkit-backdrop-filter: blur(25px) saturate(180%);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        padding: 20px 35px;
        display: grid;
        grid-template-columns: 3fr 1.5fr 1fr 1fr;
        align-items: center;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .product-tile:hover {
        background: rgba(255, 255, 255, 0.45);
        transform: translateX(12px);
        border-color: var(--titanium-orange);
    }

    /* Content Styling */
    .prod-info h3 {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .prod-price {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 900;
        color: var(--deep-orange);
        font-size: 1.1rem;
    }

    .stock-counter {
        background: white;
        padding: 8px 16px;
        border-radius: 15px;
        font-weight: 800;
        font-size: 0.85rem;
        width: fit-content;
        border: 1px solid var(--glass-border);
    }

    /* Action Buttons Inside Tile */
    .tile-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-edit-tile {
        background: var(--text-main);
        color: white;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 14px;
        font-size: 0.8rem;
        font-weight: 700;
        transition: 0.3s;
    }

    .btn-edit-tile:hover {
        background: var(--titanium-orange);
        transform: scale(1.05);
    }

    /* Empty State Glass */
    .glass-empty {
        text-align: center;
        padding: 80px;
        background: var(--glass-bg);
        border-radius: 40px;
        border: 1px dashed var(--titanium-orange);
        color: var(--text-muted);
        font-weight: 700;
    }

    @keyframes liquidEntrance {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive */
    @media (max-width: 900px) {
        .product-tile {
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .tile-actions { grid-column: span 2; }
    }
</style>

<div class="page-container">
    <div class="header-flex">
        <div class="title-group">
            <h1>Hardware Inventory</h1>
            <p style="font-weight: 600; color: var(--deep-orange); opacity: 0.7;">Total unit tersedia: {{ $products->count() }} Item</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-add-liquid">
            <span style="font-size: 1.2rem;">+</span> New Product
        </a>
    </div>

    <div class="product-list-wrapper">
        @forelse ($products as $product)
            <div class="product-tile">
                <div class="prod-info">
                    <span style="font-size: 0.65rem; font-weight: 800; color: var(--deep-orange); letter-spacing: 1.5px; text-transform: uppercase;">Product Name</span>
                    <h3>{{ $product->name }}</h3>
                </div>

                <div class="prod-price">
                    <span style="display: block; font-size: 0.65rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Valuation</span>
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>

                <div>
                    <span style="display: block; font-size: 0.65rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Stock Level</span>
                    <div class="stock-counter">
                        {{ $product->stock }} <span style="font-weight: 400; font-size: 0.7rem;">Units</span>
                    </div>
                </div>

                <div class="tile-actions">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit-tile">
                        Modify
                    </a>
                </div>
            </div>
        @empty
            <div class="glass-empty">
                <div style="font-size: 3rem; margin-bottom: 20px;">📦</div>
                <p>Belum ada aset hardware yang terdaftar dalam sistem.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection