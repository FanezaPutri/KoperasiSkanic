<?php

namespace Tests\Feature;

use App\Models\Order;
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

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Koperasi Skanic');
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
}
