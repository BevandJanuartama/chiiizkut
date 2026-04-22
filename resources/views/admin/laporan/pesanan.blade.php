@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <div>
                <h1 class="font-serif fw-bold mb-1">Detail Pesanan</h1>
                <p class="text-muted mb-0">Lihat detail pesanan berdasarkan periode yang dipilih</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mt-3 mt-md-0">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Filter Tanggal -->
        <div class="card card-soft p-4 mb-4">
            <form method="GET" action="{{ route('laporan.pesanan') }}" class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold small text-muted">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control"
                        value="{{ $startDate instanceof \Carbon\Carbon ? $startDate->format('Y-m-d') : date('Y-m-d', strtotime($startDate)) }}">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold small text-muted">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control"
                        value="{{ $endDate instanceof \Carbon\Carbon ? $endDate->format('Y-m-d') : date('Y-m-d', strtotime($endDate)) }}">
                </div>
                <div class="col-12 col-md-4">
                    <button type="submit" class="btn btn-primary w-100"
                        style="background-color: var(--brand-yellow); border: none; color: var(--text-brown);">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistik Cards (Total Pesanan, Pending, Sukses, Gagal) -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card card-soft p-3 text-center">
                    <i class="bi bi-cart fs-1 text-brand-yellow"></i>
                    <h5 class="mt-2 mb-1 text-muted small">Total Pesanan</h5>
                    <h3 class="fw-bold text-brand-dark mb-0">{{ $statistik['total'] }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-soft p-3 text-center">
                    <i class="bi bi-clock-history fs-1 text-warning"></i>
                    <h5 class="mt-2 mb-1 text-muted small">Pending</h5>
                    <h3 class="fw-bold text-warning mb-0">{{ $statistik['pending'] }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-soft p-3 text-center">
                    <i class="bi bi-check-circle fs-1 text-success"></i>
                    <h5 class="mt-2 mb-1 text-muted small">Sukses</h5>
                    <h3 class="fw-bold text-success mb-0">{{ $statistik['sukses'] }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-soft p-3 text-center">
                    <i class="bi bi-x-circle fs-1 text-danger"></i>
                    <h5 class="mt-2 mb-1 text-muted small">Gagal</h5>
                    <h3 class="fw-bold text-danger mb-0">{{ $statistik['gagal'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Grafik Pesanan Per Hari -->
        <div class="card card-soft p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center flex-wrap gap-2 mb-3">
                <h5 class="font-serif fw-bold mb-0">Grafik Pesanan Per Hari</h5>
                <div class="d-flex gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 14px; height: 14px; background-color: #28a745; border-radius: 3px;"></div>
                        <span class="small">Sukses</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 14px; height: 14px; background-color: #ffc107; border-radius: 3px;"></div>
                        <span class="small">Pending</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 14px; height: 14px; background-color: #dc3545; border-radius: 3px;"></div>
                        <span class="small">Gagal</span>
                    </div>
                </div>
            </div>

            <div style="position: relative; height: 400px; width: 100%; min-height: 300px;">
                <canvas id="pesananChart"></canvas>
            </div>
            <p class="text-center text-muted small mt-3 fw-medium mb-0">
                <i class="bi bi-calendar3"></i> Grafik jumlah pesanan per tanggal dalam periode yang dipilih
            </p>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Grafik Pesanan Per Hari (BAR CHART)
                const pesananPerHari = @json($pesananPerHari);

                // Jika tidak ada data, tampilkan chart kosong
                let labels = [];
                let suksesData = [];
                let pendingData = [];
                let gagalData = [];

                if (pesananPerHari && pesananPerHari.length > 0) {
                    // (Opsional) Jika Anda ingin membuang data kosong di akhir agar tidak menyisakan ruang kosong di kanan:
                    // Anda bisa memfilter array ini di sini, namun jika ini laporan berdasarkan rentang tanggal, 
                    // lebih baik dibiarkan dan kita perbaiki layout chart-nya saja di bawah.

                    // Format tanggal untuk display (urutan ASC dari controller)
                    labels = pesananPerHari.map(item => {
                        const date = new Date(item.tanggal);
                        return date.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'short'
                        });
                    });

                    suksesData = pesananPerHari.map(item => item.sukses);
                    pendingData = pesananPerHari.map(item => item.pending);
                    gagalData = pesananPerHari.map(item => item.gagal);
                }

                const ctx = document.getElementById('pesananChart').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Sukses',
                                data: suksesData,
                                backgroundColor: '#28a745',
                                borderColor: '#1e7e34',
                                borderWidth: 1,
                                borderRadius: 6,
                                barPercentage: 0.7,
                                categoryPercentage: 0.8,
                                maxBarThickness: 40 // Mencegah bar menjadi terlalu besar saat data sedikit
                            },
                            {
                                label: 'Pending',
                                data: pendingData,
                                backgroundColor: '#ffc107',
                                borderColor: '#d39e00',
                                borderWidth: 1,
                                borderRadius: 6,
                                barPercentage: 0.7,
                                categoryPercentage: 0.8,
                                maxBarThickness: 40 // Mencegah bar menjadi terlalu besar saat data sedikit
                            },
                            {
                                label: 'Gagal',
                                data: gagalData,
                                backgroundColor: '#dc3545',
                                borderColor: '#a71d2a',
                                borderWidth: 1,
                                borderRadius: 6,
                                barPercentage: 0.7,
                                categoryPercentage: 0.8,
                                maxBarThickness: 40 // Mencegah bar menjadi terlalu besar saat data sedikit
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // PENTING: Ubah ke false agar grafik memenuhi div container 100%
                        layout: {
                            padding: {
                                left: 10,
                                right: 20, // Memberikan sedikit ruang bernapas di kanan agar tidak terpotong
                                top: 10,
                                bottom: 10
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                display: false, // Legend sudah dibuat manual di HTML
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        let value = context.raw;
                                        return label + ': ' + value + ' pesanan';
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
                                    text: 'JUMLAH PESANAN',
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    },
                                    color: '#5C3D2E'
                                },
                                grid: {
                                    borderDash: [5, 5],
                                    color: '#E8E0D5',
                                    drawBorder: true
                                },
                                ticks: {
                                    stepSize: 1,
                                    precision: 0,
                                    font: {
                                        size: 11
                                    },
                                    callback: function(value) {
                                        return value + ' psn';
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'TANGGAL',
                                    font: {
                                        size: 12,
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
                        const chart = Chart.getChart('pesananChart');
                        if (chart) {
                            // Update rotasi label berdasarkan ukuran layar
                            const isMobile = window.innerWidth < 768;
                            chart.options.scales.x.ticks.maxRotation = isMobile ? 45 : 0;
                            chart.options.scales.x.ticks.minRotation = isMobile ? 45 : 0;
                            chart.update();
                        }
                    }, 250);
                });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            /* Card styling */
            .card-soft {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .card-soft:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            }

            /* Responsive chart container */
            @media (max-width: 768px) {
                #pesananChart {
                    max-height: 350px;
                }
            }

            @media (max-width: 576px) {
                #pesananChart {
                    max-height: 300px;
                }
            }
        </style>
    @endpush
@endsection
