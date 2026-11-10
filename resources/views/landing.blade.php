<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koperasi Skanic - Sistem Koperasi Sekolah Digital</title>
    <meta name="description" content="Platform resmi Koperasi Digital Skanic. Belanja makanan, alat tulis, seragam, fotokopi, hingga pulsa lebih cepat, rapi, dan dalam 1 struk terpadu tanpa antre panjang di jam istirahat.">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'Fira Code', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white flex flex-col min-h-screen">

    <!-- Header & Navigasi -->
    <header class="bg-white/85 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- Logo Brand -->
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/25 group-hover:scale-105 transition-transform duration-200">
                    <i class="fa-solid fa-store text-lg"></i>
                </div>
                <div>
                    <h1 class="font-black text-lg tracking-tight text-slate-900 group-hover:text-blue-600 transition-colors">
                        Koperasi Skanic
                    </h1>
                    <p class="text-[11px] font-semibold text-blue-600 tracking-wide">Smart Digital Cooperative</p>
                </div>
            </a>

            <!-- Menu Navigasi Tengah -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="#beranda" class="hover:text-blue-600 transition">Beranda</a>
                <a href="#keunggulan" class="hover:text-blue-600 transition">Keunggulan</a>
                <a href="#kategori" class="hover:text-blue-600 transition">Katalog Produk</a>
                <a href="#cara-kerja" class="hover:text-blue-600 transition">Cara Belanja</a>
            </nav>

            <!-- Tombol Aksi Kanan (Terhubung ke Login) -->
            <div class="flex items-center gap-3">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl text-xs sm:text-sm shadow-md shadow-blue-500/25 transition active:scale-95 flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie"></i>
                            <span>Panel Admin</span>
                        </a>
                    @else
                        <a href="{{ route('buyer.dashboard') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl text-xs sm:text-sm shadow-md shadow-blue-500/25 transition active:scale-95 flex items-center gap-2">
                            <i class="fa-solid fa-shop"></i>
                            <span>Buka Katalog Belanja</span>
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl text-xs sm:text-sm shadow-md shadow-blue-500/25 hover:shadow-lg hover:shadow-blue-500/35 transition active:scale-95 flex items-center gap-2">
                        <span>Masuk ke Sistem</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                @endauth
            </div>

        </div>
    </header>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-12 pb-20 sm:pt-20 sm:pb-28 overflow-hidden bg-gradient-to-b from-white via-slate-50 to-blue-50/40">
        <!-- Ambient Glowing Blur Elements -->
        <div class="absolute top-10 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-blue-400/10 rounded-full blur-[110px] pointer-events-none"></div>
        <div class="absolute top-40 right-10 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Teks Hero (Kiri) -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200/80 text-blue-700 text-xs font-bold shadow-xs">
                        <i class="fa-solid fa-bolt text-amber-500"></i>
                        <span>Koperasi Digital Siswa Modern</span>
                    </div>

                    <h2 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-[1.15]">
                        Belanja Kebutuhan Sekolah Cepat, Praktis, & 
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                            Tanpa Antre
                        </span>
                    </h2>

                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Platform digital resmi Koperasi Siswa Skanic. Pesan makanan, minuman, perlengkapan belajar, seragam, hingga fotokopi tugas & pulsa dari kelas. Semua barang disatukan dalam <strong>1 kode dan 1 struk pengambilan resmi</strong>.
                    </p>

                    <!-- Tombol Aksi Utama -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3.5 pt-2">
                        @auth
                            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('buyer.dashboard') }}" class="w-full sm:w-auto px-7 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold rounded-2xl text-sm shadow-xl shadow-blue-500/30 transition active:scale-95 flex items-center justify-center gap-2.5">
                                <i class="fa-solid fa-store"></i>
                                <span>Buka Dashboard Sekarang</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full sm:w-auto px-7 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold rounded-2xl text-sm shadow-xl shadow-blue-500/30 hover:shadow-2xl hover:shadow-blue-500/40 transition active:scale-95 flex items-center justify-center gap-2.5">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                <span>Masuk ke Sistem (Login)</span>
                            </a>
                        @endauth
                        <a href="#cara-kerja" class="w-full sm:w-auto px-6 py-3.5 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-2xl text-sm border border-slate-200/90 shadow-sm transition active:scale-95 flex items-center justify-center gap-2">
                            <i class="fa-regular fa-circle-play text-blue-600"></i>
                            <span>Pelajari Cara Belanja</span>
                        </a>
                    </div>

                    <!-- Poin Keunggulan Cepat -->
                    <div class="pt-6 border-t border-slate-200/70 grid grid-cols-3 gap-3 text-left">
                        <div class="space-y-0.5">
                            <span class="block text-base sm:text-lg font-black text-slate-900 font-mono">1 Struk</span>
                            <span class="block text-[11px] font-medium text-slate-500">Gabung Semua Barang</span>
                        </div>
                        <div class="space-y-0.5">
                            <span class="block text-base sm:text-lg font-black text-blue-600 font-mono">0 Menit</span>
                            <span class="block text-[11px] font-medium text-slate-500">Bebas Antre Panjang</span>
                        </div>
                        <div class="space-y-0.5">
                            <span class="block text-base sm:text-lg font-black text-slate-900 font-mono">100% Resmi</span>
                            <span class="block text-[11px] font-medium text-slate-500">Harga Standar Koperasi</span>
                        </div>
                    </div>
                </div>

                <!-- Preview Kartu Struk & Ilustrasi (Kanan) -->
                <div class="lg:col-span-5 flex justify-center">
                    <div class="relative w-full max-w-sm">
                        <!-- Background Glow Accent -->
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl blur-xl opacity-25"></div>
                        
                        <!-- Kartu Mockup Struk Digital Interaktif -->
                        <div class="relative bg-white rounded-3xl p-6 sm:p-7 shadow-2xl border border-slate-200/80 space-y-5 text-xs text-slate-700">
                            
                            <!-- Header Mockup -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">
                                        <i class="fa-solid fa-receipt"></i>
                                    </div>
                                    <div>
                                        <span class="font-extrabold text-slate-900 text-sm block">Struk Pembelian</span>
                                        <span class="text-[10px] text-slate-400">Koperasi Skanic Digital</span>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[10px] font-bold">
                                    1 Kode Pengambilan
                                </span>
                            </div>

                            <!-- Kode Pengambilan Box -->
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50/60 p-3.5 rounded-2xl border border-blue-200/60 text-center space-y-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-blue-700 block">Kode Pesanan Gabungan</span>
                                <span class="text-xl font-black font-mono text-slate-900 tracking-wider">SKN-8821X</span>
                                <span class="text-[10px] text-slate-500 block">Tunjukkan kode ini saat mengambil barang</span>
                            </div>

                            <!-- Daftar Multi-Barang dalam 1 Struk -->
                            <div class="space-y-2.5 pt-1">
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Daftar Belanjaan Terpadu:</div>
                                
                                <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-[10px]">
                                            <i class="fa-solid fa-bottle-water"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-800 text-xs block">Susu Cimory UHT</span>
                                            <span class="text-[10px] text-slate-400">1x @ Rp 6.000</span>
                                        </div>
                                    </div>
                                    <span class="font-mono font-bold text-xs">Rp 6.000</span>
                                </div>

                                <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-cyan-100 text-cyan-700 flex items-center justify-center text-[10px]">
                                            <i class="fa-solid fa-pen"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-800 text-xs block">Pensil Joyko 2B</span>
                                            <span class="text-[10px] text-slate-400">1x @ Rp 3.000</span>
                                        </div>
                                    </div>
                                    <span class="font-mono font-bold text-xs">Rp 3.000</span>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                <span class="font-bold text-slate-600 text-xs">Total Pembayaran:</span>
                                <span class="font-black font-mono text-base text-blue-700">Rp 9.000</span>
                            </div>

                            <!-- Badge Garansi -->
                            <div class="text-center pt-2">
                                <span class="text-[10px] font-semibold text-slate-400 flex items-center justify-center gap-1">
                                    <i class="fa-solid fa-circle-check text-emerald-500"></i> Langsung tercatat di sistem kasir koperasi
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section id="keunggulan" class="py-20 bg-white border-y border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full border border-blue-200/70">
                    Solusi Cerdas Siswa
                </span>
                <h3 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Kenapa Harus Belanja Lewat Koperasi Digital?
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Dirancang khusus untuk mendukung ritme belajar siswa yang padat dengan efisiensi maksimal.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Fitur 1 -->
                <div class="bg-slate-50/80 hover:bg-white p-7 rounded-3xl border border-slate-200/70 hover:border-blue-300 hover:shadow-xl transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl shadow-xs group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-base">Satu Struk Terpadu</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Beli banyak barang berbeda sekaligus (makanan, pensil, fotokopi) dalam 1 kali checkout dengan 1 kode unik pengambilan.
                    </p>
                </div>

                <!-- Fitur 2 -->
                <div class="bg-slate-50/80 hover:bg-white p-7 rounded-3xl border border-slate-200/70 hover:border-indigo-300 hover:shadow-xl transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl shadow-xs group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-base">Pesan Cepat Dari Kelas</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pesan kebutuhanmu dari smartphone sebelum jam istirahat tiba, sehingga waktu istirahatmu tidak habis untuk mengantre.
                    </p>
                </div>

                <!-- Fitur 3 -->
                <div class="bg-slate-50/80 hover:bg-white p-7 rounded-3xl border border-slate-200/70 hover:border-emerald-300 hover:shadow-xl transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shadow-xs group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-base">Harga & Stok Transparan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Informasi stok barang fisik dan ketersediaan layanan diperbarui secara *real-time* dan sesuai standar resmi koperasi.
                    </p>
                </div>

                <!-- Fitur 4 -->
                <div class="bg-slate-50/80 hover:bg-white p-7 rounded-3xl border border-slate-200/70 hover:border-amber-300 hover:shadow-xl transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl shadow-xs group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-base">Ramah Smartphone</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Aplikasi berbasis web yang ringan, cepat dimuat, dan nyaman diakses langsung dari peramban HP tanpa instalasi rumit.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- Kategori Produk Section -->
    <section id="kategori" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full border border-blue-200/70">
                    Katalog Lengkap
                </span>
                <h3 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Semua Kebutuhan Sekolah Ada di Sini
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Mulai dari asupan energi hingga kelengkapan tugas harian, semua siap diambil di koperasi.
                </p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                
                <div class="bg-white p-5 rounded-3xl border border-slate-200/70 shadow-xs text-center space-y-2 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl mx-auto">
                        <i class="fa-solid fa-utensils"></i>
                    </div>
                    <span class="font-extrabold text-xs text-slate-800 block">Makanan & Minuman</span>
                </div>

                <div class="bg-white p-5 rounded-3xl border border-slate-200/70 shadow-xs text-center space-y-2 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-500 flex items-center justify-center text-xl mx-auto">
                        <i class="fa-solid fa-pen-ruler"></i>
                    </div>
                    <span class="font-extrabold text-xs text-slate-800 block">Alat Tulis Belajar</span>
                </div>

                <div class="bg-white p-5 rounded-3xl border border-slate-200/70 shadow-xs text-center space-y-2 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl mx-auto">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="font-extrabold text-xs text-slate-800 block">Atribut Seragam</span>
                </div>

                <div class="bg-white p-5 rounded-3xl border border-slate-200/70 shadow-xs text-center space-y-2 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-500 flex items-center justify-center text-xl mx-auto">
                        <i class="fa-solid fa-print"></i>
                    </div>
                    <span class="font-extrabold text-xs text-slate-800 block">Fotokopi & Print</span>
                </div>

                <div class="bg-white p-5 rounded-3xl border border-slate-200/70 shadow-xs text-center space-y-2 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-500 flex items-center justify-center text-xl mx-auto">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <span class="font-extrabold text-xs text-slate-800 block">Pulsa & Paket Data</span>
                </div>

                <div class="bg-white p-5 rounded-3xl border border-slate-200/70 shadow-xs text-center space-y-2 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl mx-auto">
                        <i class="fa-solid fa-pills"></i>
                    </div>
                    <span class="font-extrabold text-xs text-slate-800 block">Obat & Kebersihan</span>
                </div>

            </div>

        </div>
    </section>

    <!-- Cara Kerja Section -->
    <section id="cara-kerja" class="py-20 bg-white border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-14">
            
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full border border-blue-200/70">
                    Alur Praktis
                </span>
                <h3 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    3 Langkah Mudah Belanja di Koperasi Skanic
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Hanya butuh beberapa detik untuk memesan semua kebutuhan sekolahmu.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                
                <!-- Langkah 1 -->
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200/70 text-center space-y-4 relative">
                    <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white font-black text-xl flex items-center justify-center mx-auto shadow-lg shadow-blue-500/25">
                        1
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-base">Masuk ke Sistem</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Buka halaman login menggunakan akun siswa atau petugas koperasi yang telah terdaftar.
                    </p>
                </div>

                <!-- Langkah 2 -->
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200/70 text-center space-y-4 relative">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white font-black text-xl flex items-center justify-center mx-auto shadow-lg shadow-indigo-500/25">
                        2
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-base">Pilih Barang & Checkout</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pilih produk apa saja yang kamu inginkan, masukkan ke keranjang belanja, lalu klik checkout untuk menerbitkan 1 kode unik.
                    </p>
                </div>

                <!-- Langkah 3 -->
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200/70 text-center space-y-4 relative">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white font-black text-xl flex items-center justify-center mx-auto shadow-lg shadow-emerald-500/25">
                        3
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-base">Tunjukkan Struk di Kasir</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Saat jam istirahat, datang langsung ke kasir koperasi dan perlihatkan kode / struk digitalmu untuk mengambil seluruh pesanan.
                    </p>
                </div>

            </div>

            <!-- CTA Callout Box -->
            <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-900 rounded-3xl p-8 sm:p-12 text-white shadow-2xl relative overflow-hidden flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center sm:text-left relative z-10 max-w-xl">
                    <h4 class="text-xl sm:text-3xl font-black tracking-tight">Siap Belanja Tanpa Antre Hari Ini?</h4>
                    <p class="text-blue-100 text-xs sm:text-sm">
                        Masuk sekarang dan nikmati kemudahan memesan semua keperluan sekolahmu dalam 1 struk ringkas.
                    </p>
                </div>
                <div class="relative z-10 flex-shrink-0">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-white hover:bg-blue-50 text-blue-700 font-black rounded-2xl text-xs sm:text-sm shadow-xl transition active:scale-95 flex items-center gap-2">
                        <span>Masuk ke Akun Saya</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 text-xs border-t border-slate-800 py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div>
                        <span class="font-bold text-white text-sm block">Koperasi Skanic</span>
                        <span class="text-[11px] text-slate-500">SMK Negeri 1 Ciomas</span>
                    </div>
                </div>

                <div class="flex items-center gap-6 font-medium">
                    <a href="#beranda" class="hover:text-white transition">Beranda</a>
                    <a href="#keunggulan" class="hover:text-white transition">Keunggulan</a>
                    <a href="#kategori" class="hover:text-white transition">Katalog</a>
                    <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-bold transition">Login Sistem</a>
                </div>

            </div>

            <div class="pt-6 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-500">
                <p>&copy; 2026 Koperasi Skanic. Dikembangkan untuk efisiensi sekolah digital.</p>
                <p>Jam Layanan: Senin - Jumat (07.00 - 15.30 WIB)</p>
            </div>
        </div>
    </footer>

</body>
</html>
