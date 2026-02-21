@extends('layouts.admin') {{-- Pakai layout khusus admin --}}
@section('content')

<style>
    .dashboard-container {
        max-width: 1100px;
        margin: 30px auto;
        padding: 0 20px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    h2 {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 25px;
    }

    /* Grid Layout */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    /* Card Base Style */
    .stat-card {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px rgba(0,0,0,0.05);
    }

    /* Primary Stats (Highlight) */
    .stat-card.primary {
        background: linear-gradient(135deg, #4A90E2, #357ABD);
        color: white;
        border: none;
    }

    .stat-card.revenue {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        grid-column: span 1;
    }

    /* Typography inside cards */
    .stat-label {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        opacity: 0.8;
        margin-bottom: 10px;
        display: block;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        margin: 0;
    }

    /* Order Status Section */
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #4a5568;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .status-card {
        background: #f8fafc;
        padding: 15px;
        border-radius: 10px;
        border-left: 4px solid #cbd5e0;
    }

    .status-pending { border-left-color: #f6ad55; }
    .status-paid { border-left-color: #4299e1; }
    .status-shipped { border-left-color: #9f7aea; }

    @media (max-width: 768px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }
    }
</style>


<div class="dashboard-container">
    <h2>Admin Dashboard</h2>

    <div class="stat-grid">
        <div class="stat-card primary">
            <span class="stat-label">Total Produk</span>
            <p class="stat-value">{{ number_format($totalProducts) }}</p>
        </div>

        <div class="stat-card primary">
            <span class="stat-label">Total User</span>
            <p class="stat-value">{{ number_format($totalUsers) }}</p>
        </div>

        <div class="stat-card revenue">
            <span class="stat-label">Total Pendapatan</span>
            <p class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="section-title">
        📦 Status Logistik Pesanan
    </div>
    
    <div class="status-grid">
        <div class="status-card status-pending">
            <span class="stat-label" style="color: #c05621;">Pending</span>
            <p class="stat-value" style="font-size: 1.4rem; color: #2d3748;">{{ $pendingOrders }}</p>
        </div>

        <div class="status-card status-paid">
            <span class="stat-label" style="color: #2b6cb0;">Paid</span>
            <p class="stat-value" style="font-size: 1.4rem; color: #2d3748;">{{ $paidOrders }}</p>
        </div>

        <div class="status-card status-shipped">
            <span class="stat-label" style="color: #6b46c1;">Shipped</span>
            <p class="stat-value" style="font-size: 1.4rem; color: #2d3748;">{{ $shippedOrders }}</p>
        </div>

        <div class="status-card">
            <span class="stat-label">Total Order</span>
            <p class="stat-value" style="font-size: 1.4rem; color: #2d3748;">{{ $totalOrders }}</p>
        </div>
    </div>
</div>

@endsection