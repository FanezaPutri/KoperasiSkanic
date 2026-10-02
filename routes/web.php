<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Rute Login & Logout
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Terproteksi Login
Route::middleware('auth')->group(function () {

    // Khusus Penjaga Koperasi (Admin)
    Route::middleware('role:admin')->group(function () {
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
        Route::get('/pesanan-saya', [BuyerController::class, 'orders'])->name('buyer.orders');
    });

});