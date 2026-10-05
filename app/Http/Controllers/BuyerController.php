<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BuyerController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        
        // Filter kategori jika pembeli klik salah satu menu di sidebar
        $selectedCategory = $request->query('category');
        $query = Product::with('category');

        if ($selectedCategory) {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        $products = $query->latest()->get();

        return view('buyer.dashboard', compact('categories', 'products', 'selectedCategory'));
    }

    public function book(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        // Cek stok khusus barang fisik
        if ($product->category->type === 'physical' && $product->stock < $request->quantity) {
            return back()->with('error', 'Maaf, stok barang tidak mencukupi!');
        }

        // Buat pesanan baru
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_code' => 'SKN-' . strtoupper(Str::random(5)),
            'total_amount' => $product->price * $request->quantity,
            'payment_status' => 'paid', // Simulasi bayar via hp
            'order_status' => 'pending' // Menunggu diambil di koperasi
        ]);

        // Simpan detail item
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
            'cost_price' => $product->cost_price,
            'notes' => $request->notes
        ]);

        // Kurangi stok barang fisik
        if ($product->category->type === 'physical') {
            $product->decrement('stock', $request->quantity);
        }

        return back()->with('success', 'Pesanan berhasil! Kode Pengambilan: ' . $order->order_code);
    }
    public function orders()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('buyer.orders', compact('orders'));
    }
    public function cancelOrder($id)
    {
        $order = Order::with('items.product.category')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->where('order_status', 'pending')
            ->firstOrFail();

        // Kembalikan stok untuk barang bertipe fisik
        foreach ($order->items as $item) {
            if ($item->product && $item->product->category && $item->product->category->type === 'physical') {
                $item->product->increment('stock', $item->quantity);
            }
        }

        // Ubah status pesanan menjadi dibatalkan
        $order->update([
            'order_status' => 'cancelled'
        ]);

        return back()->with('success', 'Pesanan ' . $order->order_code . ' berhasil dibatalkan dan stok dikembalikan.');
    }
    public function printReceipt($id)
    {
        $order = Order::with(['user', 'items.product'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('buyer.receipt', compact('order'));
    }
}