<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superadmin - Kelola Akun</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f4f7fb] text-slate-800 antialiased min-h-screen flex">

    <!-- SIDEBAR KIRI -->
    <aside class="w-64 bg-[#0a1128] text-white flex flex-col justify-between shrink-0 min-h-screen">
        <div>
            <!-- Logo Header -->
            <div class="p-6 border-b border-white/10 flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center font-black text-xl shadow-lg shadow-blue-500/30">
                    K
                </div>
                <div>
                    <h1 class="font-bold text-base leading-tight">Koperasi Skanic</h1>
                    <p class="text-xs text-slate-400">Smart Digital Cooperative</p>
                </div>
            </div>

            <!-- Menu Navigasi -->
            <div class="px-4 py-6 space-y-6">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase px-3 block mb-3">PANEL SUPERADMIN</span>
                    <nav class="space-y-1.5">
                        <a href="{{ route('users.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-medium text-sm shadow-md shadow-blue-600/30 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Kelola Akun</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Profil Superadmin Bawah -->
        <div class="p-4 border-t border-white/10 flex items-center space-x-3 bg-white/5">
            <div class="w-9 h-9 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-sm">
                S
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-semibold truncate">{{ auth()->user()->name ?? 'Superadmin' }}</p>
                <div class="flex items-center space-x-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span class="text-xs text-slate-400">Superadmin Active</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 flex flex-col min-w-0">
        <!-- HEADER ATAS -->
        <header class="h-20 bg-white border-b border-slate-200 px-8 flex items-center justify-between sticky top-0 z-20">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Pusat Kelola Akun</h2>
                <p class="text-xs text-slate-500">Pendaftaran akun siswa beserta kelas dan petugas koperasi</p>
            </div>

            <!-- Tombol Pengguna & Logout -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2.5 px-3 py-1.5 bg-slate-100 rounded-xl">
                    <div class="w-7 h-7 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center">
                        P
                    </div>
                    <div class="text-left text-xs">
                        <p class="font-bold text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="text-slate-400 text-[10px] uppercase font-semibold">SUPERADMIN</p>
                    </div>
                </div>

                <!-- Form Tombol Logout -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="flex items-center space-x-1 px-3.5 py-1.5 text-xs font-semibold text-rose-500 bg-rose-50 hover:bg-rose-100 rounded-xl border border-rose-200 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- AREA BODY / FORM & TABEL -->
        <div class="p-8 space-y-8 flex-1 overflow-y-auto">

            <!-- Banner Notifikasi -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center space-x-2 font-medium">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Kartu Form Tambah Akun -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-base font-bold text-slate-800">Form Pendaftaran Akun Baru</h3>
                    <p class="text-xs text-slate-500">Lengkapi formulir untuk menambahkan akun baru ke database</p>
                </div>

                <form action="{{ route('users.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-2">Tipe Role Akun</label>
                        <select name="role" id="roleSelect" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-500 focus:bg-white transition" onchange="toggleKelas(this.value)">
                            <option value="buyer">Siswa (Pembeli)</option>
                            <option value="admin">Penjaga Koperasi (Admin)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-2">Nama Lengkap</label>
                        <input type="text" name="name" placeholder="Misal: Ahmad Zaky" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-500 focus:bg-white transition" required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-2">Username</label>
                        <input type="text" name="username" placeholder="Misal: zaky123" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-500 focus:bg-white transition" required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-2">Password</label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-500 focus:bg-white transition" required>
                    </div>

                    <div id="kelasWrapper">
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-2">Kelas (Khusus Siswa)</label>
                        <input type="text" name="kelas" placeholder="Misal: XII RPL 1" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div class="md:col-span-2 flex justify-end pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-500/20 transition flex items-center space-x-2">
                            <span>Simpan Akun Baru</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Daftar Akun yang Sudah Terdaftar -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                <h3 class="text-base font-bold text-slate-800 mb-4">Daftar Akun Pengguna</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-semibold text-slate-400 uppercase">
                                <th class="py-3 px-4">Nama</th>
                                <th class="py-3 px-4">Username</th>
                                <th class="py-3 px-4">Role</th>
                                <th class="py-3 px-4">Kelas</th>
                                <th class="py-3 px-4">Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                            @forelse($users as $user)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $user->name }}</td>
                                    <td class="py-3.5 px-4">{{ $user->username }}</td>
                                    <td class="py-3.5 px-4">
                                        @if($user->role === 'admin')
                                            <span class="px-2.5 py-1 text-xs rounded-lg font-semibold bg-indigo-50 text-indigo-600 border border-indigo-200">Penjaga Koperasi</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs rounded-lg font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">Siswa</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4">{{ $user->kelas ?? '-' }}</td>
                                    <td class="py-3.5 px-4 text-xs text-slate-400">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400 text-xs">Belum ada akun siswa atau penjaga koperasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- Script Menyembunyikan Input Kelas bila Role = Admin -->
    <script>
        function toggleKelas(role) {
            const wrapper = document.getElementById('kelasWrapper');
            if (role === 'buyer') {
                wrapper.style.display = 'block';
            } else {
                wrapper.style.display = 'none';
            }
        }
    </script>
</body>
</html>