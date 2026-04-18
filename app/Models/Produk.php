<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'gambar',
    ];

    /**
     * Relasi ke varian (1 produk punya banyak varian)
     */
    public function varians()
    {
        return $this->hasMany(ProdukVarian::class);
    }
}