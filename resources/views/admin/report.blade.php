@extends('layouts.app')

@section('page-title', 'Laporan Keuangan & Laba Rugi')

@section('content')
<div class="space-y-6">

    <!-- Header & Tombol Cetak -->
    <div class="flex items-center justify-between no-print">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Rekap Pembukuan Koperasi Skanic</h2>
            <p class="text-xs text-slate-500">Laporan pemasukan dan kalkulasi laba bersih otomatis</p>
        </div>
        <button onclick="window.print()" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-xl text-xs font-semibold shadow-md shadow-blue-500/20 transition flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
        </button>
    </div>

    <!-- Filter Periode (Sembunyi saat cetak) -->
    <div class="flex items-center gap-2 no-print text-xs">
        <span class="text-slate-400 font-semibold mr-1">Filter Waktu:</span>
        <a href="{{ route('admin.report', ['period' => 'all']) }}" 
           class="px-3 py-1.5 rounded-xl border transition {{ ($period ?? 'all') === 'all' ? 'bg-blue-700 text-white border-blue-700' : 'bg-white text-slate-600 border-slate-200' }}">
            Semua
        </a>
        <a href="{{ route('admin.report', ['period' => 'today']) }}" 
           class="px-3 py-1.5 rounded-xl border transition {{ ($period ?? '') === 'today' ? 'bg-blue-700 text-white border-blue-700' : 'bg-white text-slate-600 border-slate-200' }}">
            Hari Ini
        </a>
        <a href="{{ route('admin.report', ['period' => 'week']) }}" 
           class="px-3 py-1.5 rounded-xl border transition {{ ($period ?? '') === 'week' ? 'bg-blue-700 text-white border-blue-700' : 'bg-white text-slate-600 border-slate-200' }}">
            Minggu Ini
        </a>
        <a href="{{ route('admin.report', ['period' => 'month']) }}" 
           class="px-3 py-1.5 rounded-xl border transition {{ ($period ?? '') === 'month' ? 'bg-blue-700 text-white border-blue-700' : 'bg-white text-slate-600 border-slate-200' }}">
            Bulan Ini
        </a>
    </div>

    <!-- Ringkasan Kartu -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-blue-100 shadow-sm print:border print:border-slate-300">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Pendapatan (Omset)</span>
            <span class="text-2xl font-bold text-blue-900 mt-2 block">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            <span class="text-xs text-slate-500 mt-1 block">Dari transaksi selesai</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-blue-100 shadow-sm print:border print:border-slate-300">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Biaya Modal</span>
            <span class="text-2xl font-bold text-slate-700 mt-2 block">Rp {{ number_format($totalCost, 0, ',', '.') }}</span>
            <span class="text-xs text-slate-500 mt-1 block">Harga pokok barang terjual</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border {{ $netProfit < 0 ? 'border-red-200' : 'border-emerald-100' }} shadow-sm print:border print:border-slate-300">
            <span class="text-xs font-semibold {{ $netProfit < 0 ? 'text-red-500' : 'text-emerald-600' }} uppercase tracking-wider block">
                {{ $netProfit < 0 ? 'Kerugian Bersih (Rugi)' : 'Keuntungan Bersih (Laba)' }}
            </span>
            <span class="text-2xl font-bold {{ $netProfit < 0 ? 'text-red-600' : 'text-emerald-600' }} mt-2 block">
                {{ $netProfit < 0 ? '-Rp ' . number_format(abs($netProfit), 0, ',', '.') : 'Rp ' . number_format($netProfit, 0, ',', '.') }}
            </span>
            <span class="text-xs {{ $netProfit < 0 ? 'text-red-400' : 'text-emerald-700' }} mt-1 block">
                {{ $netProfit < 0 ? 'Pengeluaran modal melebihi pemasukan' : 'Pendapatan dikurangi modal' }}
            </span>
        </div>
    </div>

    <!-- Tabel Rincian Transaksi Selesai -->
    <div class="bg-white rounded-2xl border border-blue-100 shadow-sm p-6 print:border print:border-slate-300 print:shadow-none">
        <div class="hidden print:block mb-4 text-center border-b pb-3">
            <h1 class="text-xl font-bold">KOPERASI SKANIC</h1>
            <p class="text-xs text-slate-500">Laporan Resmi Transaksi & Rekap Kas</p>
        </div>

        <h3 class="text-base font-bold text-slate-800 mb-4 print:hidden">Rincian Transaksi Selesai</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wider">
                        <th class="py-2.5 px-3">Kode Order</th>
                        <th class="py-2.5 px-3">Waktu</th>
                        <th class="py-2.5 px-3">Pembeli</th>
                        <th class="py-2.5 px-3">Barang Dipesan</th>
                        <th class="py-2.5 px-3">Pemasukan</th>
                        <th class="py-2.5 px-3">Estimasi Laba</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($completedOrders as $order)
                        @php
                            $orderCost = 0;
                            foreach($order->items as $it) {
                                $orderCost += ($it->cost_price * $it->quantity);
                            }
                            $orderProfit = $order->total_amount - $orderCost;
                        @endphp
                        <tr>
                            <td class="py-2.5 px-3 font-semibold text-blue-900">{{ $order->order_code }}</td>
                            <td class="py-2.5 px-3 text-xs text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-2.5 px-3 font-medium text-slate-700">{{ $order->user->name }}</td>
                            <td class="py-2.5 px-3 text-xs text-slate-600">
                                @foreach($order->items as $item)
                                    <div>&bull; {{ $item->product->name }} (x{{ $item->quantity }})</div>
                                @endforeach
                            </td>
                            <td class="py-2.5 px-3 font-semibold text-slate-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="py-2.5 px-3 font-bold {{ $orderProfit < 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                @if($orderProfit < 0)
                                    -Rp {{ number_format(abs($orderProfit), 0, ',', '.') }}
                                @else
                                    +Rp {{ number_format($orderProfit, 0, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-400 text-xs">Belum ada transaksi yang berstatus selesai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
@media print {
    #sidebar-wrapper, header, .no-print {
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