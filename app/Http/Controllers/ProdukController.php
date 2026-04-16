<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\StokLog;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Events\StokUpdated;
use Carbon\Carbon;

class ProdukController extends Controller
{
    public function dashboard()
    {
        // Statistik Ringkas (Top Cards)
        $pendapatanHariIni = Transaksi::where('status', 'sukses')
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        $totalPesananHariIni = Transaksi::whereDate('created_at', Carbon::today())->count();
        $stokMenipis = Produk::where('stok', '<', 10)->count();
        $totalProduk = Produk::count();

        // ---> INI TAMBAHAN BARUNYA: Mengambil data jumlah pesanan yang statusnya 'pending'
        $pesananPending = Transaksi::where('status', 'pending')->count();

        // Data Grafik Penjualan 7 Hari Terakhir
        $weeklySales = Transaksi::where('status', 'sukses')
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Data Produk Terlaris (Top 5)
        $topProducts = DetailTransaksi::select('produks.nama_produk', DB::raw('SUM(qty) as total_qty'))
            ->join('produks', 'produks.id', '=', 'detail_transaksis.produk_id')
            ->join('transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
            ->where('transaksis.status', 'sukses')
            ->groupBy('produks.nama_produk')
            ->orderBy('total_qty', 'DESC')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'pendapatanHariIni',
            'totalPesananHariIni',
            'stokMenipis',
            'totalProduk',
            'weeklySales',
            'topProducts',
            'pesananPending' 
        ));
    }


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

    public function updateStok(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah_stok' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $produk = \App\Models\Produk::findOrFail($request->produk_id);
                $stokAwal = $produk->stok;
                $stokBaru = $stokAwal + $request->jumlah_stok;

                // 1. Update stok di database
                $produk->update(['stok' => $stokBaru]);

                // 2. Catat log stok
                \App\Models\StokLog::create([
                    'produk_id' => $produk->id,
                    'jumlah_masuk' => $request->jumlah_stok,
                    'stok_sebelumnya' => $stokAwal,
                    'stok_sesudahnya' => $stokBaru,
                    'keterangan' => $request->keterangan ?? 'Stok Masuk Baru',
                ]);

                // 3. BROADCAST: Update ke semua layar user/pembeli
                broadcast(new \App\Events\StokUpdated($produk->id, $stokBaru))->toOthers();

                return redirect()->route('stok.logs')->with('success', "Stok {$produk->nama_produk} berhasil ditambah!");
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update stok: ' . $e->getMessage());
        }
    }

    public function stokLogs()
    {
        // Mengambil data log beserta relasi produknya, diurutkan dari yang terbaru
        $logs = StokLog::with('produk')->latest()->get();

        // Mengarahkan ke file blade yang tadi kita buat
        return view('admin.produk.stok_logs', compact('logs'));
    }
}
