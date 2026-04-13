<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Models\Produk;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 1. Landing Page
Route::get('/', function () {
    $produks = Produk::all();
    return view('welcome', compact('produks'));
});

// 2. Dashboard Universal (Bridge)
// Ini adalah rute tengah. Jika user mengetik /dashboard, 
// dia akan dilempar ke dashboard sesuai role-nya.
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'kasir') {
        return redirect()->route('kasir.dashboard');
    }
    abort(403, 'Role tidak terdaftar.');
})->middleware(['auth'])->name('dashboard');

// 3. Grup Route dengan Proteksi Login (Auth)
Route::middleware('auth')->group(function () {
    
    // Rute Khusus Admin
    Route::get('/admin/dashboard', function () {
        if (Auth::user()->role !== 'admin') { abort(403); }
        return view('admin.dashboard');
    })->name('admin.dashboard');


    Route::resource('admin/produks', ProdukController::class);

    // Rute Khusus Kasir
    Route::get('/kasir/dashboard', function () {
        if (Auth::user()->role !== 'kasir') { abort(403); }
        return view('kasir.dashboard');
    })->name('kasir.dashboard');

    // Profile Settings (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
Route::resource('transaksis', TransaksiController::class);

require __DIR__.'/auth.php';