@extends('layouts.app')

@section('page-title', 'Dashboard Penjaga Koperasi')

@section('content')
<div class="space-y-8">

    <!-- Flash Message Sukses -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50/90 border border-emerald-200/80 text-emerald-800 rounded-2xl flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-circle-check text-base"></i>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block">Berhasil</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- Welcome Greeting Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-slate-900 via-indigo-950 to-blue-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 space-y-1">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[11px] font-semibold text-blue-200 border border-white/10 mb-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Sistem Operasional Aktif</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight">Ringkasan Aktivitas Koperasi</h2>
            <p class="text-slate-300 text-xs sm:text-sm max-w-xl">
                Pantau antrean pengambilan barang oleh siswa, pantau stok menipis, serta kalkulasi pendapatan secara real-time.
            </p>
        </div>
        <div class="relative z-10 flex items-center gap-2 self-start sm:self-center">
            <a href="{{ route('admin.orders.history') }}" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-semibold backdrop-blur-md border border-white/15 transition flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-xs"></i>
                <span>Semua Riwayat</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-semibold shadow-lg shadow-blue-500/30 transition flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Kelola Barang</span>
            </a>
        </div>
    </div>

    <!-- 4 Kartu Metrik Ringkasan Modern -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        <!-- Total Pemasukan -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/70 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pemasukan</span>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 group-hover:bg-blue-600 text-blue-600 group-hover:text-white flex items-center justify-center text-lg transition-colors duration-200 shadow-xs">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
            <div>
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight block">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </span>
                <span class="text-[11px] font-medium text-slate-400 mt-1 block flex items-center gap-1">
                    <i class="fa-solid fa-circle-check text-blue-500 text-[10px]"></i> Transaksi terselesaikan
                </span>
            </div>
        </div>

        <!-- Estimasi Untung -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/70 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Estimasi Laba Bersih</span>
                <div class="w-12 h-12 rounded-2xl {{ $netProfit < 0 ? 'bg-rose-50 text-rose-600 group-hover:bg-rose-600' : 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600' }} group-hover:text-white flex items-center justify-center text-lg transition-colors duration-200 shadow-xs">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
            <div>
                <span class="text-2xl font-extrabold {{ $netProfit < 0 ? 'text-rose-600' : 'text-emerald-600' }} tracking-tight block">
                    {{ $netProfit < 0 ? '-Rp ' . number_format(abs($netProfit), 0, ',', '.') : 'Rp ' . number_format($netProfit, 0, ',', '.') }}
                </span>
                <span class="text-[11px] font-medium text-slate-400 mt-1 block flex items-center gap-1">
                    <i class="fa-solid fa-calculator text-[10px] {{ $netProfit < 0 ? 'text-rose-500' : 'text-emerald-500' }}"></i> 
                    Pendapatan minus modal
                </span>
            </div>
        </div>

        <!-- Perlu Diambil -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/70 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Perlu Diserahkan</span>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 group-hover:bg-amber-500 text-amber-500 group-hover:text-white flex items-center justify-center text-lg transition-colors duration-200 shadow-xs">
                    <i class="fa-solid fa-bell"></i>
                </div>
            </div>
            <div>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-extrabold text-amber-600 tracking-tight">{{ $pendingCount }}</span>
                    <span class="text-xs font-bold text-slate-500">Pesanan</span>
                </div>
                <span class="text-[11px] font-medium text-slate-400 mt-1 block flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full {{ $pendingCount > 0 ? 'bg-amber-400 animate-ping' : 'bg-slate-300' }}"></span> 
                    Siswa menunggu di koperasi
                </span>
            </div>
        </div>

        <!-- Stok Menipis -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/70 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Stok Kritis (&le; 5)</span>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 group-hover:bg-rose-600 text-rose-600 group-hover:text-white flex items-center justify-center text-lg transition-colors duration-200 shadow-xs">
                    <i class="fa-solid fa-boxes-packing"></i>
                </div>
            </div>
            <div>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-extrabold {{ $lowStockCount > 0 ? 'text-rose-600' : 'text-slate-800' }} tracking-tight">
                        {{ $lowStockCount }}
                    </span>
                    <span class="text-xs font-bold text-slate-500">Barang</span>
                </div>
                <span class="text-[11px] font-medium text-slate-400 mt-1 block flex items-center gap-1">
                    <i class="fa-solid fa-triangle-exclamation text-[10px] text-rose-500"></i> Perlu segera restock
                </span>
            </div>
        </div>

    </div>

    <!-- Tabel 1: Pesanan Masuk (Perlu Diserahkan 1-Klik) -->
    <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gradient-to-r from-amber-50/50 to-transparent">
            <div>
                <div class="flex items-center gap-2.5">
                    <div class="w-3 h-3 rounded-full bg-amber-500 animate-pulse"></div>
                    <h3 class="text-base font-bold text-slate-900">Pesanan Masuk (Menunggu Diambil)</h3>
                    @if($pendingOrders->count() > 0)
                        <span class="px-2.5 py-0.5 bg-amber-100 text-amber-800 text-xs font-extrabold rounded-full">
                            {{ $pendingOrders->count() }} Antrean
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 mt-1">Konfirmasi 1-klik saat siswa datang mengambil pesanan di koperasi sekolah.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/60 text-[11px] text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-bold">Kode / Waktu</th>
                        <th class="py-3.5 px-4 font-bold">Pembeli</th>
                        <th class="py-3.5 px-4 font-bold">Detail Barang & Catatan</th>
                        <th class="py-3.5 px-4 font-bold">Total Tagihan</th>
                        <th class="py-3.5 px-4 font-bold">Status</th>
                        <th class="py-3.5 px-4 font-bold text-right">Aksi Penyerahan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-normal">
                    @forelse($pendingOrders as $order)
                        <tr class="hover:bg-slate-50/70 transition duration-150">
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-200/60 inline-block">
                                    {{ $order->order_code }}
                                </span>
                                <span class="text-[11px] text-slate-400 block mt-1">
                                    <i class="fa-regular fa-clock text-[10px] mr-1"></i>{{ $order->created_at->format('H:i, d M') }}
                                </span>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $order->user->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-600">
                                <div class="space-y-1">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            <span class="font-medium text-slate-800">{{ $item->product->name ?? 'Barang Terhapus' }}</span>
                                            <span class="px-1.5 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-bold">x{{ $item->quantity }}</span>
                                            @if($item->notes)
                                                <span class="text-blue-700 bg-blue-50 px-2 py-0.5 rounded text-[10px] font-semibold border border-blue-100">
                                                    {{ $item->notes }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap font-bold text-slate-900">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 text-xs px-3 py-1 bg-amber-50 text-amber-700 rounded-full font-bold border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Menunggu
                                </span>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap text-right">
                                <form action="{{ route('admin.order.complete', $order->id) }}" method="POST" onsubmit="return confirm('Serahkan barang untuk kode {{ $order->order_code }}?')">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl text-xs font-bold shadow-md shadow-emerald-600/25 transition-all duration-150 active:scale-95 inline-flex items-center gap-1.5 cursor-pointer">
                                        <i class="fa-solid fa-circle-check text-xs"></i> 
                                        <span>Selesai</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl mx-auto mb-2">
                                    <i class="fa-solid fa-check-double"></i>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Semua pesanan telah diproses!</p>
                                <p class="text-xs text-slate-400 mt-0.5">Tidak ada antrean pesanan yang menunggu diambil.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel 2: Riwayat Pesanan Terakhir -->
    <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Riwayat Transaksi Terakhir</h3>
                <p class="text-xs text-slate-500 mt-0.5">Log transaksi yang telah diserahkan maupun dibatalkan</p>
            </div>
            <a href="{{ route('admin.orders.history') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1">
                <span>Lihat Semua</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/60 text-[11px] text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-bold">Kode / Waktu</th>
                        <th class="py-3.5 px-4 font-bold">Pembeli</th>
                        <th class="py-3.5 px-4 font-bold">Detail Barang</th>
                        <th class="py-3.5 px-4 font-bold">Total</th>
                        <th class="py-3.5 px-4 font-bold">Status</th>
                        <th class="py-3.5 px-4 font-bold text-right">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($historyOrders as $history)
                        <tr class="hover:bg-slate-50/70 transition duration-150">
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-slate-700 block">{{ $history->order_code }}</span>
                                <span class="text-[11px] text-slate-400 block mt-0.5">{{ $history->created_at->format('H:i, d M') }}</span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-medium text-slate-800">{{ $history->user->name }}</td>
                            <td class="py-3.5 px-4 text-xs text-slate-500">
                                @foreach($history->items as $item)
                                    <div>&bull; {{ $item->product->name ?? 'Barang Terhapus' }} (x{{ $item->quantity }})</div>
                                @endforeach
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-bold text-slate-900">
                                Rp {{ number_format($history->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($history->order_status === 'completed')
                                    <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-full font-bold border border-emerald-200">
                                        <i class="fa-solid fa-check text-[10px]"></i> Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 bg-rose-50 text-rose-700 rounded-full font-bold border border-rose-200">
                                        <i class="fa-solid fa-xmark text-[10px]"></i> Dibatalkan
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-right text-xs text-slate-400 font-medium">
                                {{ $history->order_status === 'completed' ? 'Sudah diserahkan' : 'Dibatalkan siswa' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-400 text-xs font-medium">
                                Belum ada riwayat transaksi tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection