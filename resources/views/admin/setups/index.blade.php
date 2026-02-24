@extends('layouts.admin')

@section('content')
<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-orange: #e85a24;
        --glass-bg: rgba(255, 255, 255, 0.3);
        --glass-border: rgba(255, 255, 255, 0.5);
        --text-main: #2d1a12;
    }

    .setup-index-container {
        animation: liquidReveal 0.8s cubic-bezier(0, 1, 0, 1);
    }

    /* HEADER */
    .index-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 40px;
    }

    .index-header h1 {
        font-size: 2.5rem;
        font-weight: 900;
        letter-spacing: -2px;
        color: var(--text-main);
    }

    .btn-create-setup {
        background: var(--text-main);
        color: white;
        text-decoration: none;
        padding: 14px 25px;
        border-radius: 20px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .btn-create-setup:hover {
        background: var(--titanium-orange);
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(255, 107, 53, 0.3);
    }

    /* GRID SYSTEM: Bento Style */
    .setup-bento-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
    }

    .setup-card {
        background: var(--glass-bg);
        backdrop-filter: blur(25px) saturate(180%);
        -webkit-backdrop-filter: blur(25px) saturate(180%);
        border: 1px solid var(--glass-border);
        border-radius: 40px;
        padding: 30px;
        position: relative;
        transition: 0.5s;
        overflow: hidden;
    }

    .setup-card:hover {
        background: white;
        transform: scale(1.02);
        border-color: var(--titanium-orange);
        box-shadow: 0 30px 60px rgba(0,0,0,0.05);
    }

    /* Content Styling */
    .setup-badge-id {
        font-size: 0.65rem;
        font-weight: 900;
        color: var(--deep-orange);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        display: block;
        margin-bottom: 10px;
    }

    .setup-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 15px;
        line-height: 1.2;
    }

    /* Info Bar (Pills) */
    .setup-meta {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
    }

    .meta-pill {
        background: rgba(255,255,255,0.6);
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        border: 1px solid var(--glass-border);
    }

    .price-display {
        font-size: 1.6rem;
        font-weight: 900;
        color: var(--text-main);
        letter-spacing: -1px;
    }

    /* Floating Actions */
    .setup-actions {
        display: flex;
        gap: 8px;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid rgba(0,0,0,0.05);
    }

    .action-circle {
        width: 45px;
        height: 45px;
        border-radius: 15px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: var(--text-main);
        border: 1px solid var(--glass-border);
        transition: 0.3s;
    }

    .action-circle:hover {
        background: var(--titanium-orange);
        color: white;
        border-color: var(--titanium-orange);
        transform: rotate(-10deg);
    }

    .btn-delete-card {
        background: #fff0f0;
        color: #ff4d4d;
        border: none;
        cursor: pointer;
    }

    .btn-delete-card:hover {
        background: #ff4d4d;
        color: white;
        border-color: #ff4d4d;
    }

    @keyframes liquidReveal {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    .empty-glass {
        grid-column: 1 / -1;
        padding: 100px;
        text-align: center;
        background: var(--glass-bg);
        border-radius: 40px;
        border: 2px dashed var(--glass-border);
    }
</style>

<div class="setup-index-container">
    <div class="index-header">
        <div>
            <h1>Setup Gallery</h1>
            <p style="font-weight: 700; color: var(--deep-orange); opacity: 0.7;">Explore your custom hardware rakitan.</p>
        </div>
        <a href="{{ route('admin.setups.create') }}" class="btn-create-setup">
            <span>+</span> Build New Setup
        </a>
    </div>

    <div class="setup-bento-grid">
        @forelse($setups as $setup)
        <div class="setup-card">
            <span class="setup-badge-id">STP-{{ $setup->id }}</span>
            <h2 class="setup-title">{{ $setup->name }}</h2>
            
            <div class="setup-meta">
                <div class="meta-pill">📦 {{ $setup->products->count() }} Components</div>
                <div class="meta-pill">✨ Premium</div>
            </div>

            <div style="margin-top: auto;">
                <p style="font-size: 0.65rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">Total Valuation</p>
                <div class="price-display">
                    <span style="font-size: 0.9rem; color: var(--titanium-orange);">Rp</span> Rp {{ number_format($setup->price, 0, ',', '.') }}
                </div>
            </div>

            <div class="setup-actions">
                <a href="{{ route('admin.setups.edit', $setup) }}" class="action-circle" title="Edit Setup">
                    ✏️
                </a>
                <form action="{{ route('admin.setups.destroy', $setup) }}" method="POST" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-circle btn-delete-card" onclick="return confirm('Hapus setup ini?')">
                        🗑️
                    </button>
                </form>
            </div>

            @if($setup->image)
    <img src="{{ asset('storage/'.$setup->image) }}" width="120" style="border-radius: 8px;">
@endif
        </div>
        @empty
        <div class="empty-glass">
            <div style="font-size: 3rem; margin-bottom: 20px;">🕹️</div>
            <h3 style="font-weight: 800;">Belum ada setup rakitan.</h3>
            <p style="color: var(--text-muted);">Mulai buat rakitan hardware pertamamu sekarang.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection