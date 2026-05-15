<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; // Tambahkan ini
use PhpOffice\PhpSpreadsheet\Style\NumberFormat; // Tambahkan ini

class PendapatanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
{
    public function collection()
    {
        return Transaksi::with(['details.produk'])
            ->where('status', 'sukses')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Pelanggan',
            'Telepon',
            'Detail Produk (Qty)',
            'Metode Pembayaran',
            'Waktu Transaksi',
            'Total',
        ];
    }

    // Mengatur format kolom secara otomatis
    public function columnFormats(): array
    {
        return [
            // Kolom G (Total) diatur format Rupiah
            'G' => '"Rp "#,##0', 
        ];
    }

    public function map($transaksi): array
    {
        $detailProduk = $transaksi->details->map(function ($detail) {
            $produk = $detail->produk;
            if ($produk) {
                return $produk->nama_produk . ' (' . $detail->qty . ')';
            }
            return "ID #" . $detail->produk_id . " Tidak Ditemukan (" . $detail->qty . ")";
        })->implode(', ');

        return [
            $transaksi->id,
            $transaksi->nama,
            $transaksi->telepon,
            $detailProduk, 
            strtoupper($transaksi->metode_pembayaran),
            $transaksi->created_at->format('d/m/Y H:i:s'),
            $transaksi->total, 
        ];
    }
}