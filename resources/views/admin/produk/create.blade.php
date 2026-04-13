<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - ChiiiZkut.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-chiiiz { background-color: #F2AF17; }
        .card-neo { background: white; border: 3px solid black; border-radius: 1.5rem; box-shadow: 8px 8px 0px 0px rgba(0,0,0,1); }
    </style>
</head>
<body class="bg-gray-100 text-black">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 p-8 md:p-12">
            <div class="max-w-3xl mx-auto">
                <div class="card-neo p-8 bg-white">
                    <h1 class="text-3xl font-black mb-2">Input <span class="text-chiiiz italic">Produk Baru</span></h1>
                    <p class="text-gray-500 mb-8 border-b-2 border-black pb-4 font-medium">Isi formulir untuk menambahkan menu cake baru.</p>

                    <form action="{{ route('produks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-black uppercase text-gray-700">Nama Produk</label>
                            <input type="text" name="nama_produk" class="mt-1 block w-full rounded-xl border-2 border-black p-3 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus:ring-0 focus:border-chiiiz" placeholder="Contoh: Chiiiz Cake Berry" required>
                        </div>

                        <div>
                            <label class="block text-sm font-black uppercase text-gray-700">Deskripsi Produk</label>
                            <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded-xl border-2 border-black p-3 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus:ring-0 focus:border-chiiiz" placeholder="Tuliskan spesifikasi produk..."></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-black uppercase text-gray-700">Harga (Rupiah)</label>
                                <input type="number" name="harga" class="mt-1 block w-full rounded-xl border-2 border-black p-3 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus:ring-0" placeholder="150000" required>
                            </div>
                            <div>
                                <label class="block text-sm font-black uppercase text-gray-700">Ukuran</label>
                                <input type="text" name="ukuran" class="mt-1 block w-full rounded-xl border-2 border-black p-3 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]" placeholder="S, M, L" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-black uppercase text-gray-700">Foto Produk</label>
                            <input type="file" name="gambar" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-2 file:border-black file:font-black file:bg-chiiiz file:text-black" required>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-6 border-t-2 border-black">
                            <a href="{{ route('produks.index') }}" class="font-bold text-gray-500">Batal</a>
                            <button type="submit" class="bg-black text-white px-8 py-3 rounded-xl font-black shadow-[4px_4px_0px_0px_rgba(242,175,23,1)] hover:shadow-none transition-all">SIMPAN PRODUK</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>