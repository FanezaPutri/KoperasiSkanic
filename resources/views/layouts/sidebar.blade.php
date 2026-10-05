<aside class="w-64 h-screen bg-gradient-to-b from-blue-900 to-blue-800 text-white flex flex-col justify-between shadow-xl flex-shrink-0">
    <div class="flex-1 flex flex-col min-h-0">
        <!-- Branding Koperasi Skanic -->
        <div class="p-5 border-b border-blue-700/50 flex items-center gap-3 flex-shrink-0">
            <div class="bg-blue-600 p-2.5 rounded-xl shadow-inner text-white">
                <i class="fa-solid fa-store text-xl"></i>
            </div>
            <div>
                <h2 class="font-bold text-base tracking-wide text-white">Koperasi Skanic</h2>
                <p class="text-xs text-blue-200">Cepat, Mudah & Real-time</p>
            </div>
        </div>

        <!-- Navigasi Menu Vertikal Rapi -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-1.5 text-sm">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 text-white font-medium' : 'text-blue-100 hover:bg-blue-700/40' }} transition">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-house w-5"></i> Dashboard
                    </div>
                    @php
                        $pendingBadge = \App\Models\Order::where('order_status', 'pending')->count();
                    @endphp
                    @if($pendingBadge > 0)
                        <span class="px-2 py-0.5 text-[11px] bg-amber-400 text-slate-900 font-bold rounded-full shadow-sm">
                            {{ $pendingBadge }}
                        </span>
                    @endif
                </a>

                <div class="pt-3 pb-1 text-xs font-semibold text-blue-300 uppercase tracking-wider">Kelola Koperasi</div>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->routeIs('admin.products.*') ? 'bg-blue-700 text-white font-medium' : 'text-blue-100 hover:bg-blue-700/40' }} transition">
                    <i class="fa-solid fa-boxes-stacked w-5"></i> Kelola Barang
                </a>
                <a href="{{ route('admin.report') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->routeIs('admin.report') ? 'bg-blue-700 text-white font-medium' : 'text-blue-100 hover:bg-blue-700/40' }} transition">
                    <i class="fa-solid fa-chart-line w-5"></i> Laporan Keuntungan
                </a>
            @else
                <a href="{{ route('buyer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('buyer.dashboard') && !request('category') ? 'bg-blue-700 text-white font-medium' : 'text-blue-100 hover:bg-blue-700/40' }} transition">
                    <i class="fa-solid fa-house w-5"></i> Dashboard & Semua
                </a>
                <a href="{{ route('buyer.orders') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->routeIs('buyer.orders') ? 'bg-blue-700 text-white font-medium' : 'text-blue-100 hover:bg-blue-700/40' }} transition">
                    <i class="fa-solid fa-receipt w-5"></i> Pesanan Saya
                </a>
            @endif

            <!-- Kategori Penjualan Koperasi -->
            <div class="pt-4 pb-1 text-xs font-semibold text-blue-300 uppercase tracking-wider">Kategori Penjualan</div>
            
            @php
                $sidebarCategories = [
                    'makanan-minuman' => ['icon' => 'fa-utensils', 'name' => 'Makanan & Minuman'],
                    'alat-tulis' => ['icon' => 'fa-pen-ruler', 'name' => 'Alat Tulis'],
                    'atribut-sekolah' => ['icon' => 'fa-graduation-cap', 'name' => 'Atribut Sekolah'],
                    'kebersihan' => ['icon' => 'fa-broom', 'name' => 'Kebersihan'],
                    'obat' => ['icon' => 'fa-pills', 'name' => 'Obat'],
                    'jasa-e-wallet' => ['icon' => 'fa-wallet', 'name' => 'Jasa E-Wallet'],
                    'pulsa' => ['icon' => 'fa-mobile-screen-button', 'name' => 'Pulsa'],
                    'photocopy' => ['icon' => 'fa-print', 'name' => 'Photocopy'],
                ];
            @endphp

            @foreach($sidebarCategories as $slug => $cat)
                <a href="{{ route('buyer.dashboard', ['category' => $slug]) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request('category') === $slug ? 'bg-blue-700 text-white font-medium' : 'text-blue-100 hover:bg-blue-700/40' }} transition">
                    <i class="fa-solid {{ $cat['icon'] }} w-5"></i> {{ $cat['name'] }}
                </a>
            @endforeach
        </nav>
    </div>

    <!-- Info User Bawah -->
    <div class="p-4 border-t border-blue-700/50 text-xs text-blue-200 flex-shrink-0">
        Status: <span class="capitalize font-semibold text-white">{{ auth()->user()->role ?? 'Tamu' }}</span>
    </div>
</aside>