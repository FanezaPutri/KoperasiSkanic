@extends('layouts.app')

@section('page-title', 'Kelola Barang Koperasi')

@section('content')
<div class="space-y-8">

    @if(session('success'))
        <div class="p-4 bg-emerald-50/90 border border-emerald-200/80 text-emerald-800 rounded-2xl flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-circle-check text-base"></i>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block">Berhasil</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- Form Tambah Barang / Jasa -->
    <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm p-6 sm:p-8">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shadow-xs">
                <i class="fa-solid fa-square-plus"></i>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight">Tambah Barang atau Layanan Jasa Baru</h3>
                <p class="text-xs text-slate-500">Daftarkan produk fisik atau jasa fotokopi/pulsa ke dalam inventaris koperasi</p>
            </div>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Barang / Jasa</label>
                <div class="relative">
                    <input type="text" name="name" required placeholder="Contoh: Pulpen Standard, Dasi SMP"
                        class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori</label>
                <select name="category_id" required class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition cursor-pointer">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }} ({{ $cat->type === 'service' ? 'Layanan Jasa' : 'Barang Fisik' }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Stok Awal</label>
                <input type="number" name="stock" value="10" min="0" required
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Harga Modal (Rp)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs font-bold text-slate-400">Rp</span>
                    <input type="number" name="cost_price" value="500" min="0" step="500" required
                        class="w-full pl-9 pr-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Harga Jual (Rp)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs font-bold text-slate-400">Rp</span>
                    <input type="number" name="price" value="500" min="0" step="500" required
                        class="w-full pl-9 pr-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
                </div>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full py-2.5 sm:py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl text-xs sm:text-sm shadow-lg shadow-blue-500/25 transition-all duration-150 active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk text-xs"></i> 
                    <span>Simpan Barang</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Barang -->
    <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 tracking-tight">Daftar Barang & Inventaris Real-Time</h3>
                <p class="text-xs text-slate-500 mt-0.5">Seluruh komoditas barang dan layanan jasa yang tersedia</p>
            </div>
            <div class="relative w-full sm:w-72">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" id="admin-search-product" placeholder="Cari nama barang..." 
                    class="w-full pl-9 pr-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/60 text-[11px] text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-bold">Nama Produk</th>
                        <th class="py-3.5 px-4 font-bold">Kategori</th>
                        <th class="py-3.5 px-4 font-bold">Harga Modal</th>
                        <th class="py-3.5 px-4 font-bold">Harga Jual</th>
                        <th class="py-3.5 px-4 font-bold">Stok</th>
                        <th class="py-3.5 px-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/70 transition duration-150">
                            <td class="py-3.5 px-4 font-bold text-slate-900">{{ $product->name }}</td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-lg font-semibold {{ $product->category->type === 'service' ? 'bg-amber-50 text-amber-700 border border-amber-200/70' : 'bg-blue-50 text-blue-700 border border-blue-200/70' }}">
                                    <i class="fa-solid {{ $product->category->type === 'service' ? 'fa-bolt text-[10px]' : 'fa-box text-[10px]' }}"></i>
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-slate-500 font-medium">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-bold text-blue-700">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($product->category->type === 'physical')
                                    @if($product->stock <= 5)
                                        <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 bg-rose-50 text-rose-700 rounded-full font-bold border border-rose-200">
                                            <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                                            {{ $product->stock }} (Kritis)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-full font-bold border border-emerald-200">
                                            {{ $product->stock }} Unit
                                        </span>
                                    @endif
                                @else
                                    <span class="text-xs text-slate-400 font-medium italic">Layanan Jasa</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-1.5 whitespace-nowrap">
                                <!-- Tombol Buka Pop-up Edit -->
                                <button type="button" onclick="document.getElementById('edit-modal-{{ $product->id }}').classList.remove('hidden')" 
                                    class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-xl text-xs font-bold border border-amber-200/70 transition inline-flex items-center gap-1 active:scale-95 cursor-pointer">
                                    <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit
                                </button>

                                <!-- Form Hapus Barang -->
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang {{ $product->name }}?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-xs font-bold border border-rose-200/70 transition inline-flex items-center gap-1 active:scale-95 cursor-pointer">
                                        <i class="fa-solid fa-trash-can text-[10px]"></i> Hapus
                                    </button>
                                </form>

                                <!-- Pop-up Modal Edit Barang -->
                                <div id="edit-modal-{{ $product->id }}" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4 text-left">
                                    <div class="bg-white rounded-3xl p-6 sm:p-8 w-full max-w-md shadow-2xl border border-slate-100 transition-all">
                                        <div class="flex justify-between items-center mb-5 border-b border-slate-100 pb-4">
                                            <div>
                                                <h4 class="font-extrabold text-slate-900 text-base">Edit Data Produk</h4>
                                                <p class="text-xs text-slate-400 mt-0.5">{{ $product->name }}</p>
                                            </div>
                                            <button type="button" onclick="document.getElementById('edit-modal-{{ $product->id }}').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-600 hover:bg-slate-200 flex items-center justify-center transition">
                                                <i class="fa-solid fa-xmark text-sm"></i>
                                            </button>
                                        </div>

                                        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-4">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Barang / Jasa</label>
                                                <input type="text" name="name" value="{{ $product->name }}" required class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
                                            </div>

                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori</label>
                                                <select name="category_id" required class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                                            {{ $cat->name }} ({{ $cat->type === 'service' ? 'Layanan Jasa' : 'Barang Fisik' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga Modal (Rp)</label>
                                                    <input type="number" name="cost_price" value="{{ (int)$product->cost_price }}" min="0" step="500" required class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga Jual (Rp)</label>
                                                    <input type="number" name="price" value="{{ (int)$product->price }}" min="0" step="500" required class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Stok Barang</label>
                                                <input type="number" name="stock" value="{{ $product->stock }}" min="0" required class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition">
                                            </div>

                                            <div class="pt-4 flex gap-2.5">
                                                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/20 transition active:scale-95 cursor-pointer">
                                                    Simpan Perubahan
                                                </button>
                                                <button type="button" onclick="document.getElementById('edit-modal-{{ $product->id }}').classList.add('hidden')" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-xl mx-auto mb-2">
                                    <i class="fa-solid fa-boxes-stacked"></i>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Belum ada barang terdaftar</p>
                                <p class="text-xs text-slate-400 mt-0.5">Gunakan formulir di atas untuk menambahkan barang atau jasa.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
@push('scripts')
<script>
    const searchInput = document.getElementById('admin-search-product');
    const tableRows = document.querySelectorAll('tbody tr');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase();

            tableRows.forEach(row => {
                const productName = row.querySelector('td:first-child')?.innerText.toLowerCase() || '';
                const categoryName = row.querySelector('td:nth-child(2)')?.innerText.toLowerCase() || '';

                if (productName.includes(query) || categoryName.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
</script>
@endpush