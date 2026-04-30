<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
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
            ->orderBy('tanggal', 'ASC')
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
     * Halaman detail pesanan dengan filter tanggal, status, dan pencarian
     */
    public function pesanan(Request $request)
    {
        // 1. Ambil semua parameter dari URL
        $startDateRaw = $request->input('start_date');
        $endDateRaw = $request->input('end_date');
        $statusFilter = $request->input('status');
        $search = $request->input('search');

        // 2. Set default tanggal & format menjadi objek Carbon untuk query
        $parsedStartDate = $startDateRaw ? Carbon::parse($startDateRaw)->startOfDay() : Carbon::now()->subDays(29)->startOfDay();
        $parsedEndDate = $endDateRaw ? Carbon::parse($endDateRaw)->endOfDay() : Carbon::now()->endOfDay();

        // String tanggal (Y-m-d) untuk dikembalikan ke input view agar lebih stabil
        $startDate = $parsedStartDate->format('Y-m-d');
        $endDate = $parsedEndDate->format('Y-m-d');

        // 3. Statistik pesanan (TIDAK terpengaruh search/status agar angka di card tetap sesuai range tanggal)
        $statistik = [
            'total' => Transaksi::whereBetween('created_at', [$parsedStartDate, $parsedEndDate])->count(),
            'pending' => Transaksi::whereBetween('created_at', [$parsedStartDate, $parsedEndDate])->where('status', 'pending')->count(),
            'sukses' => Transaksi::whereBetween('created_at', [$parsedStartDate, $parsedEndDate])->where('status', 'sukses')->count(),
            'gagal' => Transaksi::whereBetween('created_at', [$parsedStartDate, $parsedEndDate])->where('status', 'gagal')->count(),
        ];

        $totalPendapatan = Transaksi::where('status', 'sukses')
            ->whereBetween('created_at', [$parsedStartDate, $parsedEndDate])
            ->sum('total');

        // 4. Query untuk Tabel Data Pesanan
        $queryPesanan = Transaksi::with('details.produk')
            ->whereBetween('created_at', [$parsedStartDate, $parsedEndDate]);

        // Filter dari Card Status (Abaikan jika statusnya 'all' atau kosong)
        if (!empty($statusFilter) && $statusFilter !== 'all') {
            $queryPesanan->where('status', $statusFilter);
        }

        // Filter dari Search Bar (Mencari berdasarkan ID Transaksi)
        if (!empty($search)) {
            $queryPesanan->where('id', 'like', "%{$search}%");
        }

        // Eksekusi paginasi
        $pesanans = $queryPesanan->orderBy('created_at', 'DESC')->paginate(10);

        // Bawa semua parameter ke link paginasi agar filter tidak reset saat pindah halaman
        $pesanans->appends($request->all());

        // 5. Data untuk Chart Awal
        $pesananPerHari = Transaksi::whereBetween('created_at', [$parsedStartDate, $parsedEndDate])
            ->select(
                DB::raw("DATE(CONVERT_TZ(created_at, '+00:00', '+08:00')) as tanggal"),
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
            'endDate',
            'statusFilter',
            'search'
        ));
    }
}
