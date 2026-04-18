<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota {{ $transaksi->kode_unik }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-md mx-auto bg-white min-h-screen shadow-lg">
        <div class="bg-yellow-500 p-6 text-white text-center">
            <h1 class="text-2xl font-black tracking-widest">CHIIIZKUT</h1>
            <p class="text-sm opacity-90">Jl. Contoh Alamat No. 123, Banjarbaru</p>
        </div>

        <div class="p-5">
            <div class="text-center mb-6">
                <p class="text-gray-400 text-xs uppercase tracking-widest">Nomor Nota</p>
                <h2 class="text-lg font-bold text-gray-800">{{ $transaksi->kode_unik }}</h2>
            </div>

            <div class="flex justify-between mb-4 text-sm">
                <div>
                    <p class="text-gray-400">Pelanggan:</p>
                    <p class="font-bold">{{ $transaksi->nama }}</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-400">Tanggal:</p>
                    <p class="font-bold">{{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="border-t border-dashed border-gray-300 py-4">
                <p class="font-bold mb-3">Rincian Pesanan:</p>
                @foreach($transaksi->details as $detail)
                <div class="flex justify-between mb-2">
                    <span class="text-sm text-gray-600">
                        {{ $detail->qty }}x {{ $detail->varian->produk->nama_produk }}
                        <span class="text-xs text-gray-400 uppercase">({{ $detail->varian->ukuran }})</span>
                    </span>
                    <span class="text-sm font-semibold">Rp {{ number_format($detail->subtotal) }}</span>
                </div>
                @endforeach
            </div>

            <div class="border-t-2 border-gray-800 pt-4 mt-4">
                <div class="flex justify-between items-center text-xl font-black">
                    <span>TOTAL</span>
                    <span>Rp {{ number_format($transaksi->total) }}</span>
                </div>
                <p class="text-right text-xs text-green-600 font-bold mt-1 uppercase">● {{ $transaksi->status }} / Lunas</p>
            </div>

            <div class="mt-10 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-[10px] text-gray-500 leading-relaxed">
                    <strong>PERHATIAN:</strong><br>
                    1. Nota ini adalah bukti pembayaran sah.<br>
                    2. Mohon periksa kembali pesanan sebelum meninggalkan outlet.<br>
                    3. Kritik & Saran: 0812-xxxx-xxxx
                </p>
            </div>
            
            <div class="text-center mt-10 pb-10">
                <p class="text-xs text-gray-400 uppercase tracking-tighter italic">Powered by Chiiizkut System</p>
            </div>
        </div>
    </div>
</body>
</html>