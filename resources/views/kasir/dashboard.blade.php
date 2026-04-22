<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Kasir Panel - ChiiiZkut</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --bg-cream: #FFFCF5;
            --text-brown: #5C3D2E;
            --brand-yellow: #F6AA1C;
            --brand-dark: #8A4117;
            --card-border: #F0E6D2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-cream);
            color: var(--text-brown);
            overflow-x: hidden;
        }

        /* Typography */
        .font-serif {
            font-family: 'Lora', serif;
            color: var(--brand-dark);
        }

        /* Navbar Custom - Responsive */
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

        /* Card & Table Elements */
        .card-soft {
            background: #fff;
            border: 1px solid var(--card-border);
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            overflow-x: auto;
        }

        .search-bar {
            border-radius: 50px;
            border: 1px solid var(--card-border);
            padding: 0.6rem 1.5rem;
            background-color: var(--bg-cream);
            transition: all 0.3s;
        }

        .search-bar:focus-within {
            border-color: var(--brand-yellow);
            box-shadow: 0 0 0 3px rgba(246, 170, 28, 0.2);
        }

        .search-bar input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            color: var(--text-brown);
        }

        /* Table Responsive */
        .table-responsive-custom {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-custom {
            min-width: 800px;
        }

        .table-custom th {
            background-color: #F3EBE1;
            color: var(--brand-dark);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border-bottom: none;
            padding: 1rem 0.5rem;
            white-space: nowrap;
        }

        .table-custom td {
            vertical-align: middle;
            border-bottom: 1px solid var(--card-border);
            padding: 0.75rem 0.5rem;
            word-break: break-word;
            font-size: 1rem;
        }

        @media (max-width: 576px) {
            .table-custom th,
            .table-custom td {
                padding: 0.5rem 0.3rem;
                font-size: 0.85rem;
            }
            
            .table-custom td .fw-bold {
                font-size: 0.9rem;
            }
        }

        /* Badges Styling */
        .badge-pending {
            background-color: #FFF4E0;
            color: #F6AA1C;
            border: 1px solid #F6AA1C;
        }

        .badge-sukses {
            background-color: #E8F5E9;
            color: #2E7D32;
            border: 1px solid #2E7D32;
        }

        .badge-gagal {
            background-color: #FFE5E5;
            color: #DC3545;
            border: 1px solid #DC3545;
        }

        /* Payment Method Badges */
        .payment-tunai {
            background-color: #E3F2FD;
            color: #1565C0;
            border: 1px solid #1565C0;
        }

        .payment-qris {
            background-color: #E8F5E9;
            color: #2E7D32;
            border: 1px solid #2E7D32;
        }

        .payment-transfer {
            background-color: #FFF3E0;
            color: #E65100;
            border: 1px solid #E65100;
        }

        /* Highlight Animasi Pesanan Baru */
        @keyframes highlightFade {
            0% {
                background-color: #FFF4E0;
                transform: scale(1.005);
            }
            100% {
                background-color: transparent;
                transform: scale(1);
            }
        }

        .new-order-row {
            animation: highlightFade 4s ease-out;
            border-left: 4px solid var(--brand-yellow) !important;
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
            color: var(--text-brown);
            border-color: var(--card-border);
            padding: 0.4rem 0.7rem;
            font-size: 0.8rem;
        }

        .page-item.active .page-link {
            background-color: var(--brand-yellow);
            border-color: var(--brand-yellow);
            color: #fff;
        }

        @media (max-width: 576px) {
            .page-link {
                padding: 0.3rem 0.5rem;
                font-size: 0.7rem;
            }
        }

        /* Detail pesanan badge responsive */
        .detail-badge {
            display: inline-flex;
            flex-wrap: wrap;
            gap: 4px;
            margin-bottom: 4px;
        }

        .detail-badge .badge {
            font-size: 0.8rem;
            white-space: normal;
            word-break: break-word;
        }

        /* Action buttons responsive */
        .action-buttons {
            display: flex;
            gap: 6px;
            justify-content: center;
            flex-wrap: wrap;
        }

        @media (max-width: 576px) {
            .action-buttons {
                flex-direction: column;
                gap: 4px;
            }
            
            .action-buttons .btn {
                width: 100%;
                min-width: 70px;
                font-size: 0.8rem !important;
                padding: 0.25rem 0.5rem !important;
            }
        }

        /* Container padding responsive */
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        @media (max-width: 576px) {
            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
            
            .card-soft .p-4 {
                padding: 1rem !important;
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
            min-width: 260px;
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
            font-size: 2.5rem;
        }
        
        @media (max-width: 576px) {
            .empty-state i {
                font-size: 2rem;
            }
            .empty-state p {
                font-size: 0.85rem;
            }
        }

        /* Badge online */
        .badge-online {
            background-color: #28a745 !important;
        }

        /* Text small responsive */
        .text-muted.small {
            font-size: 0.7rem;
        }
        
        @media (max-width: 576px) {
            .text-muted.small {
                font-size: 0.65rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar-custom mb-3 mb-md-5 sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <img src="/images/logo.png" alt="Logo ChiiiZkut"
                    style="max-height: 45px; object-fit: contain;" 
                    onerror="this.onerror=null; this.style.display='none'">
            </div>

            <div class="d-flex align-items-center gap-2 gap-sm-3 flex-wrap justify-content-center">
                <span id="connection-status" class="badge bg-success rounded-pill px-2 px-sm-3 py-2" style="font-size: 0.7rem;">
                    <i class="bi bi-wifi me-1"></i> Online
                </span>
                <button class="btn btn-outline-secondary rounded-pill btn-sm fw-bold px-2 px-sm-3" onclick="fetchTableData()" style="font-size: 0.7rem;">
                    <i class="bi bi-arrow-clockwise"></i> <span class="d-none d-sm-inline">Sync</span>
                </button>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger rounded-pill btn-sm fw-bold px-3 px-sm-4" style="font-size: 0.7rem;">
                        <i class="bi bi-box-arrow-right"></i> <span class="d-none d-sm-inline">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container pb-3 pb-md-5">
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
                        iconColor: '#F6AA1C',
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
                    <div class="p-3 p-md-4 border-bottom header-section" style="border-color: var(--card-border) !important;">
                        <div class="header-left">
                            <h4 class="font-serif fw-bold mb-1" style="font-size: 1.6rem;">Monitoring Antrean</h4>
                            <p class="text-muted small mb-0" style="font-size: 1.0rem;">Kelola pesanan masuk hari ini.</p>
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
                                    <th class="ps-2 ps-md-3">Antrean</th>
                                    <th>Pelanggan</th>
                                    <th>Detail Pesanan</th>
                                    <th>Total</th>
                                    <th>Metode Bayar</th>
                                    <th>Tgl. Konfirmasi</th>
                                    <th>Status</th>
                                    <th class="text-center pe-2 pe-md-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="transaksi-tbody">
                                @forelse($transaksis as $t)
                                    <tr id="row-{{ $t->id }}">
                                        <td class="ps-2 ps-md-3 fw-bolder" style="color: var(--brand-yellow); font-size: 1.1rem;">
                                            #{{ str_pad($t->nomor_antrean, 3, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td>
                                            <div class="fw-bold" style="font-size: 1rem;">{{ $t->nama ?? 'Guest' }}</div>
                                            <small class="text-muted" style="font-size: 0.8rem;">
                                                <i class="bi bi-whatsapp me-1"></i>{{ $t->telepon ?? '-' }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="detail-badge">
                                                @foreach ($t->details as $detail)
                                                    <span class="badge bg-light text-dark border rounded-pill px-2 py-1"
                                                        style="font-weight: 500; font-size: 0.8rem;">
                                                        {{ $detail->varian->produk->nama_produk }}
                                                        <span class="text-warning ms-1 text-uppercase">{{ $detail->varian->ukuran }}</span>
                                                        <span class="text-muted ms-1">x{{ $detail->qty }}</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="fw-bold" style="font-size: 1rem; white-space: nowrap;">
                                            Rp {{ number_format($t->total, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            @php
                                                $paymentMethod = $t->metode_pembayaran ?? ($t->payment_method ?? 'tunai');
                                                $paymentLabels = [
                                                    'tunai' => ['icon' => 'bi-cash', 'text' => 'Tunai', 'class' => 'payment-tunai'],
                                                    'qris' => ['icon' => 'bi-qr-code', 'text' => 'QRIS', 'class' => 'payment-qris'],
                                                    'transfer' => ['icon' => 'bi-bank', 'text' => 'Transfer', 'class' => 'payment-transfer'],
                                                    'credit_card' => ['icon' => 'bi-credit-card', 'text' => 'Kartu', 'class' => 'payment-transfer'],
                                                ];
                                                $payment = $paymentLabels[$paymentMethod] ?? $paymentLabels['tunai'];
                                            @endphp
                                            <span class="badge {{ $payment['class'] }} px-2 py-1 rounded-pill fw-bold" style="font-size: 0.8rem;">
                                                <i class="{{ $payment['icon'] }} me-1"></i> {{ $payment['text'] }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($t->status == 'sukses' && $t->updated_at)
                                                <small class="text-muted" style="font-size: 0.8rem;">
                                                    <i class="bi bi-calendar-check me-1"></i>
                                                    {{ $t->updated_at->format('d/m/Y H:i') }}
                                                </small>
                                            @elseif($t->status == 'gagal' && $t->updated_at)
                                                <small class="text-muted" style="font-size: 0.8rem;">
                                                    <i class="bi bi-calendar-x me-1"></i>
                                                    {{ $t->updated_at->format('d/m/Y H:i') }}
                                                </small>
                                            @else
                                                <small class="text-muted fst-italic" style="font-size: 0.8rem;">-</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $t->status }} px-2 py-1 rounded-pill fw-bold" style="font-size: 0.8rem;">
                                                <i class="bi bi-{{ $t->status == 'pending' ? 'hourglass-split' : ($t->status == 'sukses' ? 'check-circle' : 'x-circle') }} me-1"></i>
                                                {{ strtoupper($t->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center pe-2 pe-md-3">
                                            @if ($t->status == 'pending')
                                                <div class="action-buttons">
                                                    <form action="{{ route('transaksi.updateStatus', $t->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="sukses">
                                                        <button type="button"
                                                            class="btn btn-sm btn-success rounded-pill px-2 px-sm-3 fw-bold shadow-sm"
                                                            style="font-size: 0.8rem;"
                                                            onclick="confirmAction(this, 'Terima Pesanan Ini?')">
                                                            <i class="bi bi-check-lg"></i> <span class="d-none d-sm-inline">Terima</span>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('transaksi.updateStatus', $t->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="gagal">
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger rounded-pill fw-bold"
                                                            style="font-size: 0.8rem;"
                                                            onclick="confirmAction(this, 'Batalkan Pesanan Ini?', 'Stok barang akan dikembalikan')">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <small class="text-muted fw-semibold fst-italic" style="font-size: 0.8rem;">
                                                    <i class="bi bi-check2-all me-1"></i>Processed
                                                </small>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 py-md-5 empty-state">
                                            <i class="bi bi-inbox text-muted"></i>
                                            <p class="text-muted mt-2 fw-medium mb-0" style="font-size: 0.85rem;">Belum ada transaksi masuk.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-3 p-md-4 border-top d-flex justify-content-center" style="border-color: var(--card-border) !important;">
                        {{ $transaksis->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // SweetAlert2 Konfirmasi Tombol (Sederhana, tanpa pilihan metode)
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

                    if (txtValueAntrean.toLowerCase().indexOf(filter) > -1 || txtValuePelanggan.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Status Online dengan Echo Reverb
        document.addEventListener('DOMContentLoaded', function() {
            const status = document.getElementById('connection-status');
            
            if (typeof Echo !== 'undefined') {
                status.classList.remove('bg-danger');
                status.classList.add('bg-success');
                status.innerHTML = '<i class="bi bi-wifi me-1"></i> Online';

                Echo.channel('kasir-channel')
                    .listen('PesananBaru', (e) => {
                        showBeautifulToast(e.jumlahPesanan);
                        const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2358/2358-preview.mp3');
                        audio.play().catch(e => console.log('Audio error:', e));
                        fetchTableData();
                    });
            } else {
                status.innerHTML = '<i class="bi bi-circle-fill me-1"></i> Offline';
            }
        });

        // Toast Responsive
        function showBeautifulToast(total) {
            const container = document.getElementById('toast-container');
            const id = 'toast-' + Date.now();

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

        function fetchTableData() {
            fetch(window.location.href)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.getElementById('transaksi-tbody').innerHTML;

                    const tbody = document.getElementById('transaksi-tbody');
                    tbody.innerHTML = newContent;

                    const firstRow = tbody.querySelector('tr');
                    if (firstRow && !firstRow.innerText.includes('Belum ada')) {
                        firstRow.classList.add('new-order-row');
                    }
                })
                .catch(err => console.log('Fetch error:', err));
        }
    </script>
</body>

</html>