<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Explicitly define the table name because it's not the English plural 'products'
    protected $table = 'produks';

    // Columns that can be filled via the request
    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'ukuran',
        'harga',
        'gambar',
        'stok',
    ];

    /**
     * If you chose to store 'ukuran' as a JSON array, 
     * use this cast to automatically convert it.
     */
    protected $casts = [
        'ukuran' => 'array',
    ];
}