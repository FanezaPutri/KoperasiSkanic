<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Koperasi Skanic' }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex h-screen overflow-hidden">

    <!-- Overlay Latar Belakang untuk Layar HP saat Sidebar Dibuka -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 hidden md:hidden"></div>

    <!-- Sidebar Komponen -->
    <div id="sidebar-wrapper" class="fixed md:static inset-y-0 left-0 z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
        @include('layouts.sidebar')
    </div>

    <!-- Konten Utama -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <!-- Header Atas -->
        <header class="bg-white border-b border-blue-100 py-3 px-4 md:px-6 flex justify-between items-center shadow-sm sticky top-0 z-20">
            <div class="flex items-center gap-3">
                <!-- Tombol Hamburger (Khusus Layar HP) -->
                <button type="button" onclick="toggleSidebar()" class="md:hidden p-2 text-slate-600 hover:text-blue-700 hover:bg-blue-50 rounded-xl transition">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <h1 class="text-base md:text-lg font-semibold text-blue-900">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-xs md:text-sm font-medium text-slate-600">
                    <i class="fa-regular fa-user text-blue-500 mr-1"></i> {{ auth()->user()->name ?? 'Tamu' }}
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg transition font-medium">
                        Keluar
                    </button>
                </form>
            </div>
        </header>

        <!-- Area Konten Halaman -->
        <main class="p-4 md:p-6">
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