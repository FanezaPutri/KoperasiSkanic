<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Koperasi Skanic');
        $response->assertSee(route('login'));
    }

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Koperasi Skanic');
        $response->assertDontSee('Akun Pengujian Demo');
    }

    public function test_admin_dashboard_renders_successfully(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Penjaga Koperasi');
    }

    public function test_admin_orders_history_renders_successfully(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/riwayat-pesanan');
        $response->assertStatus(200);
        $response->assertSee('Riwayat Semua Pesanan');
    }

    public function test_admin_products_index_renders_successfully(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/products');
        $response->assertStatus(200);
        $response->assertSee('Kelola Barang Koperasi');
    }

    public function test_admin_report_renders_successfully(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/laporan');
        $response->assertStatus(200);
        $response->assertSee('Laporan Keuangan');
    }

    public function test_buyer_catalog_renders_successfully(): void
    {
        $buyer = User::where('role', 'buyer')->first();

        $response = $this->actingAs($buyer)->get('/katalog');
        $response->assertStatus(200);
        $response->assertSee('Katalog Koperasi Siswa');
    }

    public function test_buyer_orders_renders_successfully(): void
    {
        $buyer = User::where('role', 'buyer')->first();

        $response = $this->actingAs($buyer)->get('/pesanan-saya');
        $response->assertStatus(200);
        $response->assertSee('Pesanan Saya');
    }

    public function test_buyer_receipt_renders_if_order_exists(): void
    {
        $buyer = User::where('role', 'buyer')->first();
        $order = Order::where('user_id', $buyer->id)->first();

        if ($order) {
            $response = $this->actingAs($buyer)->get("/pesanan-saya/{$order->id}/struk");
            $response->assertStatus(200);
            $response->assertSee('KOPERASI SKANIC');
        } else {
            $this->assertTrue(true);
        }
    }

    public function test_buyer_can_add_multiple_different_products_to_cart_and_checkout_as_one_receipt(): void
    {
        $buyer = User::where('role', 'buyer')->first();
        $products = Product::take(2)->get();

        $this->assertCount(2, $products);

        // Tambah produk 1 dan produk 2 ke keranjang
        $this->actingAs($buyer)->post("/keranjang/tambah/{$products[0]->id}", ['quantity' => 1]);
        $this->actingAs($buyer)->post("/keranjang/tambah/{$products[1]->id}", ['quantity' => 2]);

        // Pastikan keranjang berisi 2 macam produk
        $cart = session('cart');
        $this->assertCount(2, $cart);

        // Checkout keranjang menjadi 1 order tunggal
        $initialOrderCount = Order::where('user_id', $buyer->id)->count();
        $checkoutResponse = $this->actingAs($buyer)->post('/keranjang/checkout');
        $checkoutResponse->assertRedirect('/pesanan-saya');

        // Pastikan hanya bertambah 1 order
        $this->assertEquals($initialOrderCount + 1, Order::where('user_id', $buyer->id)->count());

        $newOrder = Order::with('items')->where('user_id', $buyer->id)->latest()->first();
        $this->assertCount(2, $newOrder->items);

        // Pastikan struk menampilkan kedua barang dalam 1 lembar struk
        $receiptResponse = $this->actingAs($buyer)->get("/pesanan-saya/{$newOrder->id}/struk");
        $receiptResponse->assertStatus(200);
        $receiptResponse->assertSee($products[0]->name);
        $receiptResponse->assertSee($products[1]->name);
        $receiptResponse->assertSee('Rp '.number_format($newOrder->total_amount, 0, ',', '.'));
    }

    public function test_buyer_can_merge_multiple_pending_orders_into_one_receipt(): void
    {
        $buyer = User::where('role', 'buyer')->first();
        $products = Product::take(2)->get();

        // Buat 2 pesanan pending terpisah secara manual
        $order1 = Order::create([
            'user_id' => $buyer->id,
            'order_code' => 'SKN-TEST1',
            'total_amount' => $products[0]->price * 1,
            'payment_status' => 'paid',
            'order_status' => 'pending',
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $products[0]->id,
            'quantity' => 1,
            'price' => $products[0]->price,
            'cost_price' => $products[0]->cost_price,
        ]);

        $order2 = Order::create([
            'user_id' => $buyer->id,
            'order_code' => 'SKN-TEST2',
            'total_amount' => $products[1]->price * 2,
            'payment_status' => 'paid',
            'order_status' => 'pending',
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $products[1]->id,
            'quantity' => 2,
            'price' => $products[1]->price,
            'cost_price' => $products[1]->cost_price,
        ]);

        // Lakukan penggabungan pesanan pending
        $response = $this->actingAs($buyer)->post('/pesanan-saya/satukan');
        $response->assertRedirect();

        // Pesanan terpisah order2 sudah dihapus dan itemnya digabung ke pesanan induk
        $this->assertDatabaseMissing('orders', ['id' => $order2->id]);

        $mergedOrder = Order::with('items')->find($order1->id);
        $this->assertNotNull($mergedOrder);
        $this->assertCount(2, $mergedOrder->items);
        $this->assertEquals(($products[0]->price * 1) + ($products[1]->price * 2), $mergedOrder->total_amount);
    }

    public function test_buyer_can_add_to_cart_via_ajax_without_page_reload(): void
    {
        $buyer = User::where('role', 'buyer')->first();
        $product = Product::first();

        $response = $this->actingAs($buyer)->postJson("/keranjang/tambah/{$product->id}", [
            'quantity' => 2,
            'notes' => 'Catatan via ajax',
            'action' => 'add',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'product_name' => $product->name,
            'quantity_added' => 2,
            'cartCount' => 1,
            'cartTotalUnits' => 2,
        ]);

        $cart = session('cart');
        $this->assertArrayHasKey($product->id, $cart);
        $this->assertEquals(2, $cart[$product->id]['quantity']);
        $this->assertEquals('Catatan via ajax', $cart[$product->id]['notes']);
    }

    public function test_ajax_add_to_cart_validates_stock(): void
    {
        $buyer = User::where('role', 'buyer')->first();
        $product = Product::whereHas('category', fn ($q) => $q->where('type', 'physical'))->first();

        // Coba pesan melebihi stok yang tersedia
        $response = $this->actingAs($buyer)->postJson("/keranjang/tambah/{$product->id}", [
            'quantity' => $product->stock + 10,
            'action' => 'add',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
        ]);
    }
}
