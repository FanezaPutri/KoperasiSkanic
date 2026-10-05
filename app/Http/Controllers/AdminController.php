<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Pesanan yang siap/perlu diambil siswa (Pending)
        $pendingOrders = Order::with(['user', 'items.product'])
            ->where('order_status', 'pending')
            ->latest()
            ->get();

        // 2. Riwayat Pesanan (Selesai & Dibatalkan) untuk diletakkan di bawah dashboard
        $historyOrders = Order::with(['user', 'items.product'])
            ->whereIn('order_status', ['completed', 'cancelled'])
            ->latest()
            ->take(10)
            ->get();

        // Statistik Dashboard
        $completedOrders = Order::with('items')->where('order_status', 'completed')->get();
        $totalRevenue = $completedOrders->sum('total_amount');

        $totalCost = 0;
        foreach ($completedOrders as $order) {
            foreach ($order->items as $item) {
                $totalCost += ($item->cost_price * $item->quantity);
            }
        }
        $netProfit = $totalRevenue - $totalCost;

        $pendingCount = $pendingOrders->count();
        $lowStockCount = Product::where('stock', '<=', 5)->count();

        return view('admin.dashboard', compact(
            'pendingOrders',
            'historyOrders',
            'totalRevenue',
            'netProfit',
            'pendingCount',
            'lowStockCount'
        ));
    }

    // Fitur Klik Langsung Konfirmasi Pengambilan (Selesai)
    public function completeOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['order_status' => 'completed']);

        return back()->with('success', 'Pesanan ' . $order->order_code . ' berhasil diselesaikan!');
    }
    public function report(Request $request)
    {
        $period = $request->query('period', 'all');

        $query = Order::with(['user', 'items.product'])
            ->where('order_status', 'completed');

        if ($period === 'today') {
            $query->whereDate('created_at', now()->today());
        } elseif ($period === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($period === 'month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        }

        $completedOrders = $query->latest()->get();

        $totalRevenue = $completedOrders->sum('total_amount');
        
        $totalCost = 0;
        foreach ($completedOrders as $order) {
            foreach ($order->items as $item) {
                $totalCost += ($item->cost_price * $item->quantity);
            }
        }

        $netProfit = $totalRevenue - $totalCost;

        return view('admin.report', compact('completedOrders', 'totalRevenue', 'totalCost', 'netProfit', 'period'));
    }
    public function ordersHistory(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search');

        $query = Order::with(['user', 'items.product'])->latest();

        if ($status !== 'all') {
            $query->where('order_status', $status);
        }

        if ($search) {
            $query->where('order_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $orders = $query->paginate(15);

        return view('admin.orders-history', compact('orders', 'status', 'search'));
    }
}