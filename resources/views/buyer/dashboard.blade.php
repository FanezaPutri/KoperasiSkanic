@extends('layouts.app')

@section('page-title', 'Katalog Koperasi Siswa')

@section('content')
<div class="space-y-8">

    <!-- Notifikasi Pesan Sukses / Error -->
    @if(session('success'))
        <div class="p-4 sm:p-5 bg-emerald-50/90 border border-emerald-200/80 text-emerald-800 rounded-3xl flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 text-lg">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block">Pemesanan Berhasil</span>
                    <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
                </div>
            </div>
            <a href="{{ route('buyer.orders') }}" class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl font-bold shadow-sm transition whitespace-nowrap active:scale-95">
                Lihat Pesanan
            </a>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 sm:p-5 bg-rose-50/90 border border-rose-200/80 text-rose-800 rounded-3xl flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0 text-lg">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-600 block">Peringatan</span>
                    <span class="text-xs sm:text-sm font-semibold">{{ session('error') }}</span>
                </div>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-600 p-1">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- Hero Banner Koperasi Skanic -->
    <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-900 rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-60 h-60 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-12 bottom-0 w-48 h-48 bg-indigo-500/20 rounded-full blur-xl pointer-events-none"></div>
        
        <div class="relative z-10 max-w-2xl space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/15 backdrop-blur-md rounded-full text-[11px] font-bold text-blue-100 border border-white/20 mb-1">
                <i class="fa-solid fa-bolt text-amber-300"></i>
                <span>Pesan Cepat Dari Kelas</span>
            </div>
            <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight leading-tight">
                Koperasi Skanic Digital
            </h2>
            <p class="text-blue-100 text-xs sm:text-sm leading-relaxed">
                Pesan barang perlengkapan sekolah, alat tulis, jajan, fotokopi tugas, hingga top up pulsa & e-wallet tanpa antre panjang di jam istirahat!
            </p>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="space-y-4">
        <!-- Input Pencarian Cepat -->
        <div class="relative max-w-lg">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" id="buyer-search" placeholder="Cari barang, makanan, pulsa, fotokopi..." 
                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200/80 rounded-2xl text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 shadow-sm transition">
        </div>

        <!-- Filter Kategori Horizontal -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 text-xs font-semibold no-scrollbar">
            <a href="{{ route('buyer.dashboard') }}" 
               class="px-4 py-2.5 rounded-2xl border transition-all duration-150 whitespace-nowrap {{ !$selectedCategory ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white border-transparent shadow-md shadow-blue-500/25 font-bold' : 'bg-white text-slate-600 border-slate-200/80 hover:bg-slate-50' }}">
                <i class="fa-solid fa-border-all mr-1.5"></i> Semua Kebutuhan
            </a>
            @foreach($categories as $category)
                <a href="{{ route('buyer.dashboard', ['category' => $category->slug]) }}" 
                   class="px-4 py-2.5 rounded-2xl border transition-all duration-150 whitespace-nowrap {{ $selectedCategory === $category->slug ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white border-transparent shadow-md shadow-blue-500/25 font-bold' : 'bg-white text-slate-600 border-slate-200/80 hover:bg-slate-50' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Grid Produk & Jasa -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 sm:gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm hover:shadow-xl hover:border-blue-300/80 transition-all duration-300 p-6 flex flex-col justify-between group">
                <div>
                    <!-- Kategori & Status Stok -->
                    <div class="flex justify-between items-center gap-2 mb-4">
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold tracking-wide uppercase px-2.5 py-1 rounded-lg {{ $product->category->type === 'service' ? 'bg-amber-50 text-amber-700 border border-amber-200/70' : 'bg-blue-50 text-blue-700 border border-blue-200/70' }}">
                            <i class="fa-solid {{ $product->category->type === 'service' ? 'fa-bolt text-[10px]' : 'fa-box text-[10px]' }}"></i>
                            {{ $product->category->name }}
                        </span>
                        
                        <!-- Badge Stok Real-time -->
                        @if($product->category->type === 'physical')
                            @if($product->stock > 5)
                                <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                                    Stok: {{ $product->stock }}
                                </span>
                            @elseif($product->stock > 0)
                                <span class="text-[11px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-100">
                                    Sisa {{ $product->stock }}
                                </span>
                            @else
                                <span class="text-[11px] font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-md border border-rose-100">
                                    Habis
                                </span>
                            @endif
                        @else
                            <span class="text-[11px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md border border-blue-100">
                                Layanan Aktif
                            </span>
                        @endif
                    </div>

                    <h3 class="font-extrabold text-slate-900 text-base mb-1.5 group-hover:text-blue-700 transition-colors duration-150">
                        {{ $product->name }}
                    </h3>
                    <p class="text-xs text-slate-400 mb-5 line-clamp-2 leading-relaxed">
                        {{ $product->description ?? 'Barang dan layanan resmi yang disediakan oleh Koperasi Siswa Skanic.' }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex flex-col gap-3">
                    <div class="flex items-baseline justify-between">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Harga Resmi</span>
                        <span class="font-extrabold text-blue-700 text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>

                    @if($product->category->type === 'physical' && $product->stock <= 0)
                        <button disabled class="w-full py-2.5 bg-slate-100 text-slate-400 text-xs font-bold rounded-xl cursor-not-allowed">
                            Stok Sedang Habis
                        </button>
                    @else
                        <!-- Form Order Sederhana -->
                        <form action="{{ route('buyer.book', $product->id) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->category->type === 'physical' ? $product->stock : 999 }}" 
                                class="w-14 text-center text-xs font-bold py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition" title="Jumlah pesanan">
                            
                            @if($product->category->type === 'service')
                                <input type="text" name="notes" placeholder="No.HP / Keterangan" 
                                    class="flex-1 min-w-0 text-xs py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
                            @endif

                            <button type="submit" onclick="return confirm('Pesan {{ $product->name }} sekarang?')" class="flex-1 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-bold rounded-xl shadow-md shadow-blue-500/25 transition-all duration-150 active:scale-95 flex items-center justify-center gap-1.5 cursor-pointer">
                                <i class="fa-solid fa-bag-shopping text-xs"></i> 
                                <span>Pesan</span>
                            </button>   
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-3xl border border-slate-200/70 p-8">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-3">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h4 class="text-base font-bold text-slate-700">Belum ada barang di kategori ini</h4>
                <p class="text-xs text-slate-400 mt-1">Silakan pilih kategori lain atau periksa kembali nanti.</p>
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