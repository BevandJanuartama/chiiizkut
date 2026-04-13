<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="max-w-3xl mx-auto py-12 px-4">
        <div class="bg-white shadow-lg sm:rounded-xl p-8 border border-gray-100">
            <h1 class="text-2xl font-extrabold text-gray-900 mb-2 text-indigo-600">Edit Produk</h1>
            <p class="text-gray-500 mb-8 border-b pb-4">Memperbarui informasi: <span class="font-bold">{{ $produk->nama_produk }}</span></p>

            <form action="{{ route('produks.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Nama Produk</label>
                    <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">{{ $produk->deskripsi }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Harga</label>
                        <input type="number" name="harga" value="{{ $produk->harga }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Stok</label>
                        <input type="number" name="stok" value="{{ $produk->stok }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Ukuran (Pisahkan dengan koma)</label>
                    <input type="text" name="ukuran" 
                           value="{{ is_array($produk->ukuran) ? implode(', ', $produk->ukuran) : $produk->ukuran }}" 
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-dashed border-gray-300">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 text-center">Pratinjau Foto Produk Saat Ini</label>
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('storage/'.$produk->gambar) }}" class="w-32 h-32 object-cover rounded-lg border shadow-sm">
                    </div>
                    <label class="block text-sm font-semibold text-gray-700">Ganti Foto (Kosongkan jika tidak diubah)</label>
                    <input type="file" name="gambar" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-white file:text-indigo-700 border">
                </div>

                <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                    <a href="{{ route('produks.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">Batal</a>
                    <button type="submit" class="bg-indigo-600 text-white px-8 py-2.5 rounded-lg font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">Update Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>