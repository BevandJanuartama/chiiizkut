<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Admin ChiiiZkut.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .bg-chiiiz { background-color: #F2AF17; }
        .text-chiiiz { color: #F2AF17; }
        .border-chiiiz { border-color: #F2AF17; }
        
        .card-neo {
            background: white;
            border: 3px solid black;
            border-radius: 1.5rem;
            box-shadow: 8px 8px 0px 0px rgba(0,0,0,1);
            transition: all 0.2s ease;
        }
    </style>
</head>
<body class="bg-gray-100 text-black">

    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 p-8 md:p-12">
            <header class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-4xl font-black tracking-tight">Manajemen <span class="text-chiiiz italic">Katalog Produk</span></h2>
                    <p class="text-gray-600 mt-1 font-medium">Lihat, edit, dan atur ketersediaan produk cake kamu.</p>
                </div>
                <a href="{{ route('produks.create') }}" class="bg-chiiiz text-black border-2 border-black px-6 py-3 rounded-xl font-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all">
                    + PRODUK BARU
                </a>
            </header>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-400 border-2 border-black rounded-xl font-bold shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card-neo overflow-hidden bg-white">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-4 border-black bg-gray-50">
                                <th class="p-5 text-sm font-black uppercase tracking-widest">Gambar</th>
                                <th class="p-5 text-sm font-black uppercase tracking-widest">Nama Produk</th>
                                <th class="p-5 text-sm font-black uppercase tracking-widest">Deskripsi</th>
                                <th class="p-5 text-sm font-black uppercase tracking-widest text-center">Stok Small</th>
                                <th class="p-5 text-sm font-black uppercase tracking-widest text-center">Stok Large</th>
                                <th class="p-5 text-sm font-black uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-gray-100 font-semibold">
                            @foreach ($produks as $produk)
                            @php
                                $varianSmall = $produk->varians->where('ukuran', 'small')->first();
                                $varianLarge = $produk->varians->where('ukuran', 'large')->first();
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-5">
                                    <img src="{{ asset('storage/'.$produk->gambar) }}" class="w-20 h-20 object-cover rounded-xl border-2 border-black shadow-sm">
                                </td>
                                <td class="p-5 text-lg font-bold">{{ $produk->nama_produk }}</td>
                                <td class="p-5 text-sm text-gray-600 max-w-xs">{{ Str::limit($produk->deskripsi, 60) }}</td>

                                {{-- Stok Small --}}
                                <td class="p-5 text-center">
                                    @if($varianSmall)
                                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg border-2 font-black text-sm
                                            {{ $varianSmall->stok <= 0 ? 'bg-red-100 border-red-400 text-red-600' : ($varianSmall->stok < 10 ? 'bg-yellow-100 border-yellow-400 text-yellow-700' : 'bg-green-100 border-green-400 text-green-700') }}">
                                            {{ $varianSmall->stok }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>

                                {{-- Stok Large --}}
                                <td class="p-5 text-center">
                                    @if($varianLarge)
                                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg border-2 font-black text-sm
                                            {{ $varianLarge->stok <= 0 ? 'bg-red-100 border-red-400 text-red-600' : ($varianLarge->stok < 10 ? 'bg-yellow-100 border-yellow-400 text-yellow-700' : 'bg-green-100 border-green-400 text-green-700') }}">
                                            {{ $varianLarge->stok }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>

                                <td class="p-5 text-right">
                                    <div class="flex justify-end items-center gap-4">
                                        <a href="{{ route('produks.edit', $produk->id) }}" class="text-blue-600 hover:underline font-black uppercase text-xs tracking-widest">Edit</a>
                                        <form action="{{ route('produks.destroy', $produk->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline font-black uppercase text-xs tracking-widest" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>
</html>