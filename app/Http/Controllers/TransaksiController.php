<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    /**
     * Menyimpan transaksi dari Kiosk (AJAX/Fetch)
     */

    public function checkout(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                
                // 1. Hitung Nomor Antrean Hari Ini
                // Mencari transaksi terakhir di hari yang sama
                $lastOrder = Transaksi::whereDate('created_at', now()->toDateString())->count();
                $queueNumber = $lastOrder + 1;

                // 2. Simpan Transaksi Utama
                $transaksi = Transaksi::create([
                    'nama' => $request->name,
                    'telepon' => $request->phone,
                    'total' => $request->total,
                    'metode_pembayaran' => $request->payment_method,
                    'nomor_antrean' => $queueNumber, // Pastikan kolom ini ada di migrasi
                ]);

                // 3. Simpan Detail & Update Stok
                foreach ($request->items as $item) {
                    // Simpan Detail
                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'produk_id'    => $item['id'],
                        'qty'          => $item['qty'],
                        'harga_satuan' => $item['price'],
                        'subtotal'     => $item['price'] * $item['qty'],
                    ]);

                    // KURANGI STOK PRODUK
                    $produk = \App\Models\Produk::find($item['id']);
                    if ($produk->stok < $item['qty']) {
                        throw new \Exception("Stok untuk " . $produk->nama_produk . " tidak mencukupi!");
                    }
                    $produk->decrement('stok', $item['qty']);
                }

                return response()->json([
                    'success' => true,
                    'queue_number' => $queueNumber // Mengirim nomor antrean harian
                ], 201);
            });

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}