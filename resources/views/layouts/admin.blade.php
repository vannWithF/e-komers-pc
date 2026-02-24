<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | StoreKit Native</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* iPhone 17 Pro Max Orange Palette (Titanium Orange) */
            --titanium-orange: #ff6b35;
            --deep-orange: #e85a24;
            --soft-orange: rgba(255, 107, 53, 0.1);
            --glass-bg: rgba(255, 255, 255, 0.45);
            --glass-border: rgba(255, 255, 255, 0.5);
            --text-main: #2d1a12;
            --text-muted: #8a7b75;
            --white: #ffffff;
            --transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            /* Background gradasi abstrak khas macOS */
            background: radial-gradient(circle at top right, #fff5f0, #ffe0d1),
                        linear-gradient(135deg, #ffffff 0%, #ffdbc9 100%);
            background-attachment: fixed;
            color: var(--text-main);
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Layout Structure - Glass Container */
        .admin-layout {
            display: flex;
            height: 94vh;
            width: 96vw;
            background: var(--glass-bg);
            backdrop-filter: blur(30px) saturate(160%);
            -webkit-backdrop-filter: blur(30px) saturate(160%);
            border: 1px solid var(--glass-border);
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 
                0 25px 50px -12px rgba(232, 90, 36, 0.15),
                inset 0 0 0 1px rgba(255, 255, 255, 0.3);
        }

        /* Sidebar Styling - Liquid Glass Effect */
        .sidebar {
            width: 260px;
            background: rgba(255, 255, 255, 0.2);
            border-right: 1px solid rgba(255, 107, 53, 0.1);
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            z-index: 100;
        }

        .sidebar-header {
            padding: 40px 25px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .logo-box {
            width: 45px;
            height: 45px;
            background: linear-gradient(145deg, var(--titanium-orange), var(--deep-orange));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 0.9rem;
            box-shadow: 0 8px 20px rgba(232, 90, 36, 0.3);
        }

        .logo-text {
            color: var(--text-main);
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: -0.5px;
        }

        .nav-menu {
            flex: 1;
            padding: 0 15px;
            overflow-y: auto;
        }

        .nav-label {
            color: var(--text-muted);
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 25px 15px 10px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 18px;
            color: var(--text-main);
            text-decoration: none;
            border-radius: 16px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 4px;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .nav-item i { 
            margin-right: 12px; 
            font-style: normal; 
            font-size: 1.1rem;
            filter: grayscale(1) opacity(0.7);
            transition: var(--transition);
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.5);
            transform: translateY(-1px);
            border-color: rgba(255, 107, 53, 0.1);
        }

        .nav-item.active {
            background: var(--white);
            color: var(--deep-orange);
            box-shadow: 0 10px 25px -5px rgba(232, 90, 36, 0.15);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .nav-item.active i {
            filter: grayscale(0) opacity(1);
        }

        /* Main Content Styling */
        .main-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.1);
        }

        .top-navbar {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            background: rgba(255, 255, 255, 0.1);
        }

        .breadcrumb span {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
        }

        .avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #fff, #ffe0d1);
            border: 2px solid var(--titanium-orange);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--deep-orange);
            font-weight: 700;
            font-size: 0.8rem;
        }

        .content-area {
            flex: 1;
            padding: 30px 40px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--soft-orange) transparent;
        }

        /* Anti-Template Card Style */
        .content-area::-webkit-scrollbar {
            width: 6px;
        }

        /* Logout Button - Minimalist */
        .logout-btn {
            width: 100%;
            background: transparent;
            border: none;
            color: var(--text-muted) !important;
            cursor: pointer;
            text-align: left;
            margin-top: 10px;
            opacity: 0.7;
        }

        .logout-btn:hover {
            color: #d32f2f !important;
            background: rgba(211, 47, 47, 0.05) !important;
            opacity: 1;
        }

        /* Animasi Lembut */
        @keyframes liquidAppear {
            from { opacity: 0; transform: scale(0.98) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .content-area > * {
            animation: liquidAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
    </style>
</head>
<body>

<div class="admin-layout">
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-box">WRPS</div>
            <span class="logo-text">Warunk PC-Station</span>
        </div>

        <nav class="nav-menu">
            <div class="nav-label">Management</div>
            
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i>📊</i> Dashboard
            </a>
<!--             
            <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i>📁</i> Kategori
            </a> -->
            
            <a href="{{ route('admin.products.index') }}" class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i>📦</i> Produk
            </a>
            
            <a href="{{ route('admin.setups.index') }}" class="nav-item {{ request()->routeIs('admin.setups.*') ? 'active' : '' }}">
                <i>💻</i> Setups
            </a>
            
            <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i>🛒</i> Pesanan
            </a>

            <div class="nav-label">System</div>

            <a href="{{ route('shop.index') }}" class="nav-item">
                <i>🌐</i> Lihat Toko
            </a>

            <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                @csrf
                <button type="submit" class="nav-item logout-btn">
                    <i>🚪</i> Keluar
                </button>
            </form>
        </nav>
    </aside>

    <div class="main-container">
        <header class="top-navbar">
            <div class="breadcrumb">
                <span>Admin /</span> 
                <span style="font-weight: 700; color: var(--text-main); margin-left: 5px;">
                    {{ ucfirst(str_replace('.', ' ', request()->route()->getName())) }}
                </span>
            </div>

            <div class="user-profile">
                <div style="text-align: right;">
                    <p style="font-size: 0.8rem; font-weight: 700; color: var(--text-main);">{{ Auth::user()->name }}</p>
                    <p style="font-size: 0.65rem; color: var(--text-muted); font-weight: 600;">SUPER ADMIN</p>
                </div>
                <div class="avatar">{{ substr(Auth::user()->name, 0, 2) }}</div>
            </div>
        </header>

        <main class="content-area">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>