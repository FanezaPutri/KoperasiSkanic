<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Koperasi Skanic - Sistem Koperasi Digital' }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'Fira Code', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#172554',
                        }
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03)',
                        'card': '0 10px 30px -5px rgba(0, 0, 0, 0.04), 0 2px 6px -2px rgba(0, 0, 0, 0.02)',
                        'glow': '0 0 25px -5px rgba(37, 99, 235, 0.25)',
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-slate-50/80 text-slate-800 flex h-screen overflow-hidden antialiased selection:bg-blue-600 selection:text-white">

    <!-- Overlay Latar Belakang untuk Layar HP saat Sidebar Dibuka -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-30 hidden md:hidden transition-opacity duration-300"></div>

    <!-- Sidebar Komponen -->
    <div id="sidebar-wrapper" class="fixed md:static inset-y-0 left-0 z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-out shadow-2xl md:shadow-none flex-shrink-0">
        @include('layouts.sidebar')
    </div>

    <!-- Konten Utama -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <!-- Header Atas Glassmorphic -->
        <header class="bg-white/85 backdrop-blur-md border-b border-slate-200/80 py-3.5 px-4 md:px-8 flex justify-between items-center sticky top-0 z-20 transition-all duration-200">
            <div class="flex items-center gap-3 md:gap-4">
                <!-- Tombol Hamburger (Khusus Layar HP) -->
                <button type="button" onclick="toggleSidebar()" class="md:hidden p-2 text-slate-600 hover:text-blue-600 hover:bg-blue-50/80 rounded-xl transition duration-150 active:scale-95">
                    <i class="fa-solid fa-bars-staggered text-lg"></i>
                </button>
                <div>
                    <h1 class="text-base md:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>
            </div>

            <!-- User Status & Logout -->
            <div class="flex items-center gap-2.5 sm:gap-3">
                @if(auth()->check() && auth()->user()->role === 'buyer')
                    <a href="{{ route('buyer.cart') }}" class="relative p-2.5 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-600 transition flex items-center justify-center border border-slate-200/60 active:scale-95" title="Keranjang Belanja (1 Struk)">
                        <i class="fa-solid fa-cart-shopping text-sm sm:text-base"></i>
                        @php
                            $headerCartCount = count(session('cart', []));
                        @endphp
                        <span id="header-cart-badge" class="{{ $headerCartCount > 0 ? '' : 'hidden' }} absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 bg-blue-600 text-white text-[10px] font-black rounded-full flex items-center justify-center shadow-sm transition-transform duration-200">
                            {{ $headerCartCount }}
                        </span>
                    </a>
                @endif

                <div class="flex items-center gap-2.5 px-3 py-1.5 bg-slate-100/80 rounded-full border border-slate-200/60">
                    <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-xs font-bold shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="hidden sm:block text-left pr-1">
                        <span class="text-xs font-semibold text-slate-800 block leading-tight">{{ auth()->user()->name ?? 'Tamu' }}</span>
                        <span class="text-[10px] font-medium text-slate-500 uppercase tracking-wider block">
                            {{ auth()->user()->role === 'admin' ? 'Petugas Koperasi' : 'Siswa' }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Keluar dari akun" class="group flex items-center gap-1.5 text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 px-3 py-2 rounded-xl border border-rose-200/70 transition-all duration-150 active:scale-95 shadow-xs">
                        <i class="fa-solid fa-arrow-right-from-bracket group-hover:translate-x-0.5 transition-transform duration-150"></i>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Area Konten Halaman -->
        <main class="p-4 md:p-8 flex-1">
            @yield('content')
        </main>
    </div>

    <!-- Global Toast Notification Container -->
    <div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-2.5 pointer-events-none max-w-sm w-full px-4 sm:px-0"></div>

    <!-- JS Sederhana untuk Toggle Sidebar di HP -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-wrapper');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        window.showToast = function(message, type = 'success', actionText = null, actionUrl = null) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `pointer-events-auto transform transition-all duration-300 ease-out translate-y-[-10px] opacity-0 bg-slate-900/95 backdrop-blur-md text-white border ${type === 'success' ? 'border-emerald-500/40 shadow-emerald-950/20' : 'border-rose-500/40 shadow-rose-950/20'} rounded-2xl p-3.5 shadow-2xl flex items-center gap-3`;
            
            const iconHtml = type === 'success' 
                ? `<div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-sm flex-shrink-0"><i class="fa-solid fa-check"></i></div>`
                : `<div class="w-8 h-8 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center text-sm flex-shrink-0"><i class="fa-solid fa-circle-exclamation"></i></div>`;

            let actionHtml = '';
            if (actionText && actionUrl) {
                actionHtml = `<a href="${actionUrl}" class="ml-auto text-xs font-bold bg-blue-600 hover:bg-blue-500 text-white px-3 py-1.5 rounded-xl transition whitespace-nowrap active:scale-95 flex items-center gap-1">${actionText} <i class="fa-solid fa-arrow-right text-[10px]"></i></a>`;
            }

            toast.innerHTML = `
                ${iconHtml}
                <div class="flex-1 min-w-0 pr-1">
                    <p class="text-xs font-semibold text-slate-100 leading-snug">${message}</p>
                </div>
                ${actionHtml}
                <button type="button" class="text-slate-400 hover:text-white p-1 ml-1 flex-shrink-0 transition cursor-pointer" onclick="this.closest('div.pointer-events-auto').remove()">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            `;

            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-[-10px]', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            });

            setTimeout(() => {
                toast.classList.add('translate-y-[-10px]', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        };

        window.updateCartIndicators = function(data) {
            const headerBadge = document.getElementById('header-cart-badge');
            if (headerBadge) {
                if (data.cartCount > 0) {
                    headerBadge.innerText = data.cartCount;
                    headerBadge.classList.remove('hidden');
                    headerBadge.classList.add('scale-125');
                    setTimeout(() => headerBadge.classList.remove('scale-125'), 200);
                } else {
                    headerBadge.classList.add('hidden');
                }
            }

            const sidebarBadge = document.getElementById('sidebar-cart-badge');
            if (sidebarBadge) {
                if (data.cartCount > 0) {
                    sidebarBadge.innerText = data.cartCount;
                    sidebarBadge.classList.remove('hidden');
                } else {
                    sidebarBadge.classList.add('hidden');
                }
            }

            const floatingBar = document.getElementById('floating-cart-bar');
            const floatingCount = document.getElementById('floating-cart-count-text');
            const floatingTotal = document.getElementById('floating-cart-total-text');
            if (floatingBar && floatingCount && floatingTotal) {
                if (data.cartCount > 0) {
                    floatingCount.innerText = `${data.cartCount} Jenis Produk (${data.cartTotalUnits} Unit)`;
                    floatingTotal.innerText = `Total: ${data.cartTotalFormatted}`;
                    floatingBar.classList.remove('hidden');
                } else {
                    floatingBar.classList.add('hidden');
                }
            }
        };
    </script>

    @stack('scripts')
</body>
</html>