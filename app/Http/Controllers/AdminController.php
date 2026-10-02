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
        // 1. Data Ringkasan Keuangan & Statistik
        $totalIncome = Order::where('payment_status', 'paid')->sum('total_amount');
        
        // Menghitung keuntungan bersih: (harga jual - modal) * qty
        $completedOrderIds = Order::where('order_status', 'completed')->pluck('id');
        $netProfit = OrderItem::whereIn('order_id', $completedOrderIds)
            ->selectRaw('SUM((price - cost_price) * quantity) as profit')
            ->value('profit') ?? 0;

        $pendingOrdersCount = Order::where('order_status', 'pending')->count();
        $lowStockCount = Product::where('stock', '<=', 5)->count();

        // 2. Daftar Pesanan Masuk (Terbaru)
        $orders = Order::with(['user', 'items.product'])->latest()->take(10)->get();

        // 3. Daftar Produk untuk Pantau Stok
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();

        return view('admin.dashboard', compact(
            'totalIncome',
            'netProfit',
            'pendingOrdersCount',
            'lowStockCount',
            'orders',
            'products',
            'categories'
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
}