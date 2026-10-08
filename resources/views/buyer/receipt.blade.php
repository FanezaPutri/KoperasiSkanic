<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan - {{ $order->order_code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'Courier New', 'monospace'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; margin: 0 !important; }
            .receipt-card { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
        }
    </style>
</head>
<body class="bg-slate-100/80 min-h-screen py-10 px-4 flex flex-col items-center justify-center antialiased selection:bg-blue-600 selection:text-white">

    <!-- Tombol Navigasi (Sembunyi saat cetak) -->
    <div class="w-full max-w-sm flex justify-between items-center mb-5 no-print">
        <a href="{{ route('buyer.orders') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-600 hover:text-slate-900 font-bold px-3 py-1.5 bg-white rounded-xl border border-slate-200 shadow-2xs hover:bg-slate-50 transition active:scale-95">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            <span>Kembali ke Pesanan</span>
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/25 transition active:scale-95 cursor-pointer">
            <i class="fa-solid fa-print text-xs"></i>
            <span>Cetak Struk</span>
        </button>
    </div>

    <!-- Kertas Struk Modern -->
    <div class="receipt-card w-full max-w-sm bg-white p-7 rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 text-slate-800 text-xs relative overflow-hidden">
        
        <!-- Watermark / Decorative Top Band -->
        <div class="h-2 bg-gradient-to-r from-blue-600 to-indigo-600 absolute top-0 left-0 right-0"></div>

        <!-- Kop Struk -->
        <div class="text-center border-b border-dashed border-slate-300 pb-5 mb-5 mt-2">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 mb-2">
                <i class="fa-solid fa-store text-xl"></i>
            </div>
            <h1 class="text-base font-extrabold tracking-tight text-slate-900">KOPERASI SKANIC</h1>
            <p class="text-[11px] font-medium text-slate-500 mt-0.5">Bukti Pemesanan & Pengambilan Barang Resmi</p>
            
            <div class="mt-3.5 inline-block bg-slate-50 border border-slate-200 px-4 py-1.5 rounded-xl">
                <span class="text-[10px] text-slate-400 block uppercase tracking-wider font-semibold">Kode Transaksi</span>
                <span class="text-sm font-extrabold font-mono text-blue-700 tracking-wider">{{ $order->order_code }}</span>
            </div>
        </div>

        <!-- Info Pemesan -->
        <div class="space-y-2 border-b border-dashed border-slate-300 pb-4 mb-4 text-xs font-medium">
            <div class="flex justify-between items-center">
                <span class="text-slate-400">Waktu Order:</span>
                <span class="font-mono text-slate-700">{{ $order->created_at->format('d/m/Y H:i') }} WIB</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-400">Nama Siswa:</span>
                <span class="font-bold text-slate-900">{{ $order->user->name }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-400">Status Ambil:</span>
                <span class="uppercase font-bold px-2 py-0.5 rounded text-[10px] {{ $order->order_status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                    {{ $order->order_status === 'completed' ? 'Sudah Selesai' : 'Siap Diambil di Koperasi' }}
                </span>
            </div>
        </div>

        <!-- Rincian Barang Dipesan -->
        <div class="space-y-2.5 border-b border-dashed border-slate-300 pb-4 mb-4">
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Daftar Komoditas</div>
            @foreach($order->items as $item)
                <div>
                    <div class="flex justify-between items-start font-semibold text-xs">
                        <span class="text-slate-800 pr-2 leading-snug">
                            {{ $item->product->name ?? 'Barang Terhapus' }} <span class="font-mono text-slate-400 font-normal">x{{ $item->quantity }}</span>
                        </span>
                        <span class="font-mono text-slate-900 whitespace-nowrap">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </span>
                    </div>
                    @if($item->notes)
                        <div class="text-[10px] text-blue-700 font-medium italic mt-0.5 bg-blue-50/60 px-2 py-0.5 rounded border border-blue-100/80">
                            Catatan: {{ $item->notes }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Total Pembayaran -->
        <div class="space-y-2 mb-5">
            <div class="flex justify-between items-center font-extrabold text-base bg-slate-50 p-3 rounded-2xl border border-slate-100">
                <span class="text-slate-700 text-xs uppercase tracking-wider">TOTAL TAGIHAN:</span>
                <span class="font-mono text-blue-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-slate-400 text-[11px] px-1 font-medium">
                <span>Metode Transaksi:</span>
                <span class="font-semibold text-slate-600">Digital Siswa (Skanic Pay)</span>
            </div>
        </div>

        <!-- Barcode Simulation -->
        <div class="text-center py-2 border-t border-dashed border-slate-300">
            <div class="font-mono tracking-[0.4em] text-slate-400 text-[10px] select-none my-1">
                ||| | ||||| || |||| ||| ||||| | ||
            </div>
            <span class="font-mono text-[10px] text-slate-400 tracking-wider">{{ $order->order_code }}</span>
        </div>

        <!-- Footer Struk -->
        <div class="text-center pt-3 text-[11px] text-slate-400">
            <p>Tunjukkan struk ini kepada petugas koperasi saat mengambil pesanan.</p>
            <p class="mt-1 font-bold text-slate-700">Terima kasih & Semangat Belajar!</p>
        </div>
    </div>

</body>
</html>