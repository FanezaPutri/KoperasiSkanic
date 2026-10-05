@extends('layouts.app')

@section('page-title', 'Dashboard Penjaga Koperasi')

@section('content')
<div class="space-y-6">

    <!-- Flash Message -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-2 shadow-sm text-sm">
            <i class="fa-solid fa-circle-check text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 4 Kartu Metrik Ringkasan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-blue-50 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Pemasukan</span>
                <span class="text-2xl font-bold text-slate-800 mt-1 block">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-blue-50 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Estimasi Untung</span>
                <span class="text-2xl font-bold {{ $netProfit < 0 ? 'text-red-500' : 'text-emerald-600' }} mt-1 block">
                    {{ $netProfit < 0 ? '-Rp ' . number_format(abs($netProfit), 0, ',', '.') : 'Rp ' . number_format($netProfit, 0, ',', '.') }}
                </span>
            </div>
            <div class="w-12 h-12 {{ $netProfit < 0 ? 'bg-red-50 text-red-500' : 'bg-emerald-50 text-emerald-600' }} rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-blue-50 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Perlu Diambil</span>
                <span class="text-2xl font-bold text-amber-500 mt-1 block">{{ $pendingCount }} Pesanan</span>
            </div>
            <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-blue-50 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Stok Menipis (&lt;=5)</span>
                <span class="text-2xl font-bold text-red-500 mt-1 block">{{ $lowStockCount }} Item</span>
            </div>
            <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-box-open"></i>
            </div>
        </div>
    </div>

    <!-- Tabel 1: Pesanan Masuk (Perlu Diserahkan 1-Klik) -->
    <div class="bg-white rounded-2xl border border-blue-50 shadow-sm p-6">
        <div class="mb-4">
            <h3 class="text-base font-bold text-slate-800">Pesanan Masuk (Perlu Diserahkan)</h3>
            <p class="text-xs text-slate-500">Klik "Selesai" saat siswa mengambil barang di koperasi.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-xs text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-3">Kode / Waktu</th>
                        <th class="py-3 px-3">Pembeli</th>
                        <th class="py-3 px-3">Detail Barang</th>
                        <th class="py-3 px-3">Total</th>
                        <th class="py-3 px-3">Status</th>
                        <th class="py-3 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendingOrders as $order)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-3">
                                <span class="font-bold text-blue-900 block">{{ $order->order_code }}</span>
                                <span class="text-[11px] text-slate-400">{{ $order->created_at->format('H:i, d M') }}</span>
                            </td>
                            <td class="py-3.5 px-3 font-medium text-slate-700">{{ $order->user->name }}</td>
                            <td class="py-3.5 px-3 text-xs text-slate-600">
                                @foreach($order->items as $item)
                                    <div>&bull; {{ $item->product->name ?? 'Barang Terhapus' }} (x{{ $item->quantity }})
                                        @if($item->notes)
                                            <span class="text-blue-600 italic">[{{ $item->notes }}]</span>
                                        @endif
                                    </div>
                                @endforeach
                            </td>
                            <td class="py-3.5 px-3 font-bold text-slate-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3.5 px-3">
                                <span class="text-xs px-2.5 py-1 bg-amber-50 text-amber-600 rounded-full font-semibold border border-amber-200">
                                    Menunggu
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-right">
                                <form action="{{ route('admin.order.complete', $order->id) }}" method="POST" onsubmit="return confirm('Serahkan pesanan ini?')">
                                    @csrf
                                    <button type="submit" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-sm transition inline-flex items-center gap-1">
                                        <i class="fa-solid fa-check"></i> Selesai
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-slate-400 text-xs">
                                <i class="fa-solid fa-circle-check text-2xl text-emerald-400 mb-1 block"></i>
                                Semua pesanan sudah diserahkan ke pembeli.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel 2: Riwayat Pesanan (Ditaruh di Bawah Dashboard) -->
    <div class="bg-white rounded-2xl border border-blue-50 shadow-sm p-6">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-800">Riwayat Pesanan Terakhir</h3>
                <p class="text-xs text-slate-500">Catatan transaksi yang sudah selesai maupun dibatalkan</p>
            </div>
            <span class="text-xs text-slate-400 font-medium">10 Transaksi Terakhir</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-xs text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-3">Kode / Waktu</th>
                        <th class="py-3 px-3">Pembeli</th>
                        <th class="py-3 px-3">Detail Barang</th>
                        <th class="py-3 px-3">Total</th>
                        <th class="py-3 px-3">Status</th>
                        <th class="py-3 px-3 text-right">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($historyOrders as $history)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-3">
                                <span class="font-bold text-slate-700 block">{{ $history->order_code }}</span>
                                <span class="text-[11px] text-slate-400">{{ $history->created_at->format('H:i, d M') }}</span>
                            </td>
                            <td class="py-3 px-3 text-slate-700">{{ $history->user->name }}</td>
                            <td class="py-3 px-3 text-xs text-slate-500">
                                @foreach($history->items as $item)
                                    <div>&bull; {{ $item->product->name ?? 'Barang Terhapus' }} (x{{ $item->quantity }})</div>
                                @endforeach
                            </td>
                            <td class="py-3 px-3 font-semibold text-slate-800">Rp {{ number_format($history->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-3">
                                @if($history->order_status === 'completed')
                                    <span class="text-xs px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full font-semibold border border-emerald-200">
                                        Selesai
                                    </span>
                                @else
                                    <span class="text-xs px-2.5 py-1 bg-red-50 text-red-600 rounded-full font-semibold border border-red-200">
                                        Dibatalkan
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3 text-right text-xs text-slate-400 italic">
                                {{ $history->order_status === 'completed' ? 'Sudah diserahkan' : 'Dibatalkan siswa' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-slate-400 text-xs">Belum ada riwayat transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection