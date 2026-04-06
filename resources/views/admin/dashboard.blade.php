@extends('layouts.admin') {{-- Pakai layout khusus admin --}}
@section('content')

<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .welcome-banner {
        background: linear-gradient(135deg, var(--titanium-orange), var(--deep-orange));
        padding: 30px;
        border-radius: 24px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 20px 40px rgba(255, 107, 53, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .welcome-text h1 { font-size: 1.8rem; font-weight: 800; margin-bottom: 5px; }
    .welcome-text p { opacity: 0.9; font-size: 0.95rem; }

    /* Stats Grid */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        padding: 24px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 10px 20px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 15px 30px rgba(255, 107, 53, 0.1);
    }

    .stat-icon {
        width: 40px;height: 40px;
        background: var(--soft-orange);
        color: var(--deep-orange);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        font-size: 1.2rem;
    }

    .stat-label { color: var(--text-muted); font-size: 0.8rem; font-weight: 600; margin-bottom: 5px; display: block; }
    .stat-value { font-size: 1.6rem; font-weight: 800; color: var(--text-main); margin: 0; }

    /* Charts Section */
    .analytics-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 30px;
    }

    .chart-card {
        background: white;
        padding: 24px;
        border-radius: 24px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.02);
        border: 1px solid #f1f1f1;
        height: 400px;
        display: flex;
        flex-direction: column;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-title { font-size: 1rem; font-weight: 700; color: var(--text-main); }

    @media (max-width: 1024px) {
        .analytics-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-container">
    <div class="welcome-banner">
        <div class="welcome-text">
            <h1>Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
            <p>Selamat datang kembali di pusat kendali StoreKit.</p>
        </div>
        <div class="date-badge" style="background: rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 12px; font-weight: 700;">
            {{ now()->format('d M, Y') }}
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="stat-grid">
        <div class="glass-card">
            <div class="stat-icon">💰</div>
            <span class="stat-label">Total Pendapatan</span>
            <p class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="glass-card">
            <div class="stat-icon">🛒</div>
            <span class="stat-label">Total Pesanan</span>
            <p class="stat-value">{{ number_format($totalOrders) }}</p>
        </div>
        <div class="glass-card">
            <div class="stat-icon">👥</div>
            <span class="stat-label">Total User</span>
            <p class="stat-value">{{ number_format($totalUsers) }}</p>
        </div>
        <div class="glass-card">
            <div class="stat-icon">📦</div>
            <span class="stat-label">Total Produk</span>
            <p class="stat-value">{{ number_format($totalProducts) }}</p>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="analytics-grid">
        <!-- Sales Trend (Line Chart) -->
        <div class="chart-card">
            <div class="chart-header">
                <span class="chart-title">📈 Tren Pendapatan (30 Hari)</span>
            </div>
            <div style="flex: 1; position: relative;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Order Distribution (Doughnut Chart) -->
        <div class="chart-card">
            <div class="chart-header">
                <span class="chart-title">📊 Status Pesanan</span>
            </div>
            <div style="flex: 1; position: relative; padding: 20px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- New Logistics Section Card -->
    <div class="glass-card" style="margin-bottom: 30px;">
        <h3 style="font-size: 1rem; margin-bottom: 20px;">📦 Ringkasan Logistik</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
            <div style="padding: 15px; background: #fff3ed; border-radius: 16px; border-left: 4px solid var(--titanium-orange);">
                <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700;">PENDING</span>
                <p style="font-size: 1.2rem; font-weight: 800; margin: 0;">{{ $pendingOrders }}</p>
            </div>
            <div style="padding: 15px; background: #eef7ff; border-radius: 16px; border-left: 4px solid #4a90e2;">
                <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700;">PAID</span>
                <p style="font-size: 1.2rem; font-weight: 800; margin: 0;">{{ $paidOrders }}</p>
            </div>
            <div style="padding: 15px; background: #f5f0ff; border-radius: 16px; border-left: 4px solid #6b46c1;">
                <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700;">SHIPPED</span>
                <p style="font-size: 1.2rem; font-weight: 800; margin: 0;">{{ $shippedOrders }}</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Sales Trend Chart (Line)
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesData->pluck('date')) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($salesData->pluck('total')) !!},
                borderColor: '#ff6b35',
                backgroundColor: 'rgba(255, 107, 53, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#ff6b35',
                pointBorderColor: '#fff',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Order Status Chart (Doughnut)
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($orderStatusData->pluck('status')) !!},
            datasets: [{
                data: {!! json_encode($orderStatusData->pluck('total')) !!},
                backgroundColor: ['#ffc107', '#2196f3', '#9c27b0', '#4caf50', '#f44336'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            }
        }
    });
});
</script>
@endsection