<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $request->merge(['action' => 'buy_now']);

        return $this->addToCart($request, $id);
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $totalItems = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $totalItems += $item['quantity'];
        }

        return view('buyer.cart', compact('cart', 'total', 'totalItems'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::with('category')->findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        $cart = session()->get('cart', []);
        $currentQty = isset($cart[$id]) ? (int) $cart[$id]['quantity'] : 0;
        $newQty = $currentQty + (int) $request->quantity;

        // Validasi ketersediaan stok fisik
        if ($product->category->type === 'physical') {
            if ($product->stock <= 0) {
                $errorMsg = "Maaf, stok {$product->name} sedang habis!";
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMsg,
                    ], 422);
                }

                return back()->with('error', $errorMsg);
            }
            if ($product->stock < $newQty) {
                $errorMsg = "Stok {$product->name} tidak mencukupi! Tersisa {$product->stock} unit (sudah ada {$currentQty} di keranjang).";
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMsg,
                    ], 422);
                }

                return back()->with('error', $errorMsg);
            }
        }

        $cart[$id] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => (int) $product->price,
            'cost_price' => (int) $product->cost_price,
            'quantity' => $newQty,
            'notes' => $request->notes ?? ($cart[$id]['notes'] ?? null),
            'type' => $product->category->type,
            'category_name' => $product->category->name,
            'stock' => $product->stock,
        ];

        session()->put('cart', $cart);

        $cartCount = count($cart);
        $cartTotalUnits = array_reduce($cart, fn ($acc, $item) => $acc + $item['quantity'], 0);
        $cartTotal = array_reduce($cart, fn ($acc, $item) => $acc + ($item['price'] * $item['quantity']), 0);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$product->name} ({$request->quantity}x) berhasil dimasukkan ke keranjang belanja!",
                'product_name' => $product->name,
                'quantity_added' => (int) $request->quantity,
                'cartCount' => $cartCount,
                'cartTotalUnits' => $cartTotalUnits,
                'cartTotal' => $cartTotal,
                'cartTotalFormatted' => 'Rp '.number_format($cartTotal, 0, ',', '.'),
            ]);
        }

        if ($request->input('action') === 'buy_now') {
            return redirect()->route('buyer.cart')->with('success', "{$product->name} ({$request->quantity}x) berhasil dimasukkan ke keranjang!");
        }

        return back()->with('success', "{$product->name} ({$request->quantity}x) berhasil dimasukkan ke keranjang belanja!");
    }

    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (! isset($cart[$id])) {
            return back()->with('error', 'Produk tidak ditemukan di dalam keranjang.');
        }

        $product = Product::with('category')->find($id);
        if (! $product) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return back()->with('error', 'Produk sudah tidak tersedia lagi di koperasi.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        if ($product->category->type === 'physical' && $product->stock < $request->quantity) {
            return back()->with('error', "Stok {$product->name} hanya tersisa {$product->stock} unit!");
        }

        $cart[$id]['quantity'] = (int) $request->quantity;
        if ($request->has('notes')) {
            $cart[$id]['notes'] = $request->notes;
        }
        $cart[$id]['stock'] = $product->stock;

        session()->put('cart', $cart);

        return back()->with('success', "Keranjang untuk {$product->name} berhasil diperbarui.");
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $name = $cart[$id]['name'];
            unset($cart[$id]);
            session()->put('cart', $cart);

            return back()->with('success', "{$name} berhasil dihapus dari keranjang.");
        }

        return back()->with('error', 'Barang tidak ditemukan di keranjang.');
    }

    public function clearCart()
    {
        session()->forget('cart');

        return back()->with('success', 'Keranjang belanja berhasil dikosongkan.');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('buyer.cart')->with('error', 'Keranjang belanja Anda masih kosong! Silakan pilih produk terlebih dahulu.');
        }

        // Cek stok fisik sebelum membuat pesanan
        foreach ($cart as $id => $item) {
            $product = Product::with('category')->find($id);
            if (! $product) {
                unset($cart[$id]);
                session()->put('cart', $cart);

                return redirect()->route('buyer.cart')->with('error', "Produk '{$item['name']}' sudah tidak tersedia di katalog.");
            }

            if ($product->category->type === 'physical' && $product->stock < $item['quantity']) {
                return redirect()->route('buyer.cart')->with('error', "Stok untuk {$product->name} tidak mencukupi! Hanya tersisa {$product->stock} unit.");
            }
        }

        // Simpan pesanan tunggal berisi semua item dalam 1 transaksi
        $order = DB::transaction(function () use ($cart) {
            $totalAmount = 0;
            foreach ($cart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => 'SKN-'.strtoupper(Str::random(5)),
                'total_amount' => $totalAmount,
                'payment_status' => 'paid',
                'order_status' => 'pending',
            ]);

            foreach ($cart as $id => $item) {
                $product = Product::with('category')->find($id);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'cost_price' => $product->cost_price,
                    'notes' => $item['notes'] ?? null,
                ]);

                if ($product->category->type === 'physical') {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            return $order;
        });

        // Kosongkan keranjang belanja setelah checkout berhasil
        session()->forget('cart');

        return redirect()->route('buyer.orders')->with('success', 'Checkout berhasil! Kode Pengambilan Anda: '.$order->order_code.'. Silakan tunjukkan kode ini di kasir koperasi.');
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
            'order_status' => 'cancelled',
        ]);

        return back()->with('success', 'Pesanan '.$order->order_code.' berhasil dibatalkan dan stok dikembalikan.');
    }

    public function mergePendingOrders()
    {
        $userId = Auth::id();

        $pendingOrders = Order::with('items')
            ->where('user_id', $userId)
            ->where('order_status', 'pending')
            ->latest()
            ->get();

        if ($pendingOrders->count() < 2) {
            return back()->with('error', 'Tidak ada minimal 2 pesanan pending yang dapat disatukan.');
        }

        $mergedOrder = DB::transaction(function () use ($pendingOrders) {
            // Gunakan pesanan pertama sebagai induk pesanan gabungan
            $primaryOrder = $pendingOrders->first();
            $otherOrders = $pendingOrders->slice(1);

            foreach ($otherOrders as $order) {
                // Pindahkan semua item ke pesanan induk
                OrderItem::where('order_id', $order->id)->update([
                    'order_id' => $primaryOrder->id,
                ]);

                // Hapus record pesanan yang item-itemnya sudah dipindahkan
                $order->delete();
            }

            // Hitung ulang total amount dari pesanan induk
            $newTotal = (int) OrderItem::where('order_id', $primaryOrder->id)
                ->sum(DB::raw('price * quantity'));

            $primaryOrder->update([
                'total_amount' => $newTotal,
            ]);

            return $primaryOrder;
        });

        return redirect()->route('buyer.orders.receipt', $mergedOrder->id)
            ->with('success', "Berhasil menyatukan {$pendingOrders->count()} pesanan menjadi 1 struk dengan Kode: {$mergedOrder->order_code}!");
    }

    public function printReceipt($id)
    {
        $query = Order::with(['user', 'items.product'])->where('id', $id);

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $order = $query->firstOrFail();

        return view('buyer.receipt', compact('order'));
    }
}
