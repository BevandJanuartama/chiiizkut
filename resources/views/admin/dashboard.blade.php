@extends('layouts.admin')

@section('content')
    <header class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mb-md-5 gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: #8A4117; font-family: 'Lora', serif; font-weight: 1000; font-size: 40px;">
                Halo <span style="color: #F6AA1C;">Admin</span>
            </h2>
            <p class="text-muted mb-0 small fs-md-base">Siap mengecek performa toko hari ini?</p>
        </div>
    </header>

    <div class="d-flex justify-content-between align-items-end mb-3">
        <h4 class="font-serif fw-bold mb-0 fs-5 fs-md-4">Highlight Toko</h4>
        <span class="text-muted small fw-semibold">{{ now()->isoFormat('D MMMM YYYY') }}</span>
    </div>

    <section class="row g-3 g-md-4 mb-4 mb-md-5">
        <div class="col-12 col-lg-6">
            <div class="card promo-card-1 p-3 p-md-4 h-100 position-relative overflow-hidden">
                <span class="badge bg-white text-dark rounded-pill mb-2 mb-md-3"
                    style="width: fit-content; font-size: 0.65rem;">HARI INI</span>
                <h3 class="fw-bold mb-1 text-white fs-6 fs-md-5">Total Pendapatan</h3>
                <h2 class="fw-bolder mb-3 mb-md-4 text-white fs-3 fs-md-1">Rp
                    {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h2>
                <a href="{{ route('laporan.pendapatan', ['start_date' => now()->startOfDay()->format('Y-m-d H:i:s'), 'end_date' => now()->endOfDay()->format('Y-m-d H:i:s')]) }}"
                    class="btn-promo text-white text-decoration-none d-inline-block btn-sm btn-md-normal text-center">
                    Lihat Detail
                </a>
                <i class="bi bi-wallet2 position-absolute d-none d-sm-block"
                    style="font-size: 6rem; opacity: 0.1; right: -20px; bottom: -20px;"></i>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card promo-card-2 p-3 p-md-4 h-100 position-relative overflow-hidden">
                <span class="badge bg-light text-dark rounded-pill mb-2 mb-md-3"
                    style="width: fit-content; font-size: 0.65rem;">HARI INI</span>
                <h3 class="fw-bold mb-1 fs-6 fs-md-5">Pesanan Masuk</h3>
                <h2 class="fw-bolder mb-3 mb-md-4 fs-3 fs-md-1">{{ $totalPesananHariIni }} <span
                        class="fs-6 fs-md-5 fw-medium">Order</span></h2>
                <a href="{{ route('laporan.pesanan', ['start_date' => now()->startOfDay()->format('Y-m-d H:i:s'), 'end_date' => now()->endOfDay()->format('Y-m-d H:i:s')]) }}"
                    class="btn-promo text-decoration-none d-inline-block btn-sm btn-md-normal text-center">
                    Lihat Detail
                </a>
                <i class="bi bi-bag-check position-absolute d-none d-sm-block"
                    style="font-size: 6rem; opacity: 0.1; right: -10px; bottom: -30px;"></i>
            </div>
        </div>
    </section>

    <h4 class="font-serif fw-bold mb-3 mb-md-4 fs-5 fs-md-4">Statistik Operasional</h4>
    <section class="row g-3 g-md-4 mb-4 mb-md-5">
        <div class="col-sm-6 col-md-4">
            <div class="card card-soft p-3 p-md-4 d-flex flex-row align-items-center gap-2 gap-md-3 h-100">
                <div class="icon-box-soft bg-soft-red flex-shrink-0" style="width: 45px; height: 45px; font-size: 1.25rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div>
                    <p class="small text-muted fw-bold text-uppercase mb-1 fs-md-0-7rem" style="letter-spacing: 0.5px;">
                        Stok Menipis (&lt;10)
                    </p>
                    <h4 class="fw-bolder text-danger mb-0 fs-5 fs-md-4">{{ $stokMenipis }} Produk</h4>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="card card-soft p-3 p-md-4 d-flex flex-row align-items-center gap-2 gap-md-3 h-100">
                <div class="icon-box-soft bg-soft-brown flex-shrink-0"
                    style="width: 45px; height: 45px; font-size: 1.25rem;">
                    <i class="bi bi-grid-fill"></i>
                </div>
                <div>
                    <p class="small text-muted fw-bold text-uppercase mb-1 fs-md-0-7rem" style="letter-spacing: 0.5px;">
                        Total Varian Produk</p>
                    <h4 class="fw-bolder text-brand-dark mb-0 fs-5 fs-md-4">{{ $totalProduk }} Item</h4>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="card card-soft p-3 p-md-4 d-flex flex-row align-items-center gap-2 gap-md-3 h-100">
                <div class="icon-box-soft flex-shrink-0"
                    style="background-color: #E3F2FD; color: #0277BD; width: 45px; height: 45px; font-size: 1.25rem;">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <p class="small text-muted fw-bold text-uppercase mb-1 fs-md-0-7rem" style="letter-spacing: 0.5px;">
                        Menunggu Diproses</p>
                    <h4 class="fw-bolder mb-0 fs-5 fs-md-4" style="color: #0277BD;">
                        {{ $pesananPending }} Antrean
                    </h4>
                </div>
            </div>
        </div>
    </section>

    <section class="row g-3 g-md-4">
        <div class="col-12 col-xl-8">
            <div class="card card-soft p-3 p-md-4">
                <h5 class="font-serif fw-bold mb-3 mb-md-4 fs-6 fs-md-5">Tren Mingguan <span
                        class="text-muted fw-normal fs-7 fs-md-6">/ Penjualan</span>
                </h5>
                <div style="height: 280px; height-md-320px;">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card card-soft p-3 p-md-4 h-100">
                <h5 class="font-serif fw-bold mb-3 mb-md-4 text-center fs-6 fs-md-5">Top Selling</h5>
                <div style="height: 240px; height-md-280px; display: flex; justify-content: center;">
                    <canvas id="productFavoriteChart"></canvas>
                </div>
                <p class="text-center text-muted small mt-2 mt-md-3 fw-medium">Berdasarkan total item terjual</p>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof Chart === 'undefined') return;

            // Sesuaikan font chart dengan tema aplikasi
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            Chart.defaults.color = '#5C3D2E';
            Chart.defaults.font.weight = '600';

            // 1. Grafik Tren (Line Chart)
            const weeklyData = @json($weeklySales);
            const salesCtx = document.getElementById('salesTrendChart').getContext('2d');

            // Efek gradient warna kuning/krem untuk line chart
            let gradientFill = salesCtx.createLinearGradient(0, 0, 0, 300);
            gradientFill.addColorStop(0, 'rgba(246, 170, 28, 0.2)');
            gradientFill.addColorStop(1, 'rgba(246, 170, 28, 0)');

            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: weeklyData.map(d => d.date),
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: weeklyData.map(d => d.total),
                        borderColor: '#F6AA1C',
                        backgroundColor: gradientFill,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#8A4117',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    let value = context.parsed.y;
                                    return label + ': Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [4, 4],
                                color: '#EAE0D5'
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                callback: function(value) {
                                    // Format dengan RB (Ribu) dan JT (Juta)
                                    if (value >= 1000000) {
                                        return (value / 1000000).toFixed(1) + 'JT';
                                    } else if (value >= 1000) {
                                        return (value / 1000).toFixed(0) + 'RB';
                                    }
                                    return value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                maxRotation: 45,
                                minRotation: 0
                            }
                        }
                    }
                }
            });

            // 2. Grafik Top Produk (Doughnut Chart)
            const topProducts = @json($topProducts);
            const productCtx = document.getElementById('productFavoriteChart').getContext('2d');

            // Responsive doughnut options based on screen size
            const isMobile = window.innerWidth < 768;

            new Chart(productCtx, {
                type: 'doughnut',
                data: {
                    labels: topProducts.map(p => p.nama_produk),
                    datasets: [{
                        data: topProducts.map(p => p.total_qty),
                        backgroundColor: ['#F6AA1C', '#8A4117', '#D4A373', '#FAEDCD', '#E9EDC9'],
                        borderColor: '#FFF',
                        borderWidth: 2,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: isMobile ? '70%' : '75%',
                    plugins: {
                        legend: {
                            position: isMobile ? 'bottom' : 'bottom',
                            labels: {
                                padding: isMobile ? 10 : 15,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: {
                                    size: isMobile ? 10 : 12
                                },
                                boxWidth: isMobile ? 10 : 12
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / total) * 100).toFixed(1);
                                    return label + ': ' + value + ' item (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });

            // Handle resize untuk update chart options
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    const isMobileNow = window.innerWidth < 768;
                    const chart = Chart.getChart('productFavoriteChart');
                    if (chart) {
                        chart.options.cutout = isMobileNow ? '70%' : '75%';
                        chart.options.plugins.legend.labels.font.size = isMobileNow ? 10 : 12;
                        chart.options.plugins.legend.labels.boxWidth = isMobileNow ? 10 : 12;
                        chart.update();
                    }
                }, 250);
            });
        });
    </script>
@endpush

{{-- Tambahan CSS untuk responsive improvements --}}
@push('styles')
    <style>
        /* Base responsive improvements */
        @media (max-width: 576px) {
            .btn-promo {
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
            }

            .icon-box-soft {
                width: 40px !important;
                height: 40px !important;
                font-size: 1rem !important;
            }

            .card-soft {
                padding: 1rem !important;
            }
        }

        @media (min-width: 768px) {
            .fs-md-1 {
                font-size: 2.5rem !important;
            }

            .fs-md-4 {
                font-size: 1.5rem !important;
            }

            .fs-md-5 {
                font-size: 1.25rem !important;
            }

            .fs-md-base {
                font-size: 1rem !important;
            }

            .fs-md-0-7rem {
                font-size: 0.7rem !important;
            }

            .fs-md-8rem {
                font-size: 8rem !important;
            }

            .height-md-320px {
                height: 320px !important;
            }

            .height-md-280px {
                height: 280px !important;
            }

            .btn-md-normal {
                font-size: 0.875rem;
                padding: 0.375rem 1rem;
            }
        }

        /* Smooth hover effects */
        .btn-promo {
            transition: all 0.3s ease;
        }

        .btn-promo:hover {
            transform: translateX(5px);
        }

        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush
