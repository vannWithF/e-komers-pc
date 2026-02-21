<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | StoreKit Native</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --bg-sidebar: #0f172a;
            --bg-main: #f8fafc;
            --text-muted: #94a3b8;
            --white: #ffffff;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: #1e293b;
            overflow: hidden;
        }

        /* Layout Structure */
        .admin-layout {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 280px;
            background-color: var(--bg-sidebar);
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            z-index: 100;
        }

        .sidebar-header {
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-box {
            width: 35px;
            height: 35px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .logo-text {
            color: var(--white);
            font-weight: 800;
            font-size: 1.2rem;
            letter-spacing: -0.5px;
        }

        .nav-menu {
            flex: 1;
            padding: 10px 15px;
            overflow-y: auto;
        }

        .nav-label {
            color: var(--text-muted);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 20px 15px 10px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 5px;
            transition: var(--transition);
        }

        .nav-item i { margin-right: 12px; font-style: normal; font-size: 1.1rem; }

        .nav-item:hover {
            color: var(--white);
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(5px);
        }

        .nav-item.active {
            background: var(--primary);
            color: var(--white);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
        }

        /* Main Content Styling */
        .main-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .top-navbar {
            height: 70px;
            background: var(--white);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #818cf8, #4f46e5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .content-area {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            animation: slideUp 0.6s ease-out;
        }

        /* Animations */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Logout Button */
        .logout-btn {
            width: 100%;
            background: none;
            border: none;
            color: #fb7185;
            cursor: pointer;
            text-align: left;
            font-family: inherit;
        }

        .logout-btn:hover {
            background: rgba(251, 113, 133, 0.1);
        }
    </style>
</head>
<body>

<div class="admin-layout">
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-box">SK</div>
            <span class="logo-text">STOREKIT</span>
        </div>

        <nav class="nav-menu">
            <div class="nav-label">Management</div>
            
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i>📊</i> Dashboard
            </a>
            
            <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i>📁</i> Kategori
            </a>
            
            <a href="{{ route('admin.products.index') }}" class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i>📦</i> Produk
            </a>
            
            <a href="{{ route('admin.setups.index') }}" class="nav-item {{ request()->routeIs('admin.setups.*') ? 'active' : '' }}">
                <i>💻</i> Setups
            </a>
            
            <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i>🛒</i> Pesanan
            </a>

            <div class="nav-label" style="margin-top:20px;">System</div>

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
                <span style="color: var(--text-muted); font-size: 0.85rem;">Admin /</span> 
                <span style="font-weight: 700; font-size: 0.85rem; margin-left: 5px;">
                    {{ ucfirst(str_replace('.', ' ', request()->route()->getName())) }}
                </span>
            </div>

            <div class="user-profile">
                <div style="text-align: right;">
                    <p style="font-size: 0.85rem; font-weight: 700;">{{ Auth::user()->name }}</p>
                    <p style="font-size: 0.7rem; color: var(--text-muted);">Super Admin</p>
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