<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalOrders = Order::count();

        // Revenue dihitung dari semua order (termasuk pending untuk keperluan testing/real-time)
        // Jika ingin lebih ketat, ganti menjadi ['paid', 'shipped', 'completed']
        $totalRevenue = Order::whereIn('status', ['pending', 'paid', 'shipped', 'completed'])
                            ->sum('total_price');

        $pendingOrders = Order::where('status', 'pending')->count();
        $paidOrders = Order::where('status', 'paid')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();

        // Grafik Penjualan (Harian dalam 30 hari terakhir)
        $salesData = Order::whereIn('status', ['pending', 'paid', 'shipped', 'completed'])
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Grafik Distribusi Status Pesanan (Lingkaran/Doughnut)
        $orderStatusData = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        // Grafik User Baru (Harian dalam 30 hari terakhir)
        $userData = User::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalUsers',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'paidOrders',
            'shippedOrders',
            'salesData',
            'userData',
            'orderStatusData'
        ));
    }
}

