<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <div class="flex items-center gap-3">
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

    <!-- JS Sederhana untuk Toggle Sidebar di HP -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-wrapper');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>

    @stack('scripts')
</body>
</html>