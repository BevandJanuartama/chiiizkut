<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Masukkan 'nama' jika kamu ingin menyimpan nama pelanggan dari Kiosk
    protected $fillable = ['nama', 'telepon', 'total', 'metode_pembayaran', 'nomor_antrean'];

    /**
     * Relasi ke Detail: Satu transaksi punya banyak baris detail.
     */
    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}