<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokLog extends Model
{
    protected $fillable = ['produk_varian_id', 'jumlah_masuk', 'stok_sebelumnya', 'stok_sesudahnya', 'keterangan'];

    public function produkVarian()
    {
        return $this->belongsTo(ProdukVarian::class);
    }
}
