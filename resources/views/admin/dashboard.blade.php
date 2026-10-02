@extends('layouts.app')

@section('page-title', 'Dashboard Penjaga Koperasi')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-2 shadow-sm text-sm">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Kartu Statistik (Pemasukan, Laba, Pesanan, Stok Menipis) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-blue-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pemasukan</p>
                <h3 class="text-xl font-bold text-slate-800 mt-1">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-blue-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Estimasi Untung</p>
                <h3 class="text-xl font-bold text-emerald-600 mt-1">Rp {{ number_format($netProfit, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-blue-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Perlu Diambil</p>
                <h3 class="text-xl font-bold text-amber-500 mt-1">{{ $pendingOrdersCount }} Pesanan</h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-blue-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Stok Menipis (<=5)</p>
                <h3 class="text-xl font-bold text-red-500 mt-1">{{ $lowStockCount }} Item</h3>
            </div>
            <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-box-open"></i>
            </div>
        </div>
    </div>

    <!-- Tabel Pesanan Masuk (Fitur Klik Selesai) -->
    <div class="bg-white rounded-2xl border border-blue-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Pesanan Pembeli Terbaru</h3>
                <p class="text-xs text-slate-400">Tinggal klik "Selesai" saat pembeli mengambil barang di koperasi</p>
            </div>
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
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-3 font-semibold text-blue-900">
                                {{ $order->order_code }}
                                <div class="text-[11px] font-normal text-slate-400">{{ $order->created_at->format('H:i, d M') }}</div>
                            </td>
                            <td class="py-3 px-3 font-medium text-slate-700">{{ $order->user->name }}</td>
                            <td class="py-3 px-3 text-xs text-slate-600">
                                @foreach($order->items as $item)
                                    <div>&bull; {{ $item->product->name }} (x{{ $item->quantity }})
                                        @if($item->notes)
                                            <span class="text-blue-600 italic">[{{ $item->notes }}]</span>
                                        @endif
                                    </div>
                                @endforeach
                            </td>
                            <td class="py-3 px-3 font-bold text-slate-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-3">
                                @if($order->order_status === 'pending')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Siap Diambil</span>
                                @elseif($order->order_status === 'completed')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Selesai</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">Batal</span>
                                @endif
                            </td>
                            <td class="py-3 px-3 text-right">
                                @if($order->order_status === 'pending')
                                    <form action="{{ route('admin.order.complete', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                                            <i class="fa-solid fa-check mr-1"></i> Klik Selesai
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400 italic">Sudah diserahkan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-400 text-xs">Belum ada pesanan masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection