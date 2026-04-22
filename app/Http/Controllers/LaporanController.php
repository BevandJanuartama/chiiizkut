<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Halaman detail pendapatan dengan filter tanggal
     */
    public function pendapatan(Request $request)
    {
        // Ambil parameter tanggal
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Set default tanggal (30 hari terakhir jika tidak ada filter)
        if (!$startDate) {
            $startDate = Carbon::now()->subDays(29)->startOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
        }
        
        if (!$endDate) {
            $endDate = Carbon::now()->endOfDay();
        } else {
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
        
        // Total pendapatan berdasarkan range tanggal (status sukses)
        $totalPendapatan = Transaksi::where('status', 'sukses')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');
        
        // Total transaksi sukses
        $totalTransaksi = Transaksi::where('status', 'sukses')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        
        // Rata-rata pendapatan per transaksi
        $rataRata = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;
        
        // Detail pendapatan per hari (HANYA status sukses)
        $pendapatanPerHari = Transaksi::where('status', 'sukses')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as jumlah_transaksi'),
                DB::raw('SUM(total) as total_pendapatan')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')  // Urut dari tanggal lama ke baru untuk chart
            ->get();
        
        // Metode pembayaran yang digunakan (HANYA status sukses)
        $metodePembayaran = Transaksi::where('status', 'sukses')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('metode_pembayaran', DB::raw('COUNT(*) as jumlah'), DB::raw('SUM(total) as total'))
            ->whereNotNull('metode_pembayaran')
            ->groupBy('metode_pembayaran')
            ->get();
        
        // Daftar transaksi terbaru (5 data terakhir yang sukses)
        $transaksis = Transaksi::with('details.produk')
            ->where('status', 'sukses')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        
        return view('admin.laporan.pendapatan', compact(
            'totalPendapatan',
            'totalTransaksi',
            'rataRata',
            'pendapatanPerHari',
            'metodePembayaran',
            'transaksis',
            'startDate',
            'endDate'
        ));
    }
    
    /**
     * Halaman detail pesanan dengan filter tanggal
     */
    public function pesanan(Request $request)
    {
        // Ambil parameter tanggal
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Set default tanggal
        if (!$startDate) {
            $startDate = Carbon::now()->subDays(29)->startOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
        }
        
        if (!$endDate) {
            $endDate = Carbon::now()->endOfDay();
        } else {
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
        
        // Statistik pesanan berdasarkan status
        $statistik = [
            'total' => Transaksi::whereBetween('created_at', [$startDate, $endDate])->count(),
            'pending' => Transaksi::whereBetween('created_at', [$startDate, $endDate])->where('status', 'pending')->count(),
            'sukses' => Transaksi::whereBetween('created_at', [$startDate, $endDate])->where('status', 'sukses')->count(),
            'gagal' => Transaksi::whereBetween('created_at', [$startDate, $endDate])->where('status', 'gagal')->count(),
        ];
        
        // Total pendapatan dari pesanan sukses
        $totalPendapatan = Transaksi::where('status', 'sukses')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');
        
        // Daftar pesanan lengkap dengan filter
        $pesanans = Transaksi::with('details.produk')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        
        // Pesanan per hari (untuk chart)
        $pesananPerHari = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as jumlah'),
                DB::raw('SUM(CASE WHEN status = "sukses" THEN 1 ELSE 0 END) as sukses'),
                DB::raw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending'),
                DB::raw('SUM(CASE WHEN status = "gagal" THEN 1 ELSE 0 END) as gagal')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();
        
        return view('admin.laporan.pesanan', compact(
            'statistik',
            'totalPendapatan',
            'pesanans',
            'pesananPerHari',
            'startDate',
            'endDate'
        ));
    }
}