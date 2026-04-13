<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    // Nama tabel secara eksplisit (opsional jika nama file sudah benar)
    protected $table = 'detail_transaksis';

    // Field yang boleh diisi secara massal
    // Sesuai dengan revisi migrasi terakhir kita, gunakan 'produk_id'
    protected $fillable = [
        'transaksi_id', 
        'produk_id', 
        'qty', 
        'harga_satuan', 
        'subtotal'
    ];

    /**
     * Relasi ke Header: Detail ini milik sebuah transaksi.
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    /**
     * Relasi ke Produk: Detail ini merujuk ke produk tertentu.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}