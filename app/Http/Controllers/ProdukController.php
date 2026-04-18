<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukVarian;
use App\Models\StokLog;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProdukController extends Controller
{
    public function dashboard()
    {
        $pendapatanHariIni = Transaksi::where('status', 'sukses')
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        $totalPesananHariIni = Transaksi::whereDate('created_at', Carbon::today())->count();

        // 🔥 HITUNG DARI VARIAN
        $stokMenipis = ProdukVarian::where('stok', '<', 10)->count();

        $totalProduk = Produk::count();
        $pesananPending = Transaksi::where('status', 'pending')->count();

        $weeklySales = Transaksi::where('status', 'sukses')
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

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

    public function index()
    {
        $produks = Produk::with('varians')->get();
        return view('admin.produk.index', compact('produks'));
    }

    public function create()
    {
        return view('admin.produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required',
            'harga_small' => 'required|numeric',
            'harga_large' => 'required|numeric',
            'gambar'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('gambar')->store('produk_images', 'public');

        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $path,
        ]);

        // AUTO VARIAN + STOK 0
        ProdukVarian::create([
            'produk_id' => $produk->id,
            'ukuran'    => 'small',
            'harga'     => $request->harga_small,
            'stok'      => 0,
        ]);

        ProdukVarian::create([
            'produk_id' => $produk->id,
            'ukuran'    => 'large',
            'harga'     => $request->harga_large,
            'stok'      => 0,
        ]);

        return redirect()->route('produks.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Produk $produk)
    {
        $produk->load('varians');
        return view('admin.produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required',
            'harga_small' => 'required|numeric',
            'harga_large' => 'required|numeric',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($produk->gambar);
            $produk->gambar = $request->file('gambar')->store('produk_images', 'public');
        }

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $produk->gambar,
        ]);

        // UPDATE VARIAN
        $produk->varians()->updateOrCreate(
            ['ukuran' => 'small'],
            ['harga' => $request->harga_small]
        );

        $produk->varians()->updateOrCreate(
            ['ukuran' => 'large'],
            ['harga' => $request->harga_large]
        );

        return redirect()->route('produks.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();
        return redirect()->route('produks.index')->with('success', 'Produk berhasil dihapus!');
    }

    // 🔥 FIX: LOAD VARIAN
    public function editStok()
    {
        $produks = Produk::with('varians')->get();
        return view('admin.produk.stok', compact('produks'));
    }

    // 🔥 FIX TOTAL
    public function updateStok(Request $request)
    {
        $request->validate([
            'produk_varian_id' => 'required|exists:produk_varians,id',
            'jumlah_stok' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        return DB::transaction(function () use ($request) {

            $varian = ProdukVarian::findOrFail($request->produk_varian_id);

            $stokAwal = $varian->stok;
            $stokBaru = $stokAwal + $request->jumlah_stok;

            $varian->update([
                'stok' => $stokBaru
            ]);

            StokLog::create([
                'produk_varian_id' => $varian->id,
                'jumlah_masuk' => $request->jumlah_stok,
                'stok_sebelumnya' => $stokAwal,
                'stok_sesudahnya' => $stokBaru,
                'keterangan' => $request->keterangan
            ]);

            return redirect()->route('stok.logs')->with('success', 'Stok berhasil ditambah!');
        });
    }

    public function stokLogs()
    {
        $logs = StokLog::with('produkVarian.produk')->latest()->get();
        return view('admin.produk.stok_logs', compact('logs'));
    }
}