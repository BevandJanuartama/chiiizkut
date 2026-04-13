<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\StokLog;
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
        // 1. Hapus 'stok' dari validasi karena tidak ada di form
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required',
            'ukuran'      => 'required', 
            'harga'       => 'required|numeric',
            'gambar'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Ubah string ke array untuk ukuran
        $ukuranArray = explode(',', $request->ukuran);
        $ukuranClean = array_map('trim', $ukuranArray);

        // 3. Handle upload gambar
        $path = $request->file('gambar')->store('produk_images', 'public');

        // 4. Simpan ke database
        Produk::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'ukuran'      => $ukuranClean,
            'harga'       => $request->harga,
            'stok'        => 0, // Set otomatis 0 di sini
            'gambar'      => $path,
        ]);

        return redirect()->route('produks.index')->with('success', 'Produk berhasil ditambahkan dengan stok awal 0!');
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

    public function editStok()
    {
        $produks = Produk::all();
        // Sesuaikan path view dengan struktur folder admin kamu
        return view('admin.produk.stok', compact('produks'));
    }

    public function updateStok(Request $request) {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah_stok' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $stokAwal = $produk->stok;
        $stokBaru = $stokAwal + $request->jumlah_stok;

        $produk->update(['stok' => $stokBaru]);

        StokLog::create([
            'produk_id' => $produk->id,
            'jumlah_masuk' => $request->jumlah_stok,
            'stok_sebelumnya' => $stokAwal,
            'stok_sesudahnya' => $stokBaru,
            'keterangan' => $request->keterangan ?? 'Stok Masuk Baru',
        ]);

        return redirect()->route('stok.logs')->with('success', "Stok {$produk->nama_produk} berhasil ditambah!");
    }

    public function stokLogs()
    {
        // Mengambil data log beserta relasi produknya, diurutkan dari yang terbaru
        $logs = StokLog::with('produk')->latest()->get();

        // Mengarahkan ke file blade yang tadi kita buat
        return view('admin.produk.stok_logs', compact('logs'));
    }
    
}