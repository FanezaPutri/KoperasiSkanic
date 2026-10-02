@extends('layouts.app')

@section('page-title', 'Katalog Koperasi')

@section('content')
<div class="space-y-6">

    <!-- Notifikasi Pesan -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
            <span class="text-xs bg-emerald-200 text-emerald-800 px-2.5 py-1 rounded-full font-semibold">Tunjukkan ke Petugas</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl flex items-center gap-2 shadow-sm text-sm">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Banner Koperasi Skanic -->
    <div class="bg-gradient-to-r from-blue-700 to-blue-600 rounded-2xl p-6 text-white shadow-lg flex items-center justify-between">
        <div class="space-y-1">
            <span class="bg-blue-800/60 px-3 py-1 rounded-lg text-xs tracking-wider uppercase font-semibold text-blue-200">Sistem Digital</span>
            <h2 class="text-2xl font-bold">Koperasi Skanic</h2>
            <p class="text-blue-100 text-sm">Pesan barang kebutuhan atau jasa fotokopi & pulsa dari kelas, ambil saat istirahat!</p>
        </div>
        <div class="hidden sm:block text-5xl opacity-20 text-white pr-4">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
    </div>

    <!-- Filter Kategori Cepat -->
    <!-- Input Pencarian Cepat -->
    <div class="relative max-w-md">
        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input type="text" id="buyer-search" placeholder="Cari barang, pulsa, fotokopi..." 
            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm transition">
    </div>
    <div class="flex items-center gap-2 overflow-x-auto pb-2 text-sm">
        <a href="{{ route('buyer.dashboard') }}" 
           class="px-4 py-2 rounded-xl border transition whitespace-nowrap {{ !$selectedCategory ? 'bg-blue-700 text-white border-blue-700 shadow-md shadow-blue-500/20' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Semua Barang
        </a>
        @foreach($categories as $category)
            <a href="{{ route('buyer.dashboard', ['category' => $category->slug]) }}" 
               class="px-4 py-2 rounded-xl border transition whitespace-nowrap {{ $selectedCategory === $category->slug ? 'bg-blue-700 text-white border-blue-700 shadow-md shadow-blue-500/20' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <!-- Grid Produk & Jasa -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-2xl border border-blue-50 shadow-sm hover:shadow-md transition p-5 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-[11px] font-semibold tracking-wide uppercase px-2.5 py-1 rounded-lg {{ $product->category->type === 'service' ? 'bg-amber-50 text-amber-600 border border-amber-200' : 'bg-blue-50 text-blue-600 border border-blue-100' }}">
                            {{ $product->category->name }}
                        </span>
                        
                        <!-- Badge Stok Real-time -->
                        @if($product->category->type === 'physical')
                            <span class="text-xs font-medium {{ $product->stock > 5 ? 'text-slate-500' : ($product->stock > 0 ? 'text-amber-500 font-bold' : 'text-red-500 font-bold') }}">
                                {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Habis' }}
                            </span>
                        @else
                            <span class="text-xs text-blue-500 font-medium">Tersedia</span>
                        @endif
                    </div>

                    <h3 class="font-bold text-slate-800 text-base mb-1">{{ $product->name }}</h3>
                    <p class="text-xs text-slate-400 mb-4 line-clamp-2">{{ $product->description ?? 'Layanan dan kebutuhan resmi koperasi sekolah.' }}</p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Harga</span>
                        <span class="font-bold text-blue-800 text-base">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>

                    @if($product->category->type === 'physical' && $product->stock <= 0)
                        <button disabled class="px-4 py-2 bg-slate-100 text-slate-400 text-xs font-semibold rounded-xl cursor-not-allowed">
                            Habis
                        </button>
                    @else
                        <!-- Form Order Sederhana -->
                        <form action="{{ route('buyer.book', $product->id) }}" method="POST" class="flex items-center gap-1.5">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->category->type === 'physical' ? $product->stock : 999 }}" 
                                class="w-14 text-center text-xs py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-blue-500">
                            
                            @if($product->category->type === 'service')
                                <input type="text" name="notes" placeholder="No.HP / Ket" 
                                    class="w-24 text-xs py-2 px-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-blue-500">
                            @endif

                            <button type="submit" onclick="return confirm('Pesan barang/jasa ini sekarang?')" class="px-3.5 py-2 bg-blue-700 hover:bg-blue-800 text-white text-xs font-semibold rounded-xl shadow-md shadow-blue-500/20 transition flex items-center gap-1">
                                <i class="fa-solid fa-bag-shopping"></i> Beli
                            </button>   
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-400">
                <i class="fa-solid fa-box-open text-4xl mb-3 text-slate-300"></i>
                <p class="text-sm">Belum ada barang di kategori ini.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
@push('scripts')
<script>
    const searchInput = document.getElementById('buyer-search');
    const productCards = document.querySelectorAll('.grid > div');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase();

            productCards.forEach(card => {
                const title = card.querySelector('h3')?.innerText.toLowerCase() || '';
                const category = card.querySelector('span')?.innerText.toLowerCase() || '';

                if (title.includes(query) || category.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
</script>
@endpush