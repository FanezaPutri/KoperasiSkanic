<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Koperasi Skanic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gradient-to-tr from-blue-950 via-blue-900 to-blue-700 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white/95 backdrop-blur-md p-8 rounded-2xl shadow-2xl w-full max-w-md border border-white/20">
        <!-- Logo & Header -->
        <div class="text-center mb-6">
            <div class="inline-flex p-3 bg-blue-100 text-blue-700 rounded-2xl mb-3 shadow-inner">
                <i class="fa-solid fa-store text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Koperasi Skanic</h2>
            <p class="text-sm text-slate-500 mt-1">Sederhana, Cepat & Terintegrasi Real-time</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 text-red-600 p-3 rounded-xl text-sm mb-4 border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Username</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input type="text" name="username" required placeholder="Masukkan username"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                </div>
            </div>

            <button type="submit" class="w-full py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-xl shadow-lg shadow-blue-500/30 transition duration-200">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-slate-100 text-center text-xs text-slate-400">
            Penjaga: <span class="font-mono text-slate-600">admin / admin123</span> &bull; Siswa: <span class="font-mono text-slate-600">siswa / siswa123</span>
        </div>
    </div>

</body>
</html>