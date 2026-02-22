<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --primary: #4f46e5;
        --primary-light: #eef2ff;
        --admin-red: #ef4444;
        --admin-bg: #fef2f2;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --nav-height: 75px;
        --glass: rgba(255, 255, 255, 0.9);
    }

    /* 1. Reset & Layout Nav */
    .nav-custom {
        background: var(--glass);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid #e2e8f0;
        position: sticky;
        top: 0;
        z-index: 1000;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        height: var(--nav-height);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-left, .nav-right {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    /* 2. Brand & Menu */
    .logo {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
        text-decoration: none;
        letter-spacing: -1px;
    }
    .logo span { color: #0f172a; }

    .nav-links-wrapper {
        display: flex;
        align-items: center;
        gap: 20px;
        border-left: 1px solid #e2e8f0;
        padding-left: 20px;
    }

    .nav-link {
        text-decoration: none;
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 600;
        transition: 0.3s;
    }
    .nav-link:hover, .nav-link.active { color: var(--primary); }

    /* 3. Admin Button (Pill Style) */
    .btn-admin-pill {
        background: var(--admin-bg);
        color: var(--admin-red) !important;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid #ffe4e6;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }
    .btn-admin-pill:hover {
        background: var(--admin-red);
        color: #ffffff !important;
        box-shadow: 0 8px 15px rgba(239, 68, 68, 0.2);
    }

    /* 4. Cart Icon */
    .icon-link {
        color: var(--text-main);
        text-decoration: none;
        position: relative;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
    }
    .cart-count {
        position: absolute;
        top: -10px;
        right: -12px;
        background: var(--admin-red);
        color: white;
        font-size: 0.65rem;
        padding: 2px 6px;
        border-radius: 50px;
        border: 2px solid #fff;
        font-weight: 800;
    }

    /* 5. Dropdown Logic (Fixed Hover) */
    .dropdown {
        position: relative;
        padding: 10px 0; /* Memberikan area hover tambahan */
        margin-top: -10px;
        margin-bottom: -10px;
    }

    .dropdown-trigger {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        background: #f1f5f9;
        padding: 10px 18px;
        border-radius: 50px;
        border: 1px solid transparent;
        transition: 0.3s;
    }
    .dropdown-trigger:hover {
        background: #ffffff;
        border-color: var(--primary);
    }

    .dropdown-content {
        display: block;
        position: absolute;
        right: 0;
        top: 100%;
        background: white;
        min-width: 240px;
        border-radius: 18px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        border: 1px solid #e2e8f0;
        padding: 10px;
        margin-top: 5px;

        /* Delay & Animation */
        opacity: 0;
        visibility: hidden;
        transform: translateY(15px);
        transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
        transition-delay: 0.1s; /* Menahan dropdown agar tidak langsung hilang */
    }

    /* Invisible Bridge: Menghubungkan trigger dan menu */
    .dropdown::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        height: 15px;
        background: transparent;
    }

    .dropdown:hover .dropdown-content {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
        transition-delay: 0s;
    }

    .dropdown-item {
        padding: 12px 15px;
        text-decoration: none;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 12px;
        transition: 0.2s;
    }
    .dropdown-item:hover {
        background: var(--primary-light);
        color: var(--primary);
    }

    .dropdown-admin {
        background: #f5f3ff;
        color: var(--primary);
        margin-bottom: 8px;
    }

    /* 6. Auth & Misc */
    .btn-signup {
        background: var(--primary);
        color: #fff !important;
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }

    @media (max-width: 768px) {
        .hidden-mobile { display: none; }
    }
</style>

<nav class="nav-custom">
    <div class="nav-container">
        <div class="nav-left">
            <a href="{{ route('shop.index') }}" class="logo">STORE<span>KIT</span></a>
            
            <div class="nav-links-wrapper hidden-mobile">
                <a href="{{ route('shop.index') }}" class="nav-link {{ request()->routeIs('shop.index') ? 'active' : '' }}">Shop</a>
                <a href="{{ route('shop.setups') }}" class="nav-link {{ request()->routeIs('shop.setups') ? 'active' : '' }}">Setups</a>
                
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-admin-pill">
                            🛠 Panel Admin
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <div class="nav-right">
            @auth
                <a href="{{ route('cart.index') }}" class="icon-link">
                    🛒
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="cart-count">{{ count(session('cart')) }}</span>
                    @endif
                </a>

                <div class="dropdown">
                    <div class="dropdown-trigger">
                        <span style="font-size: 0.85rem; font-weight: 800; color: var(--text-main);">
                            {{ Auth::user()->name }}
                        </span>
                        <span style="font-size: 0.5rem; color: var(--text-muted);">▼</span>
                    </div>
                    
                    <div class="dropdown-content">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item dropdown-admin">
                                🚀 Ke Dashboard Admin
                            </a>
                        @endif
                        
                        <a href="{{ route('user.orders.index') }}" class="dropdown-item">📦 Pesanan Saya</a>

                        
                        <div style="height: 1px; background: #f1f5f9; margin: 8px 0;"></div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item" style="width: 100%; border: none; background: none; text-align: left; cursor: pointer; color: var(--admin-red);">
                                🚪 Keluar Akun
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                <a href="{{ route('register') }}" class="nav-link btn-signup">Daftar</a>
            @endauth
        </div>
    </div>
</nav>