@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h1 class="font-serif fw-bold mb-1">Detail Pendapatan</h1>
            <p class="text-muted mb-0">Lihat detail pendapatan berdasarkan periode yang dipilih</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mt-3 mt-md-0">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- Filter Tanggal -->
    <div class="card card-soft p-4 mb-4">
        <form method="GET" action="{{ route('laporan.pendapatan') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold small text-muted">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" 
                       value="{{ $startDate instanceof \Carbon\Carbon ? $startDate->format('Y-m-d') : date('Y-m-d', strtotime($startDate)) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold small text-muted">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" 
                       value="{{ $endDate instanceof \Carbon\Carbon ? $endDate->format('Y-m-d') : date('Y-m-d', strtotime($endDate)) }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100" style="background-color: var(--brand-yellow); border: none; color: var(--text-brown);">
                    <i class="bi bi-filter"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-md-4">
            <div class="card card-soft p-3 text-center">
                <i class="bi bi-cash-stack fs-1 text-brand-yellow"></i>
                <h5 class="mt-2 mb-1 text-muted">Total Pendapatan</h5>
                <h3 class="fw-bold text-brand-dark">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-soft p-3 text-center">
                <i class="bi bi-receipt fs-1 text-brand-yellow"></i>
                <h5 class="mt-2 mb-1 text-muted">Total Transaksi</h5>
                <h3 class="fw-bold text-brand-dark">{{ $totalTransaksi }} Transaksi</h3>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-soft p-3 text-center">
                <i class="bi bi-graph-up fs-1 text-brand-yellow"></i>
                <h5 class="mt-2 mb-1 text-muted">Rata-rata per Transaksi</h5>
                <h3 class="fw-bold text-brand-dark">Rp {{ number_format($rataRata, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Chart Total Pendapatan (BAR CHART - Hanya Pendapatan Sukses) -->
    <div class="card card-soft p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <h5 class="font-serif fw-bold mb-0">Grafik Total Pendapatan</h5>
            <div class="d-flex align-items-center gap-1">
                <div style="width: 16px; height: 16px; background-color: #F6AA1C; border-radius: 3px;"></div>
                <span class="small">Pendapatan (Rp)</span>
            </div>
        </div>
        
        <div style="position: relative; height: 400px; width: 100%;">
            <canvas id="pendapatanChart"></canvas>
        </div>
        <p class="text-center text-muted small mt-3 fw-medium mb-0">
            <i class="bi bi-calendar3"></i> Grafik pendapatan per tanggal (hanya transaksi yang sudah terkonfirmasi/sukses)
        </p>
    </div>

    <div class="row g-4">
        <!-- Pendapatan Per Hari -->
        <div class="col-md-6">
            <div class="card card-soft p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-serif fw-bold mb-0">Pendapatan Per Hari</h5>
                    <span class="badge bg-success">Sudah Terkonfirmasi</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah Transaksi</th>
                                <th>Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendapatanPerHari as $data)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $data->jumlah_transaksi }} Transaksi</td>
                                <td class="fw-bold text-success">Rp {{ number_format($data->total_pendapatan, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Tidak ada data transaksi sukses</td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($pendapatanPerHari->count() > 0)
                        <tfoot class="table-light">
                            <tr class="fw-bold">
                                <td>Total</td>
                                <td>{{ $pendapatanPerHari->sum('jumlah_transaksi') }} Transaksi</td>
                                <td class="text-success">Rp {{ number_format($pendapatanPerHari->sum('total_pendapatan'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Metode Pembayaran (Cash vs QRIS) -->
        <div class="col-md-6">
            <div class="card card-soft p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-serif fw-bold mb-0">Metode Pembayaran</h5>
                    <span class="badge bg-success">Sudah Terkonfirmasi</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Metode</th>
                                <th>Jumlah Transaksi</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $cashTotal = 0;
                                $cashCount = 0;
                                $qrisTotal = 0;
                                $qrisCount = 0;
                                
                                foreach($metodePembayaran as $metode) {
                                    if(strtolower($metode->metode_pembayaran) == 'cash') {
                                        $cashTotal = $metode->total;
                                        $cashCount = $metode->jumlah;
                                    } elseif(strtolower($metode->metode_pembayaran) == 'qris') {
                                        $qrisTotal = $metode->total;
                                        $qrisCount = $metode->jumlah;
                                    }
                                }
                            @endphp
                            
                            <!-- Cash -->
                            <tr>
                                <td>
                                    <i class="bi bi-cash fs-5 me-2 text-success"></i>
                                    <strong>Cash</strong>
                                </td>
                                <td>{{ $cashCount }} Transaksi</td>
                                <td class="fw-bold">Rp {{ number_format($cashTotal, 0, ',', '.') }}</td>
                            </tr>
                            
                            <!-- QRIS -->
                            <tr>
                                <td>
                                    <i class="bi bi-qr-code fs-5 me-2 text-primary"></i>
                                    <strong>QRIS</strong>
                                </td>
                                <td>{{ $qrisCount }} Transaksi</td>
                                <td class="fw-bold">Rp {{ number_format($qrisTotal, 0, ',', '.') }}</td>
                            </tr>
                            
                            @if($cashCount == 0 && $qrisCount == 0)
                            <tr>
                                <td colspan="3" class="text-center text-muted">Tidak ada data pembayaran</td>
                            </tr>
                            @endif
                        </tbody>
                        @if($cashCount > 0 || $qrisCount > 0)
                        <tfoot class="table-light">
                            <tr class="fw-bold">
                                <td>Total</td>
                                <td>{{ $cashCount + $qrisCount }} Transaksi</td>
                                <td>Rp {{ number_format($cashTotal + $qrisTotal, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Transaksi Terbaru (5 data terakhir yang sudah sukses) -->
    <div class="card card-soft p-4 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h5 class="font-serif fw-bold mb-0">Transaksi Terbaru Hari Ini</h5>
            <span class="badge bg-success">5 Data Terakhir (Terkonfirmasi)</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Antrean</th>
                        <th>Nama Pelanggan</th>
                        <th>Total</th>
                        <th>Metode Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis->take(5) as $transaksi)
                    <tr>
                        <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $transaksi->nomor_antrean }}</td>
                        <td>{{ $transaksi->nama ?? '-' }}</td>
                        <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                        <td>
                            @if($transaksi->metode_pembayaran == 'cash')
                                <i class="bi bi-cash me-1"></i> Cash
                            @elseif($transaksi->metode_pembayaran == 'qris')
                                <i class="bi bi-qr-code me-1"></i> QRIS
                            @else
                                {{ ucfirst($transaksi->metode_pembayaran ?? '-') }}
                            @endif
                         </td>
                        <td>
                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Sukses</span>
                         </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada transaksi sukses</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transaksis->count() > 5)
        <div class="text-center mt-3">
            <small class="text-muted">Menampilkan 5 dari {{ $transaksis->total() }} transaksi sukses</small>
            <br>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Data untuk chart dari pendapatanPerHari (SUDAH HANYA STATUS SUKSES)
    const pendapatanPerHari = @json($pendapatanPerHari);
    
    // Data sudah dalam urutan ASC dari controller
    const labels = pendapatanPerHari.map(item => {
        const date = new Date(item.tanggal);
        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    });
    
    const pendapatanData = pendapatanPerHari.map(item => item.total_pendapatan);
    
    // Contoh jika ingin menampilkan data contoh seperti yang diminta:
    // Tanggal 19: 250.000, Tanggal 22: 500.000
    console.log('Data Pendapatan per Hari:', pendapatanPerHari);
    
    const ctx = document.getElementById('pendapatanChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Total Pendapatan (Rp)',
                    data: pendapatanData,
                    backgroundColor: '#F6AA1C',
                    borderColor: '#D4890A',
                    borderWidth: 1,
                    borderRadius: 6,
                    barPercentage: 0.65,
                    categoryPercentage: 0.8,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return 'Pendapatan: Rp ' + value.toLocaleString('id-ID');
                        }
                    },
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 10,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'PENDAPATAN (Rp)',
                        font: {
                            size: 11,
                            weight: 'bold'
                        },
                        color: '#F6AA1C'
                    },
                    grid: {
                        borderDash: [5, 5],
                        color: '#E8E0D5',
                        drawBorder: true
                    },
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) {
                                return (value / 1000000).toFixed(1) + ' Jt';
                            } else if (value >= 1000) {
                                return (value / 1000).toFixed(0) + ' Rb';
                            }
                            return value;
                        },
                        stepSize: function(context) {
                            const max = Math.max(...pendapatanData);
                            if (max > 2000000) return 500000;
                            if (max > 1000000) return 250000;
                            if (max > 500000) return 100000;
                            if (max > 100000) return 50000;
                            return 25000;
                        },
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'TANGGAL',
                        font: {
                            size: 11,
                            weight: 'bold'
                        },
                        color: '#5C3D2E'
                    },
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0,
                        font: {
                            size: 11,
                            weight: '500'
                        },
                        autoSkip: true,
                        maxTicksLimit: 10
                    }
                }
            }
        }
    });
    
    // Handle resize untuk update chart
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            const chart = Chart.getChart('pendapatanChart');
            if (chart) {
                chart.resize();
                chart.update();
            }
        }, 250);
    });
});
</script>
@endpush

@push('styles')
<style>
    /* Responsive chart container */
    @media (max-width: 768px) {
        #pendapatanChart {
            max-height: 350px;
        }
    }
    
    @media (max-width: 576px) {
        #pendapatanChart {
            max-height: 300px;
        }
    }
</style>
@endpush
@endsection