@extends('layouts.app')

@section('page-title', 'Pesanan Saya')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50/90 border border-emerald-200/80 text-emerald-800 rounded-2xl flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-circle-check text-base"></i>
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

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/70 shadow-sm">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Daftar Pesanan & Riwayat Booking</h2>
            <p class="text-xs text-slate-500 mt-0.5">Tunjukkan kode pesanan atau cetak struk saat mengambil barang di kasir koperasi</p>
        </div>
        <a href="{{ route('buyer.dashboard') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/25 transition active:scale-95 flex items-center justify-center gap-2 cursor-pointer self-start sm:self-center">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Pesan Barang Lagi</span>
        </a>
    </div>

    <!-- Order List Cards -->
    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white p-6 rounded-3xl border border-slate-200/70 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-3 flex-1">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="font-mono font-extrabold text-blue-700 bg-blue-50 px-3 py-1 rounded-xl border border-blue-200/60 text-sm">
                            {{ $order->order_code }}
                        </span>
                        
                        @if($order->order_status === 'pending')
                            <span class="inline-flex items-center gap-1.5 text-xs px-3 py-1 bg-amber-50 text-amber-700 rounded-full font-bold border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Siap Diambil di Koperasi
                            </span>
                        @elseif($order->order_status === 'completed')
                            <span class="inline-flex items-center gap-1 text-xs px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full font-bold border border-emerald-200">
                                <i class="fa-solid fa-check text-[10px]"></i> Selesai (Sudah Diterima)
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs px-3 py-1 bg-rose-50 text-rose-700 rounded-full font-bold border border-rose-200">
                                <i class="fa-solid fa-xmark text-[10px]"></i> Dibatalkan
                            </span>
                        @endif
                    </div>

                    <p class="text-xs text-slate-400 flex items-center gap-1.5">
                        <i class="fa-regular fa-clock text-[11px]"></i>
                        <span>Dipesan pada {{ $order->created_at->format('d M Y, H:i') }}</span>
                    </p>

                    <div class="pt-2 border-t border-slate-100 text-xs text-slate-700 space-y-1.5">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                <span class="font-semibold text-slate-800">{{ $item->product->name ?? 'Barang Terhapus' }}</span>
                                <span class="px-1.5 py-0.2 bg-slate-100 text-slate-600 rounded text-[10px] font-bold">x{{ $item->quantity }}</span>
                                @if($item->notes)
                                    <span class="text-blue-700 bg-blue-50 px-2 py-0.5 rounded text-[10px] font-semibold border border-blue-100">
                                        {{ $item->notes }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="md:border-l md:border-slate-100 md:pl-6 flex md:flex-col justify-between items-end gap-3 flex-shrink-0">
                    <div class="text-left md:text-right">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Tagihan</span>
                        <span class="text-lg sm:text-xl font-extrabold text-slate-900 block mt-0.5">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('buyer.orders.receipt', $order->id) }}" target="_blank" 
                           class="text-xs px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold rounded-xl border border-blue-200 transition inline-flex items-center gap-1.5 active:scale-95 shadow-2xs">
                            <i class="fa-solid fa-receipt text-xs"></i> 
                            <span>Lihat Struk</span>
                        </a>

                        @if($order->order_status === 'pending')
                            <form action="{{ route('buyer.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin membatalkan pesanan {{ $order->order_code }}?')">
                                @csrf
                                <button type="submit" class="text-xs px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded-xl border border-rose-200 transition inline-flex items-center gap-1.5 active:scale-95 cursor-pointer">
                                    <i class="fa-solid fa-ban text-xs"></i>
                                    <span>Batalkan</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-200/70 p-8">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-3">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <h4 class="text-base font-bold text-slate-700">Belum ada transaksi pemesanan</h4>
                <p class="text-xs text-slate-400 mt-1">Kamu belum pernah memesan barang atau jasa dari koperasi sekolah.</p>
                <a href="{{ route('buyer.dashboard') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/20 hover:bg-blue-700 transition">
                    <i class="fa-solid fa-bag-shopping"></i> Belanja Sekarang
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection