<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - ChiiiZkut.</title>
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
                    <h1 class="text-3xl font-black mb-2 text-indigo-600">Edit <span class="text-black italic">Informasi Produk</span></h1>
                    <p class="text-gray-500 mb-8 border-b-2 border-black pb-4 font-medium">Produk: <span class="text-black font-bold">{{ $produk->nama_produk }}</span></p>

                    <form action="{{ route('produks.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-black uppercase text-gray-700">Nama Produk</label>
                            <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" class="mt-1 block w-full rounded-xl border-2 border-black p-3 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        </div>

                        <div>
                            <label class="block text-sm font-black uppercase text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded-xl border-2 border-black p-3 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">{{ $produk->deskripsi }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-black uppercase text-gray-700">Harga</label>
                                <input type="number" name="harga" value="{{ $produk->harga }}" class="mt-1 block w-full rounded-xl border-2 border-black p-3 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                            </div>
                            <div>
                                <label class="block text-sm font-black uppercase text-gray-400">Stok (Read Only)</label>
                                <input type="number" name="stok" value="{{ $produk->stok }}" class="mt-1 block w-full rounded-xl border-2 border-gray-200 bg-gray-100 p-3 text-gray-400 cursor-not-allowed" readonly>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-black uppercase text-gray-700">Ukuran</label>
                            <input type="text" name="ukuran" value="{{ is_array($produk->ukuran) ? implode(', ', $produk->ukuran) : $produk->ukuran }}" class="mt-1 block w-full rounded-xl border-2 border-black p-3 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        </div>

                        <div class="bg-gray-50 p-6 rounded-2xl border-2 border-black border-dashed">
                            <label class="block text-sm font-black uppercase text-gray-700 mb-4 text-center">Foto Saat Ini</label>
                            <div class="flex justify-center mb-4">
                                <img src="{{ asset('storage/'.$produk->gambar) }}" class="w-32 h-32 object-cover rounded-xl border-4 border-black shadow-md">
                            </div>
                            <input type="file" name="gambar" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-2 file:border-black file:bg-white file:font-black">
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-6 border-t-2 border-black">
                            <a href="{{ route('produks.index') }}" class="font-bold text-gray-500">Batal</a>
                            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none transition-all">UPDATE DATA</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>