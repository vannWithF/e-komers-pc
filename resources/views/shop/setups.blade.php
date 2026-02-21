@extends('layouts.app')

@section('content')

<style>
    .setups-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-header h2 {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 10px;
    }

    .section-header p {
        color: #718096;
        font-size: 1.1rem;
    }

    /* Setup Card Styling */
    .setup-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #eef2f7;
        box-shadow: 0 10px 25px rgba(0,0,0,0.03);
        margin-bottom: 30px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
    }

    .setup-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px rgba(0,0,0,0.06);
    }

    .setup-content {
        padding: 30px;
    }

    .setup-badge {
        display: inline-block;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .setup-card h3 {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1a202c;
        margin: 0 0 15px 0;
    }

    .setup-description {
        color: #4a5568;
        line-height: 1.6;
        font-size: 1rem;
        margin-bottom: 25px;
        border-left: 4px solid #e2e8f0;
        padding-left: 20px;
    }

    /* Action Section */
    .setup-footer {
        background-color: #f8fafc;
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-buy-setup {
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-buy-setup:hover {
        background: linear-gradient(135deg, #4338ca, #3730a3);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    }

    .setup-info-text {
        font-size: 0.85rem;
        color: #718096;
    }

    @media (max-width: 640px) {
        .setup-footer {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        .btn-buy-setup { width: 100%; justify-content: center; }
    }
</style>

<div class="setups-container">
    <div class="section-header">
        <h2>Rekomendasi Setup</h2>
        <p>Inspirasi rakitan terbaik yang dikurasi khusus untuk kebutuhanmu.</p>
    </div>

    @foreach($setups as $setup)
        <div class="setup-card">
            <div class="setup-content">
                <span class="setup-badge">Verified Build</span>
                <h3>{{ $setup->name }}</h3>
                <p class="setup-description">
                    {{ $setup->description }}
                </p>
                
                <div style="font-size: 0.9rem; color: #64748b;">
                    <strong>Item dalam paket:</strong> 
                    <span style="font-style: italic;">Komponen yang dipilih oleh pakar kami.</span>
                </div>
            </div>

            <div class="setup-footer">
                <span class="setup-info-text">
                    ⭐ Harga paket otomatis menyesuaikan stok terbaru
                </span>
                
                <form action="{{ route('cart.setup.add', $setup->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-buy-setup">
                        🛒 Masukkan Semua ke Keranjang
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>

@endsection