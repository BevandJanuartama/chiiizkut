@extends('layouts.admin')
@section('title', 'Update Stok')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card-neo bg-white p-8">
        <header class="mb-8 border-b-4 border-black pb-4">
            <h1 class="text-3xl font-black uppercase tracking-tight">Update <span class="text-chiiiz italic">Stok Barang</span></h1>
            <p class="text-gray-500 font-bold mt-1">Tambahkan jumlah stok ke produk yang sudah ada.</p>
        </header>

        <form action="{{ route('stok.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-black uppercase mb-1 tracking-wider">Pilih Produk</label>
                <select name="produk_id" class="mt-1 block w-full rounded-xl border-4 border-black p-3 font-bold shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus:ring-0 focus:border-chiiiz" required>
                    <option value="" disabled selected>-- Pilih Barang --</option>
                    @foreach($produks as $produk)
                        <option value="{{ $produk->id }}">
                            {{ $produk->nama_produk }} (Stok saat ini: {{ $produk->stok }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-black uppercase mb-1 tracking-wider">Jumlah Tambahan</label>
                    <input type="number" name="jumlah_stok" min="1" class="mt-1 block w-full rounded-xl border-4 border-black p-3 font-bold shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus:ring-0 focus:border-chiiiz" placeholder="Misal: 50" required>
                    <small class="text-gray-400 font-bold text-[10px]">*Stok akan otomatis dijumlahkan</small>
                </div>

                <div>
                    <label class="block text-sm font-black uppercase mb-1 tracking-wider">Keterangan</label>
                    <input type="text" name="keterangan" class="mt-1 block w-full rounded-xl border-4 border-black p-3 font-bold shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus:ring-0 focus:border-chiiiz" placeholder="Contoh: Kiriman Gudang">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6">
                <a href="{{ route('stok.logs') }}" class="font-black text-gray-400 hover:text-black transition uppercase text-sm">Batal</a>
                <button type="submit" class="bg-green-500 text-black border-4 border-black px-8 py-3 rounded-xl font-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all">
                    SIMPAN PERUBAHAN
                </button>
            </div>
        </form>
    </div>
</div>
@endsection