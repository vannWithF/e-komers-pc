<style>
    .nav-custom {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        position: sticky;
        top: 0;
        z-index: 50;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        height: 70px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-left, .nav-right {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .logo {
        font-size: 1.5rem;
        font-weight: 800;
        color: #4f46e5;
        text-decoration: none;
        letter-spacing: -1px;
    }

    .nav-link {
        text-decoration: none;
        color: #4b5563;
        font-size: 0.95rem;
        font-weight: 500;
        transition: color 0.2s;
    }

    .nav-link:hover, .nav-link.active {
        color: #4f46e5;
    }

    .cart-badge-container {
        position: relative;
    }

    .cart-count {
        position: absolute;
        top: -8px;
        right: -10px;
        background: #ef4444;
        color: white;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 50px;
        font-weight: bold;
    }

    /* Dropdown Simple */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #fff;
        min-width: 160px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 8px 0;
        z-index: 100;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown-item {
        color: #374151;
        padding: 10px 16px;
        text-decoration: none;
        display: block;
        font-size: 0.9rem;
    }

    .dropdown-item:hover {
        background-color: #f9fafb;
        color: #4f46e5;
    }

    .btn-login {
        background: #4f46e5;
        color: white !important;
        padding: 8px 20px;
        border-radius: 8px;
    }

    @media (max-width: 768px) {
        .hidden-mobile { display: none; }
    }
</style>

<nav class="nav-custom">
    <div class="nav-container">
        <div class="nav-left">
            <a href="{{ route('shop.index') }}" class="logo">
                STORE<span style="color: #111;">KIT</span>
            </a>
            
            <div class="hidden-mobile" style="display:flex; gap: 20px; margin-left: 20px;">
                <a href="{{ route('shop.index') }}" class="nav-link {{ request()->routeIs('shop.index') ? 'active' : '' }}">Shop</a>
                <a href="{{ route('shop.setups') }}" class="nav-link {{ request()->routeIs('shop.setups') ? 'active' : '' }}">Setups</a>
            </div>
        </div>

        <div class="nav-right">
            
            @auth
                <a href="{{ route('cart.index') }}" class="nav-link cart-badge-container">
                    <span>🛒</span>
                    <span class="hidden-mobile">Keranjang</span>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="cart-count">{{ count(session('cart')) }}</span>
                    @endif
                </a>

                <div class="dropdown">
                    <a href="#" class="nav-link" style="display:flex; align-items:center; gap:5px;">
                        👤 {{ Auth::user()->name }} ▾
                    </a>
                    <div class="dropdown-content">
                        @if(Auth::user()->isAdmin) {{-- Sesuaikan dengan logic isAdmin kamu --}}
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item" style="font-weight: bold; color: #4f46e5;">Admin Panel</a>
                            <hr style="border:0; border-top:1px solid #eee; margin: 5px 0;">
                        @endif
                        
                        <a href="{{ route('user.orders.index') }}" class="dropdown-item">Pesanan Saya</a>
        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item" style="width:100%; text-align:left; border:none; background:none; cursor:pointer;">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('cart.index') }}" class="nav-link">🛒</a>
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <a href="{{ route('register') }}" class="nav-link btn-login">Daftar</a>
            @endauth
        </div>
    </div>
</nav>