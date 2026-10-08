<aside class="w-64 h-screen bg-slate-900 text-slate-300 flex flex-col justify-between shadow-2xl flex-shrink-0 border-r border-slate-800/80">
    <div class="flex-1 flex flex-col min-h-0">
        <!-- Branding Koperasi Skanic -->
        <div class="p-5 border-b border-slate-800/80 flex items-center gap-3.5 flex-shrink-0 bg-slate-950/40">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                <i class="fa-solid fa-store text-lg"></i>
            </div>
            <div>
                <h2 class="font-extrabold text-base tracking-tight text-white flex items-center gap-1.5">
                    Koperasi Skanic
                </h2>
                <p class="text-[11px] font-medium text-blue-400">Smart Digital Cooperative</p>
            </div>
        </div>

        <!-- Navigasi Menu Vertikal Rapi -->
        <nav class="flex-1 overflow-y-auto px-3.5 py-4 space-y-1 text-xs">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="px-3 pt-1 pb-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    Panel Admin
                </div>

                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-600/30 font-semibold' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-chart-pie w-4 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-blue-400' }}"></i> 
                        <span>Dashboard</span>
                    </div>
                    @php
                        $pendingBadge = \App\Models\Order::where('order_status', 'pending')->count();
                    @endphp
                    @if($pendingBadge > 0)
                        <span class="px-2 py-0.5 text-[10px] bg-amber-400 text-slate-950 font-extrabold rounded-full shadow-sm animate-pulse">
                            {{ $pendingBadge }}
                        </span>
                    @endif
                </a>

                <div class="px-3 pt-4 pb-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    Kelola Koperasi
                </div>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-600/30 font-semibold' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-boxes-stacked w-4 text-center {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-blue-400' }}"></i> 
                    <span>Kelola Barang</span>
                </a>

                <a href="{{ route('admin.report') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.report') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-600/30 font-semibold' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-file-invoice-dollar w-4 text-center {{ request()->routeIs('admin.report') ? 'text-white' : 'text-emerald-400' }}"></i> 
                    <span>Laporan Keuntungan</span>
                </a>
            @else
                <div class="px-3 pt-1 pb-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    Menu Belanja
                </div>

                <a href="{{ route('buyer.dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('buyer.dashboard') && !request('category') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-600/30 font-semibold' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-shop w-4 text-center {{ request()->routeIs('buyer.dashboard') && !request('category') ? 'text-white' : 'text-blue-400' }}"></i> 
                    <span>Katalog Semua</span>
                </a>

                <a href="{{ route('buyer.orders') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('buyer.orders') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-600/30 font-semibold' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-receipt w-4 text-center {{ request()->routeIs('buyer.orders') ? 'text-white' : 'text-amber-400' }}"></i> 
                    <span>Pesanan Saya</span>
                </a>
            @endif

            <!-- Kategori Penjualan Koperasi -->
            <div class="px-3 pt-5 pb-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                Kategori Produk
            </div>
            
            @php
                $sidebarCategories = [
                    'makanan-minuman' => ['icon' => 'fa-utensils', 'name' => 'Makanan & Minuman', 'color' => 'text-amber-400'],
                    'alat-tulis' => ['icon' => 'fa-pen-ruler', 'name' => 'Alat Tulis', 'color' => 'text-cyan-400'],
                    'atribut-sekolah' => ['icon' => 'fa-graduation-cap', 'name' => 'Atribut Sekolah', 'color' => 'text-indigo-400'],
                    'kebersihan' => ['icon' => 'fa-broom', 'name' => 'Kebersihan', 'color' => 'text-emerald-400'],
                    'obat' => ['icon' => 'fa-pills', 'name' => 'Obat', 'color' => 'text-rose-400'],
                    'jasa-e-wallet' => ['icon' => 'fa-wallet', 'name' => 'Jasa E-Wallet', 'color' => 'text-violet-400'],
                    'pulsa' => ['icon' => 'fa-mobile-screen-button', 'name' => 'Pulsa', 'color' => 'text-sky-400'],
                    'photocopy' => ['icon' => 'fa-print', 'name' => 'Photocopy', 'color' => 'text-teal-400'],
                ];
            @endphp

            @foreach($sidebarCategories as $slug => $cat)
                <a href="{{ route('buyer.dashboard', ['category' => $slug]) }}" 
                   class="flex items-center gap-3 px-3.5 py-2 rounded-xl transition-all duration-150 {{ request('category') === $slug ? 'bg-blue-600/90 text-white font-medium shadow-sm' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/40' }}">
                    <i class="fa-solid {{ $cat['icon'] }} w-4 text-center {{ request('category') === $slug ? 'text-white' : $cat['color'] }}"></i> 
                    <span class="truncate">{{ $cat['name'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    <!-- Info User Bawah -->
    <div class="p-4 border-t border-slate-800/80 bg-slate-950/50 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="relative">
                <div class="w-8 h-8 rounded-xl bg-slate-800 text-blue-400 flex items-center justify-center font-bold text-xs border border-slate-700">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 rounded-full ring-2 ring-slate-900"></span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Tamu' }}</p>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span class="text-[10px] text-slate-400 capitalize">{{ auth()->user()->role ?? 'Tamu' }} Active</span>
                </div>
            </div>
        </div>
    </div>
</aside>