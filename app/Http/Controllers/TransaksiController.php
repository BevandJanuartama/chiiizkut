<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Events\StokUpdated;
use App\Events\PesananBaru;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('details.produk')
            ->orderBy('created_at', 'desc')
            ->paginate(7); 

        return view('kasir.dashboard', compact('transaksis'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:sukses,gagal']);

        $transaksi = Transaksi::with('details.produk')->findOrFail($id);

        // ===============================
        // BALIKIN STOK JIKA GAGAL
        // ===============================
        if ($request->status == 'gagal' && $transaksi->status != 'gagal') {
            foreach ($transaksi->details as $detail) {
                $detail->produk->increment('stok', $detail->qty);
            }
        }

        // ===============================
        // UPDATE STATUS
        // ===============================
        $transaksi->update(['status' => $request->status]);

        // ===============================
        // KIRIM WA JIKA SUKSES
        // ===============================
        if ($request->status == 'sukses' && $transaksi->telepon) {
            $phone = preg_replace('/[^0-9]/', '', $transaksi->telepon);
            if (substr($phone, 0, 1) == '0') $phone = '62' . substr($phone, 1);

            $urlNota = route('nota.show', $transaksi->kode_unik);

            $message = "🧾 *FAKTUR ELEKTRONIK*\n";
            $message .= "*CHIIIZKUT*\n\n";
            
            $message .= "Nomor Nota:\n";
            $message .= "*{$transaksi->kode_unik}*\n\n";

            $message .= "Pelanggan Yth:\n";
            $message .= "Kak {$transaksi->nama}\n\n";

            $message .= "=========================\n";
            $message .= "Total Tagihan: *Rp " . number_format($transaksi->total) . "*\n";
            $message .= "Status: *LUNAS*\n";
            $message .= "=========================\n\n";

            $message .= "Klik link di bawah ini untuk melihat detail nota dan rincian pesanan:\n";
            $message .= "🔗 {$urlNota}\n\n";
            
            $message .= "Terima kasih telah berbelanja di CHIIIZKUT! 🙌";

            Http::withHeaders([
                'Authorization' => env('FONNTE_TOKEN')
            ])->post('https://api.fonnte.com/send', [
                'target' => $phone,
                'message' => $message,
            ]);
        }

        return redirect()->route('kasir.dashboard')
            ->with('success', 'Status Pesanan #' . $transaksi->nomor_antrean . ' diperbarui.');
    }

    public function showNota($kode_unik)
    {
        // Cari berdasarkan kode_unik, bukan ID
        $transaksi = Transaksi::with('details.produk')->where('kode_unik', $kode_unik)->firstOrFail();
        
        return view('nota_online', compact('transaksi'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
            'name' => 'nullable|string',
            'phone' => 'nullable|string',
            'payment_method' => 'nullable|string',
        ]);

        try {
            $result = DB::transaction(function () use ($request) {
                $lastOrder = Transaksi::whereDate('created_at', now()->toDateString())->count();
                $queueNumber = $lastOrder + 1;
                
                // Generate kode unik acak
                $kodeUnik = strtoupper(bin2hex(random_bytes(6))); // Contoh: A1B2C3D4E5F6

                $transaksi = Transaksi::create([
                    'nama' => $request->name,
                    'telepon' => $request->phone,
                    'total' => $request->total,
                    'metode_pembayaran' => $request->payment_method,
                    'nomor_antrean' => $queueNumber,
                    'status' => 'pending',
                    'kode_unik' => $kodeUnik, // Simpan kode unik
                ]);

                foreach ($request->items as $item) {
                    $produk = Produk::findOrFail($item['id']);

                    if ($produk->stok < $item['qty']) {
                        throw new \Exception("Stok {$produk->nama_produk} tidak cukup!");
                    }

                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'produk_id'    => $item['id'],
                        'qty'          => $item['qty'],
                        'harga_satuan' => $item['price'],
                        'subtotal'     => $item['price'] * $item['qty'],
                    ]);

                    $produk->decrement('stok', $item['qty']);

                    broadcast(new StokUpdated($produk->id, $produk->stok));
                }

                return [
                    'queue_number' => $queueNumber,
                    'transaksi_id' => $transaksi->id
                ];
            });

            // Broadcast pesanan baru
            $jumlahPending = Transaksi::where('status', 'pending')->count();
            broadcast(new PesananBaru($jumlahPending));

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'queue_number' => $result['queue_number']
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
