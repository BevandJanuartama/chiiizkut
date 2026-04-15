<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Models\Produk;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. Public Routes ---
Route::get('/', function () {
    $produks = Produk::all();
    return view('welcome', compact('produks'));
})->name('kiosk');

Route::post('/checkout', [TransaksiController::class, 'checkout'])->name('checkout');


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
    });

    // --- Rute Khusus Kasir ---
    Route::middleware('can:kasir')->prefix('kasir')->group(function () {
        Route::get('/dashboard', [TransaksiController::class, 'index'])->name('kasir.dashboard');
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