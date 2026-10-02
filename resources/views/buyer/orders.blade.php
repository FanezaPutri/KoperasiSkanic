@extends('layouts.app')

@section('page-title', 'Pesanan Saya')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Pesanan & Riwayat Booking</h2>
            <p class="text-xs text-slate-500">Tunjukkan kode pesanan saat mengambil barang di koperasi</p>
        </div>
        <a href="{{ route('buyer.dashboard') }}" class="px-4 py-2 bg-blue-50 text-blue-700 rounded-xl text-xs font-semibold hover:bg-blue-100 transition">
            + Pesan Lagi
        </a>
    </div>

    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white p-5 rounded-2xl border border-blue-50 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <span class="text-lg font-bold text-blue-900 tracking-wide">{{ $order->order_code }}</span>
                        @if($order->order_status === 'pending')
                            <span class="text-xs px-2.5 py-1 bg-amber-50 text-amber-600 rounded-full font-semibold border border-amber-200">
                                Siap Diambil
                            </span>
                        @else
                            <span class="text-xs px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full font-semibold border border-emerald-200">
                                Selesai
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Dipesan pada {{ $order->created_at->format('d M Y, H:i') }}</p>

                    <div class="mt-3 text-xs text-slate-700 space-y-1">
                        @foreach($order->items as $item)
                            <div>&bull; {{ $item->product->name }} (x{{ $item->quantity }})
                                @if($item->notes)
                                    <span class="text-blue-600 italic">[{{ $item->notes }}]</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-right md:border-l md:border-slate-100 md:pl-6 flex md:flex-col justify-between items-end">
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Total Tagihan</span>
                        <span class="text-base font-bold text-slate-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <span class="text-xs text-emerald-600 font-medium mt-1">Sudah Dibayar (Online)</span>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-2xl border border-blue-50">
                <i class="fa-solid fa-receipt text-3xl text-slate-300 mb-2"></i>
                <p class="text-sm text-slate-500">Kamu belum pernah memesan barang atau jasa.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection