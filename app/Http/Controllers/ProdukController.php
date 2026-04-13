<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // 1. Menampilkan Daftar Produk
    public function index()
    {
        $produks = Produk::all();
        // Pastikan folder view sesuai: resources/views/admin/produk/index.blade.php
        return view('admin.produk.index', compact('produks'));
    }

    // 2. Menampilkan Form Tambah Produk (PENTING: Tadi ini yang hilang)
    public function create()
    {
        return view('admin.produk.create');
    }

    // 3. Menyimpan Produk Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required',
            'ukuran'      => 'required', // User menginput: "S, M, L"
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // UBAH STRING KE ARRAY (Agar sinkron dengan Model $casts)
        $ukuranArray = explode(',', $request->ukuran);
        $ukuranClean = array_map('trim', $ukuranArray);

        $path = $request->file('gambar')->store('produk_images', 'public');

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'ukuran'      => $ukuranClean, // Simpan sebagai array
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'gambar'      => $path,
        ]);

        return redirect()->route('produks.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // 4. Menampilkan Form Edit (PENTING: Tadi ini juga belum ada)
    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk'));
    }

    // 5. Memperbarui Data Produk
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required',
            'ukuran'      => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // UBAH STRING KE ARRAY
        $ukuranArray = explode(',', $request->ukuran);
        $ukuranClean = array_map('trim', $ukuranArray);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($produk->gambar);
            $path = $request->file('gambar')->store('produk_images', 'public');
            $produk->gambar = $path;
        }

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'ukuran'      => $ukuranClean, // Update sebagai array
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'gambar'      => $produk->gambar,
        ]);

        return redirect()->route('produks.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // 6. Menghapus Produk
    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }
        
        $produk->delete();
        return redirect()->route('produks.index')->with('success', 'Produk berhasil dihapus!');
    }

    
}