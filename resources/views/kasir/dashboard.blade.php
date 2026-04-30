@extends('layouts.app2')

@section('title', 'Monitoring Antrean - ChiiiZkut')

@section('body-attributes')
    x-data="{}"
@endsection

@section('content')
    <div class="monitoring-container w-100 px-2 px-sm-3 px-md-4 py-2 py-sm-3">

        <!-- Navbar Custom -->
        <nav class="navbar-custom mb-3 mb-md-5">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <img src="/images/logo.png" alt="Logo ChiiiZkut" style="max-height: 50px; object-fit: contain;"
                        onerror="this.onerror=null; this.style.display='none'">
                </div>

                <div class="d-flex align-items-center gap-2 gap-sm-3 flex-wrap justify-content-center">
                    <!-- Tombol Monitoring Antrean -->
                    <a href="{{ route('kasir.dashboard') }}"
                        class="btn btn-nav-monitoring rounded-pill btn-sm fw-bold px-2 px-sm-3" style="font-size: 0.7rem;">
                        <i class="bi bi-display me-1"></i> <span class="d-none d-sm-inline">Monitoring Antrean</span>
                    </a>

                    <!-- Tombol Manajemen Pemesanan -->
                    <a href="{{ route('kasir.order') }}"
                        class="btn btn-nav-manajemen rounded-pill btn-sm fw-bold px-2 px-sm-3" style="font-size: 0.7rem;">
                        <i class="bi bi-receipt me-1"></i> <span class="d-none d-sm-inline">Manajemen Pemesanan</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-danger rounded-pill btn-sm fw-bold px-3 px-sm-4"
                            style="font-size: 0.7rem;">
                            <i class="bi bi-box-arrow-right"></i> <span class="d-none d-sm-inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>


        <div class="container-fluid pb-3 pb-md-5">
            <div id="toast-container"></div>

            @if (session('success'))
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: '{{ session('success') }}',
                            confirmButtonColor: '#F6AA1C',
                            background: '#FFFCF5',
                            color: '#5C3D2E',
                            iconColor: '#28a745',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    });
                </script>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card-soft mb-4">
                        <div class="p-3 p-md-4 header-section" style="border-bottom: 1px solid #F0E6D2 !important;">
                            <div class="header-left">
                                <h2 class="fw-bold mb-1"
                                    style="color: #8A4117; font-family: 'Lora', serif; font-weight: 1000;">
                                    Monitoring <span style="color: #F6AA1C;">Antrean</span>
                                </h2>
                                <p class="text-muted mb-0" style="font-size: 1.0rem;">Kelola pesanan masuk hari ini.</p>
                            </div>
                            <div class="header-right">
                                <div class="search-bar d-flex align-items-center">
                                    <i class="bi bi-search text-muted me-2" style="font-size: 0.9rem;"></i>
                                    <input type="text" id="searchInput" placeholder="Cari nama atau no antrean..."
                                        onkeyup="filterTable()" style="width: 100%; font-size: 0.85rem;">
                                </div>
                            </div>
                        </div>

                     <div class="table-responsive-custom">
                            <table class="table table-hover table-custom mb-0" id="transaksiTable">
                                <thead>
                                    <tr>
                                        <!-- Ditambahkan padding-left custom agar jarak kiri lebih lebar -->
                                        <th style="width: 10%; background-color: #F3EBE1; color: #8A4117; padding-left: 2.5rem !important;">Antrean</th>
                                        <!-- Ditambahkan sedikit padding agar Pelanggan juga ikut bergeser rapi -->
                                        <th style="width: 14%; background-color: #F3EBE1; color: #8A4117; padding-left: 1rem !important;">Pelanggan</th>
                                        <th style="width: 26%; background-color: #F3EBE1; color: #8A4117;">Detail Pesanan</th>
                                        <th style="width: 10%; background-color: #F3EBE1; color: #8A4117;">Total</th>
                                        <th style="width: 10%; background-color: #F3EBE1; color: #8A4117;">Metode Bayar</th>
                                        <th style="width: 10%; background-color: #F3EBE1; color: #8A4117;">Tgl. Konfirmasi</th>
                                        <th class="text-center" style="width: 10%; background-color: #F3EBE1; color: #8A4117;">Status</th>
                                        <th class="text-center" style="width: 10%; background-color: #F3EBE1; color: #8A4117;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="transaksi-tbody">
                                    @forelse($transaksis as $t)
                                        <tr id="row-{{ $t->id }}" style="background-color: #ffffff;">
                                            <!-- Padding kiri disamakan dengan header -->
                                            <td class="fw-bolder" style="color: #F6AA1C; font-size: 1.2rem; padding-left: 2.5rem !important;">
                                                #{{ str_pad($t->nomor_antrean, 3, '0', STR_PAD_LEFT) }}
                                            </td>
                                            <td style="padding-left: 1rem !important;">
                                                <div class="fw-bold" style="font-size: 1.05rem; color: #5C3D2E;">
                                                    {{ $t->nama ?? 'Guest' }}
                                                </div>
                                                <small class="text-muted" style="font-size: 0.8rem;">
                                                    <i class="bi bi-whatsapp me-1"></i>{{ $t->telepon ?? '-' }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="detail-badge">
                                                    @foreach ($t->details as $detail)
                                                        <span class="badge rounded-pill px-2 py-1 mb-1 me-1"
                                                            style="font-weight: 500; font-size: 0.8rem; background-color: #f8f9fa; color: #5C3D2E; border: 1px solid #F0E6D2;">
                                                            {{ $detail->varian->produk->nama_produk }}
                                                            <span
                                                                class="text-warning ms-1 text-uppercase">{{ $detail->varian->ukuran }}</span>
                                                            <span class="text-muted ms-1">x{{ $detail->qty }}</span>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="fw-bold"
                                                style="font-size: 1rem; color: #5C3D2E; white-space: nowrap;">
                                                Rp {{ number_format($t->total, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @php
                                                    $paymentMethod =
                                                        $t->metode_pembayaran ?? ($t->payment_method ?? 'tunai');
                                                    $paymentLabels = [
                                                        'tunai' => [
                                                            'icon' => 'bi-cash',
                                                            'text' => 'Tunai',
                                                            'class' => 'payment-tunai',
                                                        ],
                                                        'qris' => [
                                                            'icon' => 'bi-qr-code',
                                                            'text' => 'QRIS',
                                                            'class' => 'payment-qris',
                                                        ],
                                                        'transfer' => [
                                                            'icon' => 'bi-bank',
                                                            'text' => 'Transfer',
                                                            'class' => 'payment-transfer',
                                                        ],
                                                        'credit_card' => [
                                                            'icon' => 'bi-credit-card',
                                                            'text' => 'Kartu',
                                                            'class' => 'payment-transfer',
                                                        ],
                                                    ];
                                                    $payment =
                                                        $paymentLabels[$paymentMethod] ?? $paymentLabels['tunai'];
                                                @endphp
                                                <span class="badge {{ $payment['class'] }} px-2 py-1 rounded-pill fw-bold"
                                                    style="font-size: 0.75rem;">
                                                    <i class="{{ $payment['icon'] }} me-1"></i> {{ $payment['text'] }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($t->status == 'sukses' && $t->updated_at)
                                                    <div class="text-muted text-nowrap" style="font-size: 0.75rem;">
                                                        <div>{{ $t->updated_at->timezone('Asia/Makassar')->format('d/m/Y') }}</div>
                                                        <div>{{ $t->updated_at->timezone('Asia/Makassar')->format('H:i') }} WITA</div>
                                                    </div>
                                                @elseif($t->status == 'gagal' && $t->updated_at)
                                                    <div class="text-muted text-nowrap" style="font-size: 0.75rem;">
                                                        <div>{{ $t->updated_at->timezone('Asia/Makassar')->format('d/m/Y') }}</div>
                                                        <div>{{ $t->updated_at->timezone('Asia/Makassar')->format('H:i') }} WITA</div>
                                                    </div>
                                                @else
                                                    <small class="text-muted fst-italic" style="font-size: 0.75rem;">-</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge badge-{{ $t->status }} px-2 py-1 rounded-pill fw-bold"
                                                    style="font-size: 0.75rem;">
                                                    <i
                                                        class="bi bi-{{ $t->status == 'pending' ? 'hourglass-split' : ($t->status == 'sukses' ? 'check-circle' : 'x-circle') }} me-1"></i>
                                                    {{ strtoupper($t->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if ($t->status == 'pending')
                                                    <div class="action-buttons d-flex justify-content-center gap-2">
                                                        <form action="{{ route('transaksi.updateStatus', $t->id) }}" method="POST" class="d-inline">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status" value="sukses">
                                                            <button type="button" class="btn btn-sm btn-success rounded-pill px-3 fw-bold shadow-sm" style="font-size: 0.75rem; background-color: #28a745;" onclick="confirmAction(this, 'Terima Pesanan Ini?')">
                                                                <i class="bi bi-check-lg me-1"></i> Terima
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('transaksi.updateStatus', $t->id) }}" method="POST" class="d-inline">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status" value="gagal">
                                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill fw-bold px-3" style="font-size: 0.75rem;" onclick="confirmAction(this, 'Batalkan Pesanan Ini?', 'Stok barang akan dikembalikan')">
                                                                <i class="bi bi-x-lg me-1"></i> Tolak
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="d-flex justify-content-center">
                                                        <small class="text-muted fw-semibold fst-italic text-nowrap" style="font-size: 0.75rem;">
                                                            <i class="bi bi-check2-all me-1"></i>Processed
                                                        </small>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 py-md-5 empty-state">
                                                <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                                                <p class="text-muted mt-2 fw-medium mb-0" style="font-size: 0.85rem;">
                                                    Belum ada transaksi masuk.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="p-3 p-md-4 d-flex justify-content-center"
                            style="border-top: 1px solid #F0E6D2 !important;">
                            {{ $transaksis->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* OVERRIDE layout app2 - fix scrolling dan background */
        body {
            overflow-y: auto !important;
            overflow-x: hidden !important;
            height: auto !important;
            background-color: #ffffff !important;
        }

        :root {
            --bg-cream: #ffffff;
            --text-brown: #5C3D2E;
            --brand-yellow: #F6AA1C;
            --brand-dark: #8A4117;
            --card-border: #F0E6D2;
        }

        /* Navbar Custom */
        .navbar-custom {
            background-color: #ffffff;
            border-bottom: 2px solid var(--card-border);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            padding: 0.8rem 0;
        }

        .navbar-custom .container {
            flex-wrap: wrap;
            gap: 12px;
        }

        @media (max-width: 768px) {
            .navbar-custom .container {
                flex-direction: column;
                text-align: center;
            }

            .navbar-custom .d-flex.align-items-center.gap-3 {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        .monitoring-container {
            background-color: #ffffff;
            min-height: 100vh;
        }

        /* Typography */
        .font-serif {
            font-family: 'Lora', serif;
            color: #8A4117;
        }

        /* Card & Table Elements */
        .card-soft {
            background: #ffffff;
            border: 1px solid #F0E6D2;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .search-bar {
            border-radius: 50px;
            border: 1px solid #F0E6D2;
            padding: 0.6rem 1.5rem;
            background-color: #f8f9fa;
            transition: all 0.3s;
        }

        .search-bar:focus-within {
            border-color: #F6AA1C;
            box-shadow: 0 0 0 3px rgba(246, 170, 28, 0.2);
            background-color: #ffffff;
        }

        .search-bar input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            color: #5C3D2E;
        }

        .search-bar input::placeholder {
            color: #b0a08a;
        }

        /* Table Responsive - Lebih Besar dan Responsif */
        .table-responsive-custom {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-custom {
            min-width: 1000px;
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-custom th {
            background-color: #F3EBE1 !important;
            color: #8A4117 !important;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem !important;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #F0E6D2 !important;
            padding: 1.2rem 0.8rem !important;
            white-space: nowrap;
        }

        .table-custom td {
            vertical-align: middle;
            border-bottom: 1px solid #F0E6D2 !important;
            padding: 1rem 0.8rem !important;
            word-break: break-word;
            font-size: 0.95rem;
            background-color: #ffffff;
        }

        .table-custom tr:hover td {
            background-color: #FFFCF5 !important;
        }

        /* Responsive breakpoints - menjaga tata letak */
        @media (max-width: 1200px) {
            .table-custom {
                min-width: 900px;
            }

            .table-custom th {
                font-size: 0.8rem !important;
                padding: 1rem 0.6rem !important;
            }

            .table-custom td {
                padding: 0.9rem 0.6rem !important;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 992px) {
            .table-custom {
                min-width: 850px;
            }

            .table-custom th {
                font-size: 0.75rem !important;
                padding: 0.9rem 0.5rem !important;
            }

            .table-custom td {
                padding: 0.8rem 0.5rem !important;
                font-size: 0.85rem;
            }

            .table-custom td .fw-bold {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            .table-custom {
                min-width: 750px;
            }

            .table-custom th {
                font-size: 0.7rem !important;
                padding: 0.8rem 0.4rem !important;
            }

            .table-custom td {
                padding: 0.7rem 0.4rem !important;
                font-size: 0.8rem;
            }

            .table-custom td .fw-bold {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .table-custom {
                min-width: 650px;
            }

            .table-custom th {
                font-size: 0.65rem !important;
                padding: 0.7rem 0.3rem !important;
            }

            .table-custom td {
                padding: 0.6rem 0.3rem !important;
                font-size: 0.75rem;
            }

            .table-custom td .fw-bold {
                font-size: 0.8rem;
            }
        }

        /* Badges Styling - lebih besar */
        .badge-pending {
            background-color: #FFF4E0;
            color: #F6AA1C;
            border: 1px solid #F6AA1C;
            font-size: 0.75rem !important;
        }

        .badge-sukses {
            background-color: #E8F5E9;
            color: #2E7D32;
            border: 1px solid #2E7D32;
            font-size: 0.75rem !important;
        }

        .badge-gagal {
            background-color: #FFE5E5;
            color: #DC3545;
            border: 1px solid #DC3545;
            font-size: 0.75rem !important;
        }

        /* Payment Method Badges */
        .payment-tunai {
            background-color: #E3F2FD !important;
            color: #1565C0 !important;
            border: 1px solid #1565C0 !important;
            font-size: 0.75rem !important;
        }

        .payment-qris {
            background-color: #E8F5E9 !important;
            color: #2E7D32 !important;
            border: 1px solid #2E7D32 !important;
            font-size: 0.75rem !important;
        }

        .payment-transfer {
            background-color: #FFF3E0 !important;
            color: #E65100 !important;
            border: 1px solid #E65100 !important;
            font-size: 0.75rem !important;
        }

        /* Highlight Animasi Pesanan Baru */
        @keyframes highlightFade {
            0% {
                background-color: #FFF4E0;
            }

            100% {
                background-color: #ffffff;
            }
        }

        .new-order-row td {
            animation: highlightFade 4s ease-out;
        }

        /* Toast Container Custom - Responsive */
        #toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            left: auto;
            z-index: 9999;
        }

        @media (max-width: 576px) {
            #toast-container {
                left: 10px;
                right: 10px;
                top: 10px;
            }
        }

        /* Pagination Styling - Responsive */
        .pagination {
            margin-bottom: 0;
            flex-wrap: wrap;
            justify-content: center;
        }

        .page-link {
            color: #5C3D2E;
            border-color: #F0E6D2;
            padding: 0.5rem 0.8rem;
            font-size: 0.85rem;
            background-color: #ffffff;
        }

        .page-item.active .page-link {
            background-color: #F6AA1C;
            border-color: #F6AA1C;
            color: #fff;
        }

        .page-item.disabled .page-link {
            background-color: #f8f9fa;
            color: #b0a08a;
        }

        @media (max-width: 576px) {
            .page-link {
                padding: 0.35rem 0.6rem;
                font-size: 0.75rem;
            }
        }

        /* Detail pesanan badge responsive */
        .detail-badge {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 4px;
        }

        .detail-badge .badge {
            font-weight: 500;
            font-size: 0.8rem !important;
            white-space: normal;
            word-break: break-word;
            background-color: #f8f9fa !important;
            color: #5C3D2E !important;
            border: 1px solid #F0E6D2 !important;
            padding: 5px 10px !important;
        }

        /* Action buttons responsive */
        .action-buttons {
            gap: 8px;
        }

        .action-buttons .btn {
            white-space: nowrap;
            font-size: 0.75rem !important;
            padding: 5px 12px !important;
        }

        @media (max-width: 992px) {
            .action-buttons {
                flex-direction: column;
                gap: 6px;
            }

            .action-buttons .btn {
                width: 100%;
                font-size: 0.7rem !important;
                padding: 4px 8px !important;
            }
        }

        /* Header section responsive */
        .header-section {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .header-left {
            flex: 1;
        }

        .header-right {
            min-width: 280px;
        }

        @media (max-width: 768px) {
            .header-section {
                flex-direction: column;
                align-items: stretch;
            }

            .header-right {
                width: 100%;
                min-width: auto;
            }
        }

        /* Search bar responsive */
        @media (max-width: 576px) {
            .search-bar {
                width: 100%;
                min-width: auto !important;
                padding: 0.5rem 1rem;
            }
        }

        /* Empty state responsive */
        .empty-state i {
            font-size: 3rem;
        }

        @media (max-width: 576px) {
            .empty-state i {
                font-size: 2.5rem;
            }

            .empty-state p {
                font-size: 0.9rem;
            }
        }

        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        /* Toast styling */
        .alert-warning {
            background-color: #ffffff !important;
        }

        /* Tombol Monitoring Antrean (Langsung Kuning) */
        .btn-nav-monitoring {
            background-color: #F6AA1C !important;
            color: #ffffff !important;
            /* Teks putih */
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(246, 170, 28, 0.2);
        }

        /* Efek klik/geser yang halus (sedikit terangkat) */
        .btn-nav-monitoring:hover,
        .btn-nav-monitoring:focus {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(246, 170, 28, 0.35);
            filter: brightness(1.05);
        }

        /* Tombol Manajemen Pemesanan (Langsung Coklat Gelap) */
        .btn-nav-manajemen {
            background-color: #8A4117 !important;
            color: #ffffff !important;
            /* Teks putih */
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(138, 65, 23, 0.2);
        }

        /* Efek klik/geser yang halus (sedikit terangkat) */
        .btn-nav-manajemen:hover,
        .btn-nav-manajemen:focus {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(138, 65, 23, 0.35);
            filter: brightness(1.1);
        }
    </style>
@endpush

@push('body-scripts')
    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // SweetAlert2 Konfirmasi Tombol
        function confirmAction(button, title, text = "") {
            Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#F6AA1C',
                cancelButtonColor: '#DC3545',
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Kembali',
                background: '#FFFCF5',
                color: '#5C3D2E'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }

        // Fitur Pencarian Real-Time (Client-Side)
        function filterTable() {
            let input = document.getElementById("searchInput");
            let filter = input.value.toLowerCase();
            let table = document.getElementById("transaksiTable");
            let tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                let tdAntrean = tr[i].getElementsByTagName("td")[0];
                let tdPelanggan = tr[i].getElementsByTagName("td")[1];

                if (tdAntrean || tdPelanggan) {
                    let txtValueAntrean = tdAntrean ? (tdAntrean.textContent || tdAntrean.innerText) : "";
                    let txtValuePelanggan = tdPelanggan ? (tdPelanggan.textContent || tdPelanggan.innerText) : "";

                    if (txtValueAntrean.toLowerCase().indexOf(filter) > -1 || txtValuePelanggan.toLowerCase().indexOf(
                            filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Status Online dengan Echo Reverb (Vite sudah include)
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Echo !== 'undefined') {
                Echo.channel('kasir-channel')
                    .listen('PesananBaru', (e) => {
                        showBeautifulToast(e.jumlahPesanan);
                        const audio = new Audio(
                            'https://assets.mixkit.co/active_storage/sfx/2358/2358-preview.mp3');
                        audio.play().catch(e => console.log('Audio error:', e));
                        fetchTableData();
                    });
            }
        });

        // Toast Responsive
        function showBeautifulToast(total) {
            const container = document.getElementById('toast-container');
            const id = 'toast-' + Date.now();

            if (container) {
                container.innerHTML = `
                <div id="${id}" class="alert alert-warning border-0 shadow-lg d-flex align-items-center show fade" role="alert" style="background-color: #fff; border-left: 6px solid #F6AA1C !important; border-radius: 12px; padding: 0.75rem;">
                    <div class="flex-grow-1">
                        <strong class="d-block" style="color: #8A4117; font-size: 0.85rem;"><i class="bi bi-bell-fill text-warning me-2"></i>Pesanan Baru!</strong>
                        <small class="text-muted" style="font-size: 0.75rem;">Ada total <b class="text-dark">${total}</b> antrean pending.</small>
                    </div>
                    <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" style="font-size: 0.7rem;"></button>
                </div>
            `;

                setTimeout(() => {
                    const toastEl = document.getElementById(id);
                    if (toastEl) toastEl.classList.remove('show');
                }, 6000);
            }
        }

        function fetchTableData() {
            fetch(window.location.href)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.getElementById('transaksi-tbody').innerHTML;

                    const tbody = document.getElementById('transaksi-tbody');
                    if (tbody) {
                        tbody.innerHTML = newContent;

                        const firstRow = tbody.querySelector('tr');
                        if (firstRow && !firstRow.innerText.includes('Belum ada')) {
                            firstRow.classList.add('new-order-row');
                        }
                    }
                })
                .catch(err => console.log('Fetch error:', err));
        }
    </script>
@endpush
