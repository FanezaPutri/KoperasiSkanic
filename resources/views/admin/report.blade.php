@extends('layouts.app')

@section('page-title', 'Laporan Keuangan & Laba Rugi')

@section('content')
<div class="space-y-8">

    <!-- Header & Tombol Cetak -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/70 shadow-sm no-print">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-[11px] font-bold mb-2">
                <i class="fa-solid fa-chart-line"></i> Pembukuan Resmi
            </div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Rekap Pembukuan Koperasi Skanic</h2>
            <p class="text-xs text-slate-500 mt-0.5">Laporan omset masuk, kalkulasi harga pokok modal, dan laba bersih otomatis</p>
        </div>
        <button onclick="window.print()" class="px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-2xl text-xs sm:text-sm font-bold shadow-lg shadow-blue-500/25 transition-all duration-150 active:scale-95 flex items-center justify-center gap-2 cursor-pointer self-start sm:self-center">
            <i class="fa-solid fa-print"></i> 
            <span>Cetak / Simpan PDF</span>
        </button>
    </div>

    <!-- Filter Periode (Sembunyi saat cetak) -->
    <div class="flex flex-wrap items-center gap-2 no-print p-1.5 bg-slate-200/60 rounded-2xl w-fit text-xs font-semibold">
        <span class="text-slate-500 font-bold px-2.5 py-1 text-[11px] uppercase tracking-wider">Periode:</span>
        <a href="{{ route('admin.report', ['period' => 'all']) }}" 
           class="px-4 py-2 rounded-xl transition-all duration-150 {{ ($period ?? 'all') === 'all' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900' }}">
            Semua Waktu
        </a>
        <a href="{{ route('admin.report', ['period' => 'today']) }}" 
           class="px-4 py-2 rounded-xl transition-all duration-150 {{ ($period ?? '') === 'today' ? 'bg-blue-600 text-white shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900' }}">
            Hari Ini
        </a>
        <a href="{{ route('admin.report', ['period' => 'week']) }}" 
           class="px-4 py-2 rounded-xl transition-all duration-150 {{ ($period ?? '') === 'week' ? 'bg-blue-600 text-white shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900' }}">
            Minggu Ini
        </a>
        <a href="{{ route('admin.report', ['period' => 'month']) }}" 
           class="px-4 py-2 rounded-xl transition-all duration-150 {{ ($period ?? '') === 'month' ? 'bg-blue-600 text-white shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900' }}">
            Bulan Ini
        </a>
    </div>

    <!-- Ringkasan Kartu Finansial -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
        
        <!-- Total Pendapatan -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/70 shadow-sm print:border print:border-slate-300 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Omset Penjualan</span>
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-base shadow-xs print:hidden">
                    <i class="fa-solid fa-coins"></i>
                </div>
            </div>
            <div>
                <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight block">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </span>
                <span class="text-xs text-slate-400 mt-1 block">Akumulasi seluruh transaksi selesai</span>
            </div>
        </div>

        <!-- Total Modal -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/70 shadow-sm print:border print:border-slate-300 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Biaya Modal (HPP)</span>
                <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-600 flex items-center justify-center text-base shadow-xs print:hidden">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
            <div>
                <span class="text-2xl sm:text-3xl font-extrabold text-slate-700 tracking-tight block">
                    Rp {{ number_format($totalCost, 0, ',', '.') }}
                </span>
                <span class="text-xs text-slate-400 mt-1 block">Harga pokok barang yang terjual</span>
            </div>
        </div>

        <!-- Keuntungan Bersih -->
        <div class="bg-white p-6 rounded-3xl border {{ $netProfit < 0 ? 'border-rose-200 bg-rose-50/20' : 'border-emerald-200 bg-emerald-50/20' }} shadow-sm print:border print:border-slate-300 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold {{ $netProfit < 0 ? 'text-rose-600' : 'text-emerald-700' }} uppercase tracking-wider">
                    {{ $netProfit < 0 ? 'Kerugian Bersih' : 'Keuntungan Bersih (Laba)' }}
                </span>
                <div class="w-10 h-10 rounded-2xl {{ $netProfit < 0 ? 'bg-rose-100 text-rose-600' : 'bg-emerald-100 text-emerald-600' }} flex items-center justify-center text-base shadow-xs print:hidden">
                    <i class="fa-solid {{ $netProfit < 0 ? 'fa-arrow-trend-down' : 'fa-arrow-trend-up' }}"></i>
                </div>
            </div>
            <div>
                <span class="text-2xl sm:text-3xl font-extrabold {{ $netProfit < 0 ? 'text-rose-600' : 'text-emerald-600' }} tracking-tight block">
                    {{ $netProfit < 0 ? '-Rp ' . number_format(abs($netProfit), 0, ',', '.') : '+Rp ' . number_format($netProfit, 0, ',', '.') }}
                </span>
                <span class="text-xs {{ $netProfit < 0 ? 'text-rose-500' : 'text-emerald-600' }} mt-1 block font-medium">
                    {{ $netProfit < 0 ? 'Pengeluaran modal melebihi pendapatan' : 'Hasil bersih pendapatan setelah modal' }}
                </span>
            </div>
        </div>

    </div>

    <!-- Tabel Rincian Transaksi Selesai -->
    <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm p-6 sm:p-8 print:border print:border-slate-400 print:shadow-none print:p-0">
        
        <!-- Header Dokumen Cetak -->
        <div class="hidden print:block mb-6 text-center border-b-2 border-slate-800 pb-4">
            <h1 class="text-xl font-bold tracking-tight">KOPERASI SKANIC - SMK NEGERI 1</h1>
            <p class="text-xs text-slate-600">Laporan Resmi Pembukuan Transaksi & Rekap Keuntungan</p>
            <p class="text-[10px] text-slate-400 mt-1">Dicetak pada: {{ date('d F Y, H:i') }}</p>
        </div>

        <div class="flex items-center justify-between mb-5 print:hidden">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 tracking-tight">Rincian Buku Kas Transaksi Selesai</h3>
                <p class="text-xs text-slate-500 mt-0.5">Detail setiap transaksi beserta kalkulasi margin keuntungan</p>
            </div>
            <span class="text-xs font-semibold px-3 py-1 bg-slate-100 text-slate-600 rounded-full">
                {{ $completedOrders->count() }} Transaksi
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/60 text-[11px] text-slate-500 uppercase tracking-wider print:bg-slate-100">
                        <th class="py-3.5 px-4 font-bold">Kode Order</th>
                        <th class="py-3.5 px-4 font-bold">Waktu</th>
                        <th class="py-3.5 px-4 font-bold">Nama Pembeli</th>
                        <th class="py-3.5 px-4 font-bold">Rincian Komoditas</th>
                        <th class="py-3.5 px-4 font-bold">Total Nilai</th>
                        <th class="py-3.5 px-4 font-bold text-right">Laba Transaksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-normal">
                    @forelse($completedOrders as $order)
                        @php
                            $orderCost = 0;
                            foreach($order->items as $it) {
                                $orderCost += ($it->cost_price * $it->quantity);
                            }
                            $orderProfit = $order->total_amount - $orderCost;
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition duration-150">
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-200/60 inline-block print:bg-transparent print:border-none print:p-0">
                                    {{ $order->order_code }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs text-slate-500">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-medium text-slate-800">
                                {{ $order->user->name }}
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-600">
                                <div class="space-y-0.5">
                                    @foreach($order->items as $item)
                                        <div>&bull; {{ $item->product->name }} (x{{ $item->quantity }})</div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-bold text-slate-900">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-right font-extrabold {{ $orderProfit < 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                @if($orderProfit < 0)
                                    -Rp {{ number_format(abs($orderProfit), 0, ',', '.') }}
                                @else
                                    +Rp {{ number_format($orderProfit, 0, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400">
                                <p class="text-sm font-semibold text-slate-700">Belum ada transaksi berstatus selesai</p>
                                <p class="text-xs text-slate-400 mt-0.5">Transaksi yang diselesaikan akan otomatis tercatat di pembukuan ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
@media print {
    #sidebar-wrapper, header, .no-print, #sidebar-overlay {
        display: none !important;
    }
    body, main {
        background: white !important;
        padding: 0 !important;
        overflow: visible !important;
    }
    aside {
        display: none !important;
    }
}
</style>
@endsection