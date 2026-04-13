@extends('layouts.admin')
@section('title', 'Riwayat Stok')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
    <div>
        <h2 class="text-4xl font-black tracking-tight uppercase">Riwayat <span class="text-chiiiz italic">Masuk Barang</span></h2>
        <p class="text-gray-600 font-bold mt-1">Log aktivitas penambahan stok produk secara mendetail.</p>
    </div>
    <a href="{{ route('stok.edit') }}" class="bg-chiiiz text-black border-4 border-black px-6 py-3 rounded-xl font-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        TAMBAH STOK
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-400 border-4 border-black rounded-xl font-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        {{ session('success') }}
    </div>
@endif

<div class="card-neo bg-white overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="border-b-4 border-black bg-gray-50">
                <tr class="text-xs font-black uppercase tracking-widest text-gray-500">
                    <th class="p-5">Waktu / Tanggal</th>
                    <th class="p-5">Nama Produk</th>
                    <th class="p-5 text-center">Jumlah</th>
                    <th class="p-5 text-center">Perubahan Stok</th>
                    <th class="p-5">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y-4 divide-black font-bold">
                @forelse($logs as $log)
                <tr class="hover:bg-yellow-50 transition-colors">
                    <td class="p-5 text-sm">
                        <span class="block text-black">{{ $log->created_at->format('d M Y') }}</span>
                        <span class="text-gray-400 text-xs">{{ $log->created_at->format('H:i') }} WIB</span>
                    </td>
                    <td class="p-5">
                        <span class="text-black uppercase font-black">{{ $log->produk->nama_produk }}</span>
                    </td>
                    <td class="p-5 text-center">
                        <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full border-2 border-green-700 font-black">
                            +{{ $log->jumlah_masuk }}
                        </span>
                    </td>
                    <td class="p-5 text-center">
                        <div class="flex items-center justify-center gap-2 text-sm">
                            <span class="text-gray-400">{{ $log->stok_sebelumnya }}</span>
                            <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            <span class="text-black font-black">{{ $log->stok_sesudahnya }}</span>
                        </div>
                    </td>
                    <td class="p-5 italic text-gray-600 text-sm">
                        {{ $log->keterangan ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-10 text-center font-black text-gray-400 uppercase tracking-widest">
                        Belum ada riwayat stok masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection