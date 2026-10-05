@extends('layouts.app')

@section('page-title', 'Riwayat Semua Pesanan')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Seluruh Pesanan Masuk</h2>
            <p class="text-xs text-slate-500">Pantau seluruh status booking dari siswa secara lengkap</p>
        </div>

        <!-- Pencarian Cepat Kode Order / Nama Siswa -->
        <form action="{{ route('admin.orders.history') }}" method="GET" class="flex items-center gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari Kode / Siswa..." 
                    class="w-56 pl-8 pr-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
            <button type="submit" class="px-3 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-xl text-xs font-semibold transition">
                Cari
            </button>
            @if($search)
                <a href="{{ route('admin.orders.history', ['status' => $status]) }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Filter Tab Status -->
    <div class="flex items-center gap-2 text-xs">
        <a href="{{ route('admin.orders.history', ['status' => 'all', 'search' => $search]) }}" 
           class="px-3.5 py-1.5 rounded-xl border transition {{ $status === 'all' ? 'bg-blue-700 text-white border-blue-700 font-medium' : 'bg-white text-slate-600 border-slate-200' }}">
            Semua Pesanan
        </a>
        <a href="{{ route('admin.orders.history', ['status' => 'pending', 'search' => $search]) }}" 
           class="px-3.5 py-1.5 rounded-xl border transition {{ $status === 'pending' ? 'bg-amber-500 text-white border-amber-500 font-medium' : 'bg-white text-slate-600 border-slate-200' }}">
            Menunggu Diambil
        </a>
        <a href="{{ route('admin.orders.history', ['status' => 'completed', 'search' => $search]) }}" 
           class="px-3.5 py-1.5 rounded-xl border transition {{ $status === 'completed' ? 'bg-emerald-600 text-white border-emerald-600 font-medium' : 'bg-white text-slate-600 border-slate-200' }}">
            Sudah Selesai
        </a>
    </div>

    <!-- Tabel Riwayat Pesanan -->
    <div class="bg-white rounded-2xl border border-blue-50 shadow-sm p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-xs text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-3">Kode Order</th>
                        <th class="py-3 px-3">Waktu Transaksi</th>
                        <th class="py-3 px-3">Nama Pembeli</th>
                        <th class="py-3 px-3">Rincian Item</th>
                        <th class="py-3 px-3">Total Biaya</th>
                        <th class="py-3 px-3">Status</th>
                        <th class="py-3 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-3 font-bold text-blue-900">{{ $order->order_code }}</td>
                            <td class="py-3.5 px-3 text-xs text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="py-3.5 px-3 font-medium text-slate-800">{{ $order->user->name }}</td>
                            <td class="py-3.5 px-3 text-xs text-slate-600">
                                @foreach($order->items as $item)
                                    <div>&bull; {{ $item->product->name }} (x{{ $item->quantity }})
                                        @if($item->notes)
                                            <span class="text-blue-600 italic">[{{ $item->notes }}]</span>
                                        @endif
                                    </div>
                                @endforeach
                            </td>
                            <td class="py-3.5 px-3 font-semibold text-slate-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3.5 px-3">
                                @if($order->order_status === 'pending')
                                    <span class="text-xs px-2.5 py-1 bg-amber-50 text-amber-600 rounded-full font-semibold border border-amber-200">
                                        Menunggu
                                    </span>
                                @else
                                    <span class="text-xs px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full font-semibold border border-emerald-200">
                                        Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-3 text-right whitespace-nowrap">
                                @if($order->order_status === 'pending')
                                    <form action="{{ route('admin.order.complete', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Serahkan barang ini ke siswa?')" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-sm transition inline-flex items-center gap-1">
                                            <i class="fa-solid fa-check"></i> Selesai
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400 italic">Tuntas</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-400 text-xs">Tidak ditemukan riwayat pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>

</div>
@endsection