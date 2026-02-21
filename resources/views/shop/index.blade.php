@extends('layouts.app')

@section('content')

<style>
    .shop-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .hero-section {
        text-align: center;
        margin-bottom: 50px;
    }

    .hero-section h1 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 10px;
    }

    .hero-section p {
        color: #718096;
        font-size: 1.1rem;
    }

    /* Category Navigation */
    .category-nav {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }

    .category-pill {
        text-decoration: none;
        padding: 10px 20px;
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #4a5568;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .category-pill:hover, .category-pill.active {
        background: #4f46e5;
        color: white;
        border-color: #4f46e5;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 30px;
    }

    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #f0f0f0;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .product-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background-color: #f7fafc;
    }

    .product-info {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-info h4 {
        margin: 0 0 10px 0;
        font-size: 1.15rem;
        color: #1a202c;
        font-weight: 700;
        line-height: 1.4;
    }

    .product-price {
        font-size: 1.25rem;
        color: #4f46e5;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .btn-detail {
        text-decoration: none;
        text-align: center;
        padding: 12px;
        background: #f8fafc;
        color: #4f46e5;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.2s;
        border: 1px solid #e2e8f0;
        margin-top: auto;
    }

    .btn-detail:hover {
        background: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }

    /* Pagination */
    .pagination-container {
        margin-top: 50px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 640px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .hero-section h1 { font-size: 1.8rem; }
    }
</style>

<div class="shop-container">
    <div class="hero-section">
        <h1>Affan Store</h1>
        <p>Temukan perangkat komputer terbaik untuk setup impianmu.</p>
    </div>

    <div class="category-nav">
        <a href="{{ route('shop.index') }}" class="category-pill {{ !request('category') ? 'active' : '' }}">Semua Produk</a>
        @foreach($categories as $category)
            <a href="{{ route('shop.category', $category->slug) }}" 
               class="category-pill {{ request()->is('category/'.$category->slug) ? 'active' : '' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <div class="product-grid">
        @foreach($products as $product)
            <div class="product-card">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="product-image" alt="{{ $product->name }}">
                @else
                    <div class="product-image" style="display:flex; align-items:center; justify-content:center; color:#cbd5e0;">
                        No Image
                    </div>
                @endif

                <div class="product-info">
                    <h4>{{ $product->name }}</h4>
                    <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                    <a href="{{ route('shop.show', $product->slug) }}" class="btn-detail">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination-container">
        {{ $products->links() }}
    </div>
</div>

@endsection