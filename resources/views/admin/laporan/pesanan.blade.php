@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <div>
                <h2 class="fw-bold mb-1"
                    style="color: #8A4117; font-family: 'Lora', serif; font-weight: 1000; font-size: 40px;">
                    Detail <span style="color: #F6AA1C;">Pesanan</span>
                </h2>
                <p class="text-muted mb-0">Lihat detail pesanan berdasarkan periode yang dipilih</p>
            </div>
        </div>

        <div class="card card-soft p-4 mb-4">
            <form method="GET" action="{{ route('laporan.pesanan') }}" class="row g-3 align-items-end">
                @if (request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                @if (request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold small text-muted">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold small text-muted">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-12 col-md-4">
                    <button type="submit" class="btn btn-primary w-100"
                        style="background-color: var(--brand-yellow); border: none; color: var(--text-brown);">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        @php
            $currentStatus = request('status');
            $searchQuery = request('search');
            // Menampilkan tabel jika status DIPILIH ATAU ada PENCARIAN
            $showTable = !empty($currentStatus) || !empty($searchQuery);
        @endphp

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <a href="{{ route('laporan.pesanan', $currentStatus == 'all' ? request()->except('status') : array_merge(request()->except('status'), ['status' => 'all'])) }}"
                    class="text-decoration-none">
                    <div class="card card-soft p-3 text-center {{ $currentStatus == 'all' ? 'border border-2 shadow-sm bg-light' : '' }} hover-card"
                        style="{{ $currentStatus == 'all' ? 'border-color: #8A4117 !important;' : '' }}">
                        <i class="bi bi-cart fs-1" style="color: #8A4117;"></i>
                        <h5 class="mt-2 mb-1 text-muted small">Total Pesanan</h5>
                        <h3 class="fw-bold text-brand-dark mb-0">{{ $statistik['total'] }}</h3>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="{{ route('laporan.pesanan', $currentStatus == 'pending' ? request()->except('status') : array_merge(request()->except('status'), ['status' => 'pending'])) }}"
                    class="text-decoration-none">
                    <div
                        class="card card-soft p-3 text-center {{ $currentStatus == 'pending' ? 'border border-2 border-warning shadow-sm bg-light' : '' }} hover-card">
                        <i class="bi bi-clock-history fs-1 text-warning"></i>
                        <h5 class="mt-2 mb-1 text-muted small">Pending</h5>
                        <h3 class="fw-bold text-warning mb-0">{{ $statistik['pending'] }}</h3>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="{{ route('laporan.pesanan', $currentStatus == 'sukses' ? request()->except('status') : array_merge(request()->except('status'), ['status' => 'sukses'])) }}"
                    class="text-decoration-none">
                    <div
                        class="card card-soft p-3 text-center {{ $currentStatus == 'sukses' ? 'border border-2 border-success shadow-sm bg-light' : '' }} hover-card">
                        <i class="bi bi-check-circle fs-1 text-success"></i>
                        <h5 class="mt-2 mb-1 text-muted small">Sukses</h5>
                        <h3 class="fw-bold text-success mb-0">{{ $statistik['sukses'] }}</h3>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="{{ route('laporan.pesanan', $currentStatus == 'gagal' ? request()->except('status') : array_merge(request()->except('status'), ['status' => 'gagal'])) }}"
                    class="text-decoration-none">
                    <div
                        class="card card-soft p-3 text-center {{ $currentStatus == 'gagal' ? 'border border-2 border-danger shadow-sm bg-light' : '' }} hover-card">
                        <i class="bi bi-x-circle fs-1 text-danger"></i>
                        <h5 class="mt-2 mb-1 text-muted small">Gagal</h5>
                        <h3 class="fw-bold text-danger mb-0">{{ $statistik['gagal'] }}</h3>
                    </div>
                </a>
            </div>
        </div>

        @if ($showTable)
            <div class="card card-soft p-4 mb-4">
                <div class="row align-items-center mb-3 g-2">
                    <div class="col-md-6">
                        <h5 class="font-serif fw-bold mb-0">
                            Daftar Transaksi
                            @if ($currentStatus && $currentStatus != 'all')
                                <span
                                    class="badge bg-{{ $currentStatus == 'sukses' ? 'success' : ($currentStatus == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($currentStatus) }}
                                </span>
                            @endif
                            @if ($searchQuery)
                                <span class="badge bg-secondary ms-1">Pencarian: {{ $searchQuery }}</span>
                            @endif
                        </h5>
                    </div>

                    <div class="col-md-6 d-flex justify-content-md-end align-items-center gap-2">
                        <form method="GET" action="{{ route('laporan.pesanan') }}" class="d-flex w-100 w-md-auto">
                            <input type="hidden" name="start_date" value="{{ $startDate }}">
                            <input type="hidden" name="end_date" value="{{ $endDate }}">
                            @if ($currentStatus)
                                <input type="hidden" name="status" value="{{ $currentStatus }}">
                            @endif

                            <div class="input-group input-group-sm" style="max-width: 250px;">
                                <input type="text" name="search" class="form-control" placeholder="Cari ID Transaksi..."
                                    value="{{ $searchQuery }}">
                                <button type="submit" class="btn btn-outline-secondary"><i
                                        class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Tanggal (WITA)</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesanans as $pesanan)
                                <tr>
                                    <td>#{{ $pesanan->id }}</td>
                                    <td>
                                        {{ $pesanan->created_at->timezone('Asia/Makassar')->format('d M Y H:i') }} WITA
                                    </td>
                                    <td>Rp {{ number_format($pesanan->total, 0, ',', '.') }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $pesanan->status == 'sukses' ? 'success' : ($pesanan->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($pesanan->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        @if ($searchQuery)
                                            Pencarian ID "<b>{{ $searchQuery }}</b>" tidak ditemukan.
                                        @else
                                            Tidak ada data pesanan ditemukan pada periode dan status ini.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    {{ $pesanans->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @else
            <div class="card card-soft p-4">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-md-center flex-wrap gap-2 mb-3">
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
        @endif

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const chartElement = document.getElementById('pesananChart');

                if (chartElement) {
                    const pesananPerHari = @json($pesananPerHari);

                    let labels = [];
                    let suksesData = [];
                    let pendingData = [];
                    let gagalData = [];

                    if (pesananPerHari && pesananPerHari.length > 0) {
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

                    const ctx = chartElement.getContext('2d');

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
                                    maxBarThickness: 40
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
                                    maxBarThickness: 40
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
                                    maxBarThickness: 40
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 20,
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
                                    display: false
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

                    let resizeTimeout;
                    window.addEventListener('resize', function() {
                        clearTimeout(resizeTimeout);
                        resizeTimeout = setTimeout(function() {
                            const chart = Chart.getChart('pesananChart');
                            if (chart) {
                                const isMobile = window.innerWidth < 768;
                                chart.options.scales.x.ticks.maxRotation = isMobile ? 45 : 0;
                                chart.options.scales.x.ticks.minRotation = isMobile ? 45 : 0;
                                chart.update();
                            }
                        }, 250);
                    });
                }
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .card-soft {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .hover-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
                cursor: pointer;
            }

            /* Custom Pagination Color */
            .pagination .page-link {
                color: #8A4117;
            }

            .pagination .page-item.active .page-link {
                background-color: #8A4117;
                border-color: #8A4117;
                color: #ffffff;
            }

            .pagination .page-link:hover {
                color: #6b3211;
                /* Warna sedikit lebih gelap saat di-hover */
                background-color: #f8f9fa;
                border-color: #dee2e6;
            }

            .pagination .page-item.disabled .page-link {
                color: #c4a08f;
                /* Warna pudar untuk tombol disabled */
            }

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
