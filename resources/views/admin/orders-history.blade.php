@extends('layouts.app')

@section('page-title', 'Riwayat Semua Pesanan')

@section('content')
<div class="space-y-6">

    <!-- Top Bar with Search & Title -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/70 shadow-sm">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Daftar Seluruh Pesanan Masuk</h2>
            <p class="text-xs text-slate-500 mt-0.5">Pantau status transaksi belanja dan jasa siswa secara lengkap</p>
        </div>

        <!-- Pencarian Cepat Kode Order / Nama Siswa -->
        <form action="{{ route('admin.orders.history') }}" method="GET" class="flex items-center gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari kode / nama siswa..." 
                    class="w-60 pl-9 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-sm transition active:scale-95 cursor-pointer">
                Cari
            </button>
            @if($search)
                <a href="{{ route('admin.orders.history', ['status' => $status]) }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Filter Tab Status Modern -->
    <div class="flex items-center gap-2 p-1.5 bg-slate-200/60 rounded-2xl w-fit text-xs font-semibold">
        <a href="{{ route('admin.orders.history', ['status' => 'all', 'search' => $search]) }}" 
           class="px-4 py-2 rounded-xl transition-all duration-150 {{ $status === 'all' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900' }}">
            Semua Pesanan
        </a>
        <a href="{{ route('admin.orders.history', ['status' => 'pending', 'search' => $search]) }}" 
           class="px-4 py-2 rounded-xl transition-all duration-150 {{ $status === 'pending' ? 'bg-amber-500 text-white shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900' }}">
            Menunggu Diambil
        </a>
        <a href="{{ route('admin.orders.history', ['status' => 'completed', 'search' => $search]) }}" 
           class="px-4 py-2 rounded-xl transition-all duration-150 {{ $status === 'completed' ? 'bg-emerald-600 text-white shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900' }}">
            Sudah Selesai
        </a>
    </div>

    <!-- Tabel Riwayat Pesanan -->
    <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/60 text-[11px] text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-bold">Kode Order</th>
                        <th class="py-3.5 px-4 font-bold">Waktu Transaksi</th>
                        <th class="py-3.5 px-4 font-bold">Nama Pembeli</th>
                        <th class="py-3.5 px-4 font-bold">Rincian Item</th>
                        <th class="py-3.5 px-4 font-bold">Total Biaya</th>
                        <th class="py-3.5 px-4 font-bold">Status</th>
                        <th class="py-3.5 px-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/70 transition duration-150">
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-200/60 inline-block">
                                    {{ $order->order_code }}
                                </span>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap text-xs text-slate-500">
                                <i class="fa-regular fa-calendar text-[10px] mr-1 text-slate-400"></i>
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-[10px] font-bold">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $order->user->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-600">
                                <div class="space-y-1">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <span class="font-medium text-slate-800">&bull; {{ $item->product->name }}</span>
                                            <span class="px-1.5 py-0.2 bg-slate-100 text-slate-600 rounded text-[10px] font-bold">x{{ $item->quantity }}</span>
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
                                @if($order->order_status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 text-xs px-3 py-1 bg-amber-50 text-amber-700 rounded-full font-bold border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Menunggu
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full font-bold border border-emerald-200">
                                        <i class="fa-solid fa-check text-[10px]"></i> Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap text-right">
                                @if($order->order_status === 'pending')
                                    <form action="{{ route('admin.order.complete', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Serahkan barang ini ke siswa?')" class="px-3.5 py-1.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl text-xs font-bold shadow-sm transition active:scale-95 inline-flex items-center gap-1 cursor-pointer">
                                            <i class="fa-solid fa-check text-xs"></i> Selesai
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400 font-medium italic">Tuntas</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-xl mx-auto mb-2">
                                    <i class="fa-solid fa-inbox"></i>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Tidak ada data pesanan</p>
                                <p class="text-xs text-slate-400 mt-0.5">Coba ubah kata kunci pencarian atau filter status.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>
@endsection