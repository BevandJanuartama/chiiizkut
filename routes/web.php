<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Models\Produk;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // Ambil semua produk KECUALI yang hidden (untuk tampilan grid)
    $produks = Produk::with('varians')
        ->where('is_hidden', false)
        ->get();

    // Ambil produk Mix secara eksplisit
    $mixProduk = Produk::with('varians')
        ->where('nama_produk', 'Mix')
        ->first();
    
    // AMBIL BEST SELLER UNTUK TAMPILAN CUSTOMER
    $bestSellerProducts = DetailTransaksi::select(
            'produks.id',
            'produks.nama_produk',
            'produks.deskripsi',
            'produks.gambar',
            DB::raw('SUM(detail_transaksis.qty) as total_terjual')
        )
        ->join('produks', 'produks.id', '=', 'detail_transaksis.produk_id')
        ->join('transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
        ->where('transaksis.status', 'sukses')
        ->where('produks.is_hidden', false)
        ->groupBy('produks.id', 'produks.nama_produk', 'produks.deskripsi', 'produks.gambar')
        ->orderBy('total_terjual', 'DESC')
        ->limit(10)
        ->get();
    
    foreach ($bestSellerProducts as $bestSeller) {
        $bestSeller->varians = Produk::find($bestSeller->id)->varians ?? [];
        $bestSeller->harga = $bestSeller->varians && count($bestSeller->varians) > 0 
            ? min(array_column($bestSeller->varians->toArray(), 'harga')) 
            : 0;
    }
    
    return view('welcome', compact('produks', 'bestSellerProducts', 'mixProduk')); // ← tambah mixProduk
})->name('kiosk');

Route::post('/checkout', [TransaksiController::class, 'checkout'])->name('checkout');

Route::get('/nota/{kode_unik}', [TransaksiController::class, 'showNota'])->name('nota.show');


// --- 2. Authenticated Routes ---
Route::middleware('auth')->group(function () {

    // Bridge: Mengarahkan /dashboard ke route yang sesuai role
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'kasir') return redirect()->route('kasir.dashboard');
        abort(403, 'Role tidak terdaftar.');
    })->name('dashboard');

    // --- Rute Khusus Admin ---
    Route::middleware('can:admin')->prefix('admin')->group(function () {
        // Dashboard Admin (Full Info Statistik)
        Route::get('/dashboard', [ProdukController::class, 'dashboard'])->name('admin.dashboard');

        // Manajemen Produk (CRUD)
        Route::resource('produks', ProdukController::class);

        // Manajemen Stok
        Route::controller(ProdukController::class)->group(function () {
            Route::get('/stok/tambah', 'editStok')->name('stok.edit');
            Route::put('/stok/update', 'updateStok')->name('stok.update');
            Route::get('/stok/logs', 'stokLogs')->name('stok.logs');
        });
        
        // RUTE LAPORAN UNTUK ADMIN 
        // Laporan Pendapatan
        Route::get('/laporan/pendapatan', [LaporanController::class, 'pendapatan'])->name('laporan.pendapatan');
        
        // Laporan Pesanan
        Route::get('/laporan/pesanan', [LaporanController::class, 'pesanan'])->name('laporan.pesanan');

        Route::get('/laporan/pendapatan/export', [LaporanController::class, 'exportExcel'])->name('laporan.pendapatan.export');
        
    });

    // --- Rute Khusus Kasir ---
    Route::middleware('can:kasir')->prefix('kasir')->group(function () {
        Route::get('/dashboard', [TransaksiController::class, 'index'])->name('kasir.dashboard');
    });

    Route::middleware('can:kasir')->prefix('kasir')->group(function () {
        Route::get('/order', [TransaksiController::class, 'order'])->name('kasir.order');
    });

    // --- Rute Transaksi Umum (Bisa diakses Admin/Kasir) ---
    Route::patch('/transaksi/{id}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
    Route::resource('transaksis', TransaksiController::class)->except(['create', 'store']);

    // --- Profile Settings ---
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';