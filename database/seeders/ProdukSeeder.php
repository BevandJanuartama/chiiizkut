<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\StokLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan data lama (opsional - hati-hati jika di production)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Produk::truncate();
        StokLog::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Data Produk Contoh
        $produks = [
            [
                'nama_produk' => 'Original Chiiizkut',
                'deskripsi'   => 'Camilan keju renyah dengan rasa otentik yang lumer di mulut.',
                'ukuran'      => 'Reguler',
                'harga'       => 25000,
                'gambar'      => 'original.jpg',
                'stok'        => 50,
            ],
            [
                'nama_produk' => 'Spicy Chiiizkut',
                'deskripsi'   => 'Sensasi pedas membara berpadu dengan gurihnya keju pilihan.',
                'ukuran'      => 'Reguler',
                'harga'       => 27000,
                'gambar'      => 'spicy.jpg',
                'stok'        => 30,
            ],
            [
                'nama_produk' => 'Chiiizkut Bucket Family',
                'deskripsi'   => 'Porsi besar untuk dinikmati bersama keluarga atau teman-teman.',
                'ukuran'      => 'Large',
                'harga'       => 85000,
                'gambar'      => 'bucket.jpg',
                'stok'        => 15,
            ],
            [
                'nama_produk' => 'Chiiizkut Chocolate Dip',
                'deskripsi'   => 'Stik keju gurih dengan saus celup cokelat Belgia.',
                'ukuran'      => 'Medium',
                'harga'       => 35000,
                'gambar'      => 'choco.jpg',
                'stok'        => 20,
            ],
        ];

        // 3. Loop dan simpan ke database
        foreach ($produks as $data) {
            $produk = Produk::create($data);

            // 4. Catat histori stok awal ke StokLog
            StokLog::create([
                'produk_id'       => $produk->id,
                'jumlah_masuk'    => $data['stok'],
                'stok_sebelumnya' => 0,
                'stok_sesudahnya' => $data['stok'],
                'keterangan'      => 'Stok awal sistem (Seeder)',
            ]);
        }
    }
}