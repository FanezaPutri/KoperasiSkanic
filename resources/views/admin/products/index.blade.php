@extends('layouts.app')

@section('page-title', 'Kelola Barang Koperasi')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-2 shadow-sm text-sm">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Form Tambah Barang / Jasa -->
    <div class="bg-white rounded-2xl border border-blue-100 shadow-sm p-6">
        <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-plus-circle text-blue-600"></i> Tambah Barang atau Jasa Baru
        </h3>

        <form action="{{ route('admin.products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Nama Barang / Jasa</label>
                <input type="text" name="name" required placeholder="Contoh: Pulpen Standard, Dasi SMP"
                    class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Kategori</label>
                <select name="category_id" required class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }} ({{ $cat->type === 'service' ? 'Jasa' : 'Fisik' }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Stok Awal</label>
                <input type="number" name="stock" value="10" min="0" required
                    class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

           <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Harga Modal (Rp)</label>
                <input type="number" name="cost_price" value="500" min="0" step="500" required
                    class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Harga Jual (Rp)</label>
                <input type="number" name="price" value="500" min="0" step="500" required
                    class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full py-2 bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-xl text-sm transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Barang
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Barang -->
    <div class="bg-white rounded-2xl border border-blue-100 shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <h3 class="text-base font-bold text-slate-800">Daftar Barang & Inventaris Real-Time</h3>
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" id="admin-search-product" placeholder="Cari nama barang..." 
                    class="w-full pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-xs text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-3">Nama</th>
                        <th class="py-3 px-3">Kategori</th>
                        <th class="py-3 px-3">Modal</th>
                        <th class="py-3 px-3">Harga Jual</th>
                        <th class="py-3 px-3">Stok</th>
                        <th class="py-3 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-3 font-semibold text-slate-800">{{ $product->name }}</td>
                            <td class="py-3 px-3">
                                <span class="text-xs px-2.5 py-1 rounded-lg {{ $product->category->type === 'service' ? 'bg-amber-50 text-amber-600 border border-amber-200' : 'bg-blue-50 text-blue-600 border border-blue-100' }}">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-slate-500">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</td>
                            <td class="py-3 px-3 font-bold text-blue-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="py-3 px-3">
                                @if($product->category->type === 'physical')
                                    <span class="font-bold {{ $product->stock <= 5 ? 'text-red-500' : 'text-slate-700' }}">
                                        {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400 italic">Jasa</span>
                                @endif
                            </td>
                            <td class="py-3 px-3 text-right space-x-1 whitespace-nowrap">
                                <!-- Tombol Buka Pop-up Edit -->
                                <button type="button" onclick="document.getElementById('edit-modal-{{ $product->id }}').classList.remove('hidden')" 
                                    class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-xl text-xs font-semibold transition inline-flex items-center gap-1">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </button>

                                <!-- Form Hapus Barang -->
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-semibold transition inline-flex items-center gap-1">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>

                                <!-- Pop-up Modal Edit Barang -->
                                <div id="edit-modal-{{ $product->id }}" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 text-left">
                                    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl border border-slate-100">
                                        <div class="flex justify-between items-center mb-4 border-b pb-3">
                                            <h4 class="font-bold text-slate-800 text-base">Edit Data: {{ $product->name }}</h4>
                                            <button type="button" onclick="document.getElementById('edit-modal-{{ $product->id }}').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 p-1">
                                                <i class="fa-solid fa-xmark text-lg"></i>
                                            </button>
                                        </div>

                                        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-3">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Nama Barang / Jasa</label>
                                                <input type="text" name="name" value="{{ $product->name }}" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>

                                            <div>
                                                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Kategori</label>
                                                <select name="category_id" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                                            {{ $cat->name }} ({{ $cat->type === 'service' ? 'Jasa' : 'Fisik' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Harga Modal (Rp)</label>
                                                    <input type="number" name="cost_price" value="{{ (int)$product->cost_price }}" min="0" step="500" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Harga Jual (Rp)</label>
                                                    <input type="number" name="price" value="{{ (int)$product->price }}" min="0" step="500" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Stok Barang</label>
                                                <input type="number" name="stock" value="{{ $product->stock }}" min="0" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>

                                            <div class="pt-4 flex gap-2">
                                                <button type="submit" class="flex-1 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl text-xs font-semibold transition shadow-md shadow-blue-500/20">
                                                    Simpan Perubahan
                                                </button>
                                                <button type="button" onclick="document.getElementById('edit-modal-{{ $product->id }}').classList.add('hidden')" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
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
                            <td colspan="6" class="text-center py-8 text-slate-400 text-xs">Belum ada barang yang didaftarkan.</td>
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