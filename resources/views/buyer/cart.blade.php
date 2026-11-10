@extends('layouts.app')

@section('page-title', 'Keranjang Belanja')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- Notifikasi Pesan Sukses / Error -->
    @if(session('success'))
        <div class="p-4 sm:p-5 bg-emerald-50/90 border border-emerald-200/80 text-emerald-800 rounded-3xl flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 text-lg">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block">Berhasil</span>
                    <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 sm:p-5 bg-rose-50/90 border border-rose-200/80 text-rose-800 rounded-3xl flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0 text-lg">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-600 block">Peringatan</span>
                    <span class="text-xs sm:text-sm font-semibold">{{ session('error') }}</span>
                </div>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-600 p-1">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- Header Keranjang & Navigasi -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 sm:p-7 rounded-3xl border border-slate-200/70 shadow-sm">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 mb-1">
                <a href="{{ route('buyer.dashboard') }}" class="hover:underline flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i> Kembali ke Katalog
                </a>
                <span class="text-slate-300">•</span>
                <span class="text-slate-500">Keranjang Belanja Siswa</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="fa-solid fa-cart-shopping text-blue-600"></i>
                <span>Keranjang Pesanan Kamu</span>
            </h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Kumpulkan semua barang & layanan yang kamu perlukan. Saat di-checkout, seluruhnya akan disatukan dalam <strong class="text-slate-800">1 Kode Pengambilan</strong>.
            </p>
        </div>

        @if(!empty($cart))
            <form action="{{ route('buyer.cart.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan seluruh keranjang belanja?');">
                @csrf
                <button type="submit" class="px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 font-bold rounded-2xl text-xs border border-rose-200 transition active:scale-95 flex items-center gap-2 cursor-pointer self-start sm:self-center">
                    <i class="fa-regular fa-trash-can text-xs"></i>
                    <span>Kosongkan Keranjang</span>
                </button>
            </form>
        @endif
    </div>

    @if(empty($cart))
        <!-- State Keranjang Kosong -->
        <div class="bg-white rounded-3xl border border-slate-200/70 p-10 sm:p-16 text-center shadow-sm space-y-5">
            <div class="w-24 h-24 rounded-3xl bg-blue-50 text-blue-500 flex items-center justify-center text-4xl mx-auto shadow-inner">
                <i class="fa-solid fa-cart-arrow-down"></i>
            </div>
            <div class="max-w-md mx-auto space-y-2">
                <h3 class="text-xl font-extrabold text-slate-900">Keranjang Belanja Masih Kosong</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Kamu belum menambahkan barang atau layanan apapun. Yuk pilih makanan, alat tulis, fotokopi, atau pulsa dari katalog koperasi!
                </p>
            </div>
            <div>
                <a href="{{ route('buyer.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl text-xs sm:text-sm shadow-md shadow-blue-500/25 transition active:scale-95">
                    <i class="fa-solid fa-store"></i>
                    <span>Mulai Pilih Barang Sekarang</span>
                </a>
            </div>
        </div>
    @else
        <!-- Grid Keranjang Ada Isinya -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Kolom Kiri: Daftar Barang (8 Kolom) -->
            <div class="lg:col-span-8 space-y-4">
                <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            Daftar Barang & Layanan ({{ count($cart) }} Macam Produk)
                        </span>
                        <span class="text-xs font-extrabold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-100">
                            {{ $totalItems }} Total Unit
                        </span>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach($cart as $id => $item)
                            <div class="p-5 sm:p-6 space-y-4 hover:bg-slate-50/50 transition duration-150">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                    <!-- Informasi Produk -->
                                    <div class="flex-1 space-y-1.5">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold tracking-wide uppercase px-2 py-0.5 rounded-md {{ $item['type'] === 'service' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                                <i class="fa-solid {{ $item['type'] === 'service' ? 'fa-bolt text-[9px]' : 'fa-box text-[9px]' }}"></i>
                                                {{ $item['category_name'] ?? ($item['type'] === 'service' ? 'Layanan' : 'Barang Fisik') }}
                                            </span>

                                            @if($item['type'] === 'physical')
                                                <span class="text-[10px] font-semibold text-slate-400">
                                                    (Tersedia: {{ $item['stock'] }} unit)
                                                </span>
                                            @endif
                                        </div>

                                        <h4 class="font-extrabold text-slate-900 text-base leading-snug">
                                            {{ $item['name'] }}
                                        </h4>

                                        <p class="text-xs font-bold text-blue-600">
                                            Rp {{ number_format($item['price'], 0, ',', '.') }} <span class="font-normal text-slate-400">/ pcs</span>
                                        </p>
                                    </div>

                                    <!-- Subtotal & Tombol Hapus -->
                                    <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-start gap-2 flex-shrink-0">
                                        <div class="text-left sm:text-right">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Subtotal</span>
                                            <span class="font-extrabold text-slate-900 text-base font-mono block">
                                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <form action="{{ route('buyer.cart.remove', $id) }}" method="POST" onsubmit="return confirm('Hapus {{ $item['name'] }} dari keranjang?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus dari keranjang" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer">
                                                <i class="fa-regular fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Form Update Jumlah & Catatan -->
                                <form action="{{ route('buyer.cart.update', $id) }}" method="POST" class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                                    @csrf
                                    <!-- Input Jumlah -->
                                    <div class="flex items-center gap-2">
                                        <label class="text-[11px] font-bold text-slate-500 whitespace-nowrap">Jumlah:</label>
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['type'] === 'physical' ? $item['stock'] : 999 }}"
                                            class="w-16 text-center text-xs font-bold py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
                                    </div>

                                    <!-- Input Catatan (No HP / Akun / Keterangan) -->
                                    <div class="flex-1 flex items-center gap-2">
                                        <div class="relative flex-1">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none text-xs">
                                                <i class="fa-solid fa-pen"></i>
                                            </span>
                                            <input type="text" name="notes" value="{{ $item['notes'] ?? '' }}" 
                                                placeholder="{{ $item['type'] === 'service' ? 'Wajib: No.HP / Akun E-Wallet / Hal fotokopi' : 'Catatan opsional (warna/variasi)...' }}"
                                                class="w-full text-xs py-2 pl-8 pr-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
                                        </div>
                                        <button type="submit" title="Simpan Perubahan" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 font-bold rounded-xl text-xs transition active:scale-95 cursor-pointer whitespace-nowrap">
                                            <i class="fa-solid fa-rotate text-[11px] mr-1"></i> Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <!-- Footer Kartu: Lanjut Belanja -->
                    <div class="p-5 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('buyer.dashboard') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1.5 transition">
                            <i class="fa-solid fa-plus text-[11px]"></i> Tambah Produk Lainnya
                        </a>
                        <span class="text-[11px] text-slate-400">Keranjang otomatis tersimpan di sesi kamu</span>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Ringkasan Checkout (4 Kolom) -->
            <div class="lg:col-span-4 space-y-5">
                <div class="bg-white rounded-3xl border border-slate-200/70 p-6 shadow-sm sticky top-24 space-y-5">
                    
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-lg tracking-tight">Ringkasan Pesanan</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Semua item akan digabung dalam 1 kode checkout</p>
                    </div>

                    <!-- Rincian Biaya -->
                    <div class="space-y-3 pt-3 border-t border-slate-100 text-xs">
                        <div class="flex justify-between items-center text-slate-600">
                            <span>Total Item ({{ $totalItems }} unit)</span>
                            <span class="font-bold font-mono">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-600">
                            <span>Biaya Layanan Koperasi</span>
                            <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">Gratis (Rp 0)</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-600">
                            <span>Metode Pembayaran</span>
                            <span class="font-semibold text-slate-800">Skanic Pay (Digital)</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex justify-between items-baseline">
                            <span class="font-bold text-slate-900 text-sm">TOTAL PEMBAYARAN:</span>
                            <span class="font-extrabold text-blue-700 text-2xl font-mono">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Highlight Info Sistem 1 Kode -->
                    <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50/70 border border-blue-200/60 rounded-2xl space-y-2">
                        <div class="flex items-center gap-2 text-blue-700 font-extrabold text-xs">
                            <i class="fa-solid fa-qrcode text-sm"></i>
                            <span>Satu Kode Untuk Semua Barang</span>
                        </div>
                        <p class="text-[11px] text-blue-900/80 leading-relaxed">
                            Setelah klik tombol Checkout di bawah, sistem langsung menerbitkan <strong>1 Kode Pengambilan unik</strong> (contoh: <code class="font-mono font-bold bg-white px-1.5 py-0.5 rounded text-blue-700">SKN-XXXXX</code>).
                        </p>
                    </div>

                    <!-- Tombol Aksi Checkout (CO) -->
                    <form action="{{ route('buyer.cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                            onclick="return confirm('Konfirmasi Checkout pesanan senilai Rp {{ number_format($total, 0, ',', '.') }}? Kode pengambilan akan langsung diterbitkan.');"
                            class="w-full py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 hover:from-blue-700 hover:to-indigo-800 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-200 active:scale-98 flex items-center justify-center gap-2.5 cursor-pointer">
                            <i class="fa-solid fa-bag-shopping text-base"></i>
                            <span>Checkout Sekarang (Dapatkan Kode)</span>
                        </button>
                    </form>

                    <div class="text-center">
                        <span class="text-[11px] text-slate-400">
                            <i class="fa-solid fa-shield-halved text-emerald-500 mr-1"></i> Transaksi resmi & tersinkronisasi ke kasir koperasi
                        </span>
                    </div>

                </div>
            </div>

        </div>
    @endif

</div>
@endsection
