<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan - {{ $order->order_code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen py-8 px-4 flex flex-col items-center">

    <!-- Tombol Navigasi (Sembunyi saat cetak) -->
    <div class="w-full max-w-sm flex justify-between items-center mb-4 no-print">
        <a href="{{ route('buyer.orders') }}" class="text-xs text-slate-600 hover:text-slate-900 font-medium">
            &larr; Kembali ke Pesanan
        </a>
        <button onclick="window.print()" class="px-3 py-1.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl text-xs font-semibold shadow-sm transition">
            Cetak Struk
        </button>
    </div>

    <!-- Kertas Struk -->
    <div class="w-full max-w-sm bg-white p-6 rounded-2xl shadow-sm border border-slate-200 text-slate-800 text-xs font-mono">
        <!-- Kop Struk -->
        <div class="text-center border-b border-dashed border-slate-300 pb-4 mb-4">
            <h1 class="text-base font-bold font-sans tracking-wide">KOPERASI SKANIC</h1>
            <p class="text-[10px] text-slate-500 font-sans mt-0.5">Bukti Pemesanan & Pengambilan Barang</p>
            <div class="mt-3 inline-block bg-blue-50 border border-blue-200 px-3 py-1 rounded-lg">
                <span class="text-xs font-bold text-blue-900 font-sans">{{ $order->order_code }}</span>
            </div>
        </div>

        <!-- Info Pemesan -->
        <div class="space-y-1 border-b border-dashed border-slate-300 pb-3 mb-3 text-[11px]">
            <div class="flex justify-between">
                <span class="text-slate-500">Waktu:</span>
                <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Nama Siswa:</span>
                <span class="font-bold">{{ $order->user->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Status Ambil:</span>
                <span class="uppercase font-bold {{ $order->order_status === 'completed' ? 'text-emerald-600' : 'text-amber-600' }}">
                    {{ $order->order_status === 'completed' ? 'Sudah Selesai' : 'Siap Diambil' }}
                </span>
            </div>
        </div>

        <!-- Rincian Barang Dipesan -->
        <div class="space-y-2 border-b border-dashed border-slate-300 pb-3 mb-3">
            @foreach($order->items as $item)
                <div>
                    <div class="flex justify-between font-semibold">
                        <span>{{ $item->product->name ?? 'Barang Terhapus' }} x{{ $item->quantity }}</span>
                        <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                    @if($item->notes)
                        <div class="text-[10px] text-blue-600 italic">Catatan: {{ $item->notes }}</div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Total Pembayaran -->
        <div class="space-y-1 mb-4 text-[11px]">
            <div class="flex justify-between font-bold text-sm">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-slate-500 text-[10px]">
                <span>Metode Bayar:</span>
                <span>Lunas (Digital)</span>
            </div>
        </div>

        <!-- Footer Struk -->
        <div class="text-center border-t border-dashed border-slate-300 pt-3 text-[10px] text-slate-400 font-sans">
            <p>Tunjukkan struk ini atau sebutkan kode pesanan ke penjaga koperasi.</p>
            <p class="mt-1 font-semibold text-slate-600">Terima kasih!</p>
        </div>
    </div>

</body>
</html>