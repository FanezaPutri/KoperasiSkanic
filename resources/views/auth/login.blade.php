<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Koperasi Skanic</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-950 flex items-center justify-center p-4 relative overflow-hidden antialiased selection:bg-blue-600 selection:text-white">

    <!-- Ambient Glowing Background Elements -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-900/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Main Login Card -->
        <div class="bg-white/95 backdrop-blur-2xl p-8 sm:p-10 rounded-3xl shadow-2xl shadow-blue-950/40 border border-white/60 transition-all duration-300">
            
            <!-- Logo & Brand Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white shadow-xl shadow-blue-500/30 mb-4 ring-8 ring-blue-50">
                    <i class="fa-solid fa-store text-2xl"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Koperasi Skanic</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">Sistem Pemesanan & Pembukuan Koperasi Digital</p>
            </div>

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200/80 text-rose-700 px-4 py-3 rounded-2xl text-xs sm:text-sm mb-6 flex items-center gap-2.5 shadow-xs">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-base flex-shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-regular fa-user text-sm"></i>
                        </span>
                        <input type="text" id="input-username" name="username" required placeholder="Masukkan username anda"
                            class="w-full pl-10 pr-4 py-2.5 sm:py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition duration-150">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input type="password" id="input-password" name="password" required placeholder="••••••••"
                            class="w-full pl-10 pr-10 py-2.5 sm:py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 focus:bg-white transition duration-150">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                            <i id="toggle-password-icon" class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl text-sm shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-200 active:scale-[0.98] flex items-center justify-center gap-2">
                    <span>Masuk ke Sistem</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <!-- Quick Demo Credentials Box -->
            <div class="mt-8 pt-5 border-t border-slate-100">
                <p class="text-[11px] font-semibold text-slate-400 text-center uppercase tracking-wider mb-2.5">
                    Akun Pengujian Demo (Klik untuk Isi Cepat)
                </p>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" onclick="fillCredentials('admin', 'admin123')" class="px-3 py-2 bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-xl text-left transition group">
                        <div class="flex items-center gap-1.5 text-blue-600 font-bold text-xs">
                            <i class="fa-solid fa-shield-halved text-[11px]"></i> Admin
                        </div>
                        <div class="font-mono text-[11px] text-slate-500 group-hover:text-slate-700 truncate mt-0.5">admin / admin123</div>
                    </button>
                    <button type="button" onclick="fillCredentials('siswa', 'siswa123')" class="px-3 py-2 bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-200 rounded-xl text-left transition group">
                        <div class="flex items-center gap-1.5 text-emerald-600 font-bold text-xs">
                            <i class="fa-solid fa-user-graduate text-[11px]"></i> Siswa
                        </div>
                        <div class="font-mono text-[11px] text-slate-500 group-hover:text-slate-700 truncate mt-0.5">siswa / siswa123</div>
                    </button>
                </div>
            </div>

        </div>

        <p class="text-center text-xs text-slate-500 mt-6 font-medium">
            &copy; 2026 Koperasi Skanic. Dikembangkan untuk efisiensi sekolah digital.
        </p>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('input-password');
            const icon = document.getElementById('toggle-password-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function fillCredentials(user, pass) {
            document.getElementById('input-username').value = user;
            document.getElementById('input-password').value = pass;
        }
    </script>

</body>
</html>