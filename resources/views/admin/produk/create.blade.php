<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="max-w-3xl mx-auto py-12 px-4">
        <div class="bg-white shadow-lg sm:rounded-xl p-8 border border-gray-100">
            <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Input Produk Baru</h1>
            <p class="text-gray-500 mb-8 border-b pb-4">Isi formulir di bawah ini untuk menambahkan stok ke katalog.</p>

            <form action="{{ route('produks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Nama Produk</label>
                    <input type="text" name="nama_produk" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Kemeja Flanel Slim Fit" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Deskripsi Produk</label>
                    <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tuliskan spesifikasi produk..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Harga (Rupiah)</label>
                        <input type="number" name="harga" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="150000" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Stok Awal</label>
                        <input type="number" name="stok" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="10" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Ukuran (Pisahkan dengan koma)</label>
                    <input type="text" name="ukuran" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: S, M, L, XL" required>
                    <small class="text-gray-400 font-italic text-xs">*Gunakan koma sebagai pemisah antar ukuran.</small>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Foto Produk</label>
                    <input type="file" name="gambar" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                    <a href="{{ route('produks.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">Batal</a>
                    <button type="submit" class="bg-indigo-600 text-white px-8 py-2.5 rounded-lg font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>