<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen">
        <nav class="bg-white border-b border-gray-100 p-4 shadow">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <span class="font-bold text-xl text-indigo-600">Admin Panel</span>
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-indigo-600">Kembali ke Dashboard</a>
            </div>
        </nav>

        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Stok Produk</h2>
                        <a href="{{ route('produks.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg transition shadow-md">
                            + Tambah Produk Baru
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b bg-gray-50">
                                    <th class="p-4 text-sm font-bold text-gray-600 uppercase">Gambar</th>
                                    <th class="p-4 text-sm font-bold text-gray-600 uppercase">Nama Produk</th>
                                    <th class="p-4 text-sm font-bold text-gray-600 uppercase">Ukuran</th>
                                    <th class="p-4 text-sm font-bold text-gray-600 uppercase">Harga</th>
                                    <th class="p-4 text-sm font-bold text-gray-600 uppercase text-center">Stok</th>
                                    <th class="p-4 text-sm font-bold text-gray-600 uppercase text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($produks as $produk)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4">
                                        <img src="{{ asset('storage/'.$produk->gambar) }}" class="w-16 h-16 object-cover rounded-lg border shadow-sm">
                                    </td>
                                    <td class="p-4 font-semibold text-gray-800">{{ $produk->nama_produk }}</td>
                                    <td class="p-4">
                                        @if(is_array($produk->ukuran))
                                            @foreach($produk->ukuran as $sz)
                                                <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs mr-1 uppercase">{{ $sz }}</span>
                                            @endforeach
                                        @else
                                            {{ $produk->ukuran }}
                                        @endif
                                    </td>
                                    <td class="p-4 text-gray-600">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                    <td class="p-4 text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $produk->stok < 10 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                            {{ $produk->stok }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-right space-x-3">
                                        <a href="{{ route('produks.edit', $produk->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                        <form action="{{ route('produks.destroy', $produk->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>