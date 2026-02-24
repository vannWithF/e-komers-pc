<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        /* Titanium Orange iPhone 17 Pro Max Palette */
        --titanium-orange: #ff6b35;
        --deep-titanium: #e85a24;
        --glass-bg: rgba(255, 255, 255, 0.45);
        --glass-border: rgba(255, 255, 255, 0.6);
        --mac-dark: #1d1d1f;
        --blur-val: 20px;
    }

    /* 1. The Liquid Body - Floating Navbar */
    .nav-custom {
        position: fixed;
        top: 25px;
        left: 50%;
        transform: translateX(-50%);
        width: 92%;
        max-width: 1200px;
        height: 65px;
        background: var(--glass-bg);
        backdrop-filter: blur(var(--blur-val)) saturate(200%) brightness(105%);
        -webkit-backdrop-filter: blur(var(--blur-val)) saturate(200%) brightness(105%);
        border: 1.5px solid var(--glass-border);
        border-radius: 28px;
        z-index: 9999;
        font-family: 'Plus Jakarta Sans', sans-serif;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .nav-container {
        height: 100%;
        padding: 0 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* 2. Brand Identity - Titanium Gradient Logo */
    .logo {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--mac-dark);
        text-decoration: none;
        letter-spacing: -1px;
        display: flex;
        align-items: center;
    }
    .logo span { 
        background: linear-gradient(135deg, var(--titanium-orange), var(--deep-titanium));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-left: 2px;
    }

    /* 3. Navigation Links */
    .nav-menu {
        display: flex;
        gap: 35px;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }

    .nav-link {
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--mac-dark);
        opacity: 0.5;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    
    .nav-link:hover { opacity: 1; color: var(--titanium-orange); }
    
    .nav-link.active { 
        opacity: 1; 
        color: var(--deep-titanium); 
    }
    
    /* Indikator Titik ala Apple */
    .nav-link.active::after {
        content: "";
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 4px;
        background: var(--titanium-orange);
        border-radius: 50%;
    }

    /* 4. Action Buttons */
    .nav-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .cart-btn {
        text-decoration: none;
        font-size: 1.2rem;
        position: relative;
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .cart-btn:hover { transform: translateY(-2px) scale(1.1); }

    /* User Profile Dropdown */
    .user-dropdown {
        position: relative;
        padding: 6px 16px;
        background: rgba(255, 255, 255, 0.6);
        border: 1px solid var(--glass-border);
        border-radius: 18px;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .user-dropdown:hover { background: white; box-shadow: 0 8px 20px rgba(255, 107, 53, 0.15); }

    .dropdown-menu {
        position: absolute;
        top: calc(100% + 15px);
        right: 0;
        width: 220px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(30px);
        border-radius: 24px;
        border: 1px solid var(--glass-border);
        padding: 10px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        opacity: 0;
        visibility: hidden;
        transform: translateY(15px);
        transition: 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .user-dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .menu-item {
        padding: 12px 15px;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--mac-dark);
        text-decoration: none;
        display: flex;
        align-items: center;
        border-radius: 15px;
        transition: 0.2s;
    }
    .menu-item:hover { background: var(--titanium-orange); color: white; }

    /* Auth Buttons - Titanium Theme */
    .btn-signup {
        background: linear-gradient(135deg, var(--titanium-orange), var(--deep-titanium));
        color: white !important;
        padding: 10px 22px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 800;
        box-shadow: 0 8px 15px rgba(232, 90, 36, 0.2);
        transition: 0.4s;
    }
    .btn-signup:hover { transform: translateY(-2px); box-shadow: 0 12px 20px rgba(232, 90, 36, 0.3); }

    @media (max-width: 850px) {
        .nav-menu { display: none; }
        .nav-custom { width: 95%; top: 15px; }
    }
</style>

<nav class="nav-custom">
    <div class="nav-container">
        <a href="{{ route('shop.index') }}" class="logo">
            Warunk <span>PC-Station.</span>
        </a>

        <div class="nav-menu">
            <a href="{{ route('shop.index') }}" class="nav-link {{ request()->routeIs('shop.index') ? 'active' : '' }}">Shop</a>
            <a href="{{ route('shop.setups') }}" class="nav-link {{ request()->routeIs('shop.setups') ? 'active' : '' }}">Setups</a>
        </div>

        <div class="nav-right">
            @auth
                <a href="{{ route('cart.index') }}" class="cart-btn" title="Your Basket">🛒</a>
                
                <div class="user-dropdown">
                    <div style="width: 8px; height: 8px; background: #4ade80; border-radius: 50%;"></div>
                    <span style="font-size: 0.82rem; font-weight: 800; color: var(--mac-dark);">{{ Auth::user()->name }}</span>
                    
                    <div class="dropdown-menu">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="menu-item" style="color: var(--deep-titanium);">
                                🛠️ Admin Panel
                            </a>
                        @endif
                        <a href="{{ route('user.orders.index') }}" class="menu-item">📦 My Orders</a>
                        <a href="{{ route('profile.edit') }}" class="menu-item">⚙️ Settings</a>
                        
                        <div style="height: 1px; background: rgba(0,0,0,0.06); margin: 8px 5px;"></div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="menu-item" style="width: 100%; border: none; background: none; color: #ff3b30; cursor: pointer;">
                                🚪 Log Out
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <a href="{{ route('register') }}" class="nav-link btn-signup">Sign Up</a>
            @endauth
        </div>
    </div>
</nav>

<div style="height: 110px;"></div>