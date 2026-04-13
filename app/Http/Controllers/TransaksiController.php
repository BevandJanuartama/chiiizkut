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
        // Validasi data yang masuk
        $request->validate([
            'total' => 'required|numeric',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
        ]);

        try {
            // Gunakan Database Transaction agar data aman (jika satu gagal, semua batal)
            return DB::transaction(function () use ($request) {
                
                // 1. Simpan ke tabel transaksis
                $transaksi = Transaksi::create([
                    'nama'    => $request->name,
                    'telepon' => $request->phone, // Pastikan ini menangkap key 'phone'
                    'total'   => $request->total,
                    'metode_pembayaran' => $request->payment_method,
                ]);

                // 2. Loop dan simpan ke tabel detail_transaksis
                // Di dalam DB::transaction loop:
                foreach ($request->items as $item) {
                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'produk_id'    => $item['id'],  // GANTI 'barang_id' menjadi 'produk_id' agar sinkron dengan migrasi & model
                        'qty'          => $item['qty'],
                        'harga_satuan' => $item['price'],
                        'subtotal'     => $item['price'] * $item['qty'],
                    ]);
                }

                // Berikan respon sukses dan ID transaksi untuk nomor antrean
                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil diproses',
                    'order_id' => $transaksi->id
                ], 201);
            });

        } catch (\Exception $e) {
            // Catat error di log jika terjadi kegagalan
            Log::error('Checkout Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pesanan. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}