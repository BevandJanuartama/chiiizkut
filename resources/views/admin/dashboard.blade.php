@extends('layouts.admin')

@section('content')
    <header class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h1 class="font-serif fw-bold mb-1">Halo, Selamat Pagi!</h1>
            <p class="text-muted mb-0">Siap mengecek performa toko hari ini?</p>
        </div>
    </header>

    <div class="d-flex justify-content-between align-items-end mb-3">
        <h4 class="font-serif fw-bold mb-0">Highlight Toko</h4>
        <span class="text-muted small fw-semibold">{{ now()->isoFormat('D MMMM YYYY') }}</span>
    </div>

    <section class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card promo-card-1 p-4 h-100 position-relative overflow-hidden">
                <span class="badge bg-white text-dark rounded-pill mb-3" style="width: fit-content; font-size: 0.7rem;">HARI
                    INI</span>
                <h3 class="fw-bold mb-1 text-white">Total Pendapatan</h3>
                <h2 class="fw-bolder fs-1 mb-4 text-white">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h2>
                <button class="btn-promo text-white">Uang Masuk</button>
                <i class="bi bi-wallet2 position-absolute"
                    style="font-size: 8rem; opacity: 0.1; right: -20px; bottom: -20px;"></i>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card promo-card-2 p-4 h-100 position-relative overflow-hidden">
                <span class="badge bg-light text-dark rounded-pill mb-3"
                    style="width: fit-content; font-size: 0.7rem;">HARI INI</span>
                <h3 class="fw-bold mb-1">Pesanan Masuk</h3>
                <h2 class="fw-bolder fs-1 mb-4">{{ $totalPesananHariIni }} <span class="fs-5 fw-medium">Order</span></h2>
                <button class="btn-promo">Total Pesanan</button>
                <i class="bi bi-bag-check position-absolute"
                    style="font-size: 8rem; opacity: 0.1; right: -10px; bottom: -30px;"></i>
            </div>
        </div>
    </section>

    <h4 class="font-serif fw-bold mb-4">Statistik Operasional</h4>
    <section class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card card-soft p-4 d-flex flex-row align-items-center gap-3 h-100">
                <div class="icon-box-soft bg-soft-red flex-shrink-0">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div>
                    <p class="small text-muted fw-bold text-uppercase mb-1" style="letter-spacing: 0.5px;">
                        Stok Menipis (&lt;10)
                    </p>
                    <h4 class="fw-bolder text-danger mb-0">{{ $stokMenipis }} Produk</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-soft p-4 d-flex flex-row align-items-center gap-3 h-100">
                <div class="icon-box-soft bg-soft-brown flex-shrink-0">
                    <i class="bi bi-grid-fill"></i>
                </div>
                <div>
                    <p class="small text-muted fw-bold text-uppercase mb-1" style="letter-spacing: 0.5px;">Total Varian
                        Produk</p>
                    <h4 class="fw-bolder text-brand-dark mb-0">{{ $totalProduk }} Item</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-soft p-4 d-flex flex-row align-items-center gap-3 h-100">
                <div class="icon-box-soft flex-shrink-0" style="background-color: #E3F2FD; color: #0277BD;">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <p class="small text-muted fw-bold text-uppercase mb-1" style="letter-spacing: 0.5px;">Menunggu Diproses
                    </p>

                    <h4 class="fw-bolder mb-0" style="color: #0277BD;">
                        {{ $pesananPending }} Antrean
                    </h4>

                </div>
            </div>
        </div>
    </section>

    <section class="row g-4">
        <div class="col-xl-8">
            <div class="card card-soft p-4">
                <h5 class="font-serif fw-bold mb-4">Tren Mingguan <span class="text-muted fw-normal fs-6">/ Penjualan</span>
                </h5>
                <div style="height: 320px;">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card card-soft p-4 h-100">
                <h5 class="font-serif fw-bold mb-4 text-center">Top Selling</h5>
                <div style="height: 280px; display: flex; justify-content: center;">
                    <canvas id="productFavoriteChart"></canvas>
                </div>
                <p class="text-center text-muted small mt-3 fw-medium">Berdasarkan total item terjual</p>
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
                        tension: 0.4, // Membuat garis melengkung (smooth curve)
                        pointRadius: 4,
                        pointBackgroundColor: '#8A4117',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
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
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });

            // 2. Grafik Top Produk (Doughnut Chart)
            const topProducts = @json($topProducts);
            const productCtx = document.getElementById('productFavoriteChart').getContext('2d');
            new Chart(productCtx, {
                type: 'doughnut',
                data: {
                    labels: topProducts.map(p => p.nama_produk),
                    datasets: [{
                        data: topProducts.map(p => p.total_qty),
                        // Palette warna senada dengan tema bakery (Kuning, Coklat, Krem)
                        backgroundColor: ['#F6AA1C', '#8A4117', '#D4A373', '#FAEDCD', '#E9EDC9'],
                        borderColor: '#FFF',
                        borderWidth: 3,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%', // Membuat cincin lebih tipis agar lebih elegan
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
