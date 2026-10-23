<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Rute Beranda (Landing Page) & Autentikasi
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Terproteksi Login
Route::middleware('auth')->group(function () {

    // Khusus Penjaga Koperasi (Admin)
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/riwayat-pesanan', [AdminController::class, 'ordersHistory'])->name('admin.orders.history');
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/admin/orders/{id}/complete', [AdminController::class, 'completeOrder'])->name('admin.order.complete');
        Route::get('/admin/laporan', [AdminController::class, 'report'])->name('admin.report');

        // Kelola Barang
        Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    });

    // Khusus Pembeli (Siswa)
    Route::middleware('role:buyer')->group(function () {
        Route::get('/katalog', [BuyerController::class, 'index'])->name('buyer.dashboard');
        Route::post('/katalog/book/{id}', [BuyerController::class, 'book'])->name('buyer.book');

        // Keranjang Belanja & Checkout
        Route::get('/keranjang', [BuyerController::class, 'cart'])->name('buyer.cart');
        Route::post('/keranjang/tambah/{id}', [BuyerController::class, 'addToCart'])->name('buyer.cart.add');
        Route::post('/keranjang/update/{id}', [BuyerController::class, 'updateCart'])->name('buyer.cart.update');
        Route::delete('/keranjang/hapus/{id}', [BuyerController::class, 'removeFromCart'])->name('buyer.cart.remove');
        Route::post('/keranjang/kosongkan', [BuyerController::class, 'clearCart'])->name('buyer.cart.clear');
        Route::post('/keranjang/checkout', [BuyerController::class, 'checkout'])->name('buyer.cart.checkout');

        Route::get('/pesanan-saya', [BuyerController::class, 'orders'])->name('buyer.orders');
        Route::post('/pesanan-saya/satukan', [BuyerController::class, 'mergePendingOrders'])->name('buyer.orders.merge');
        Route::post('/pesanan-saya/{id}/batal', [BuyerController::class, 'cancelOrder'])->name('buyer.orders.cancel');
        Route::get('/pesanan-saya/{id}/struk', [BuyerController::class, 'printReceipt'])->name('buyer.orders.receipt');
    });

});
