<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-cream);
            color: var(--text-brown);
        }

        /* Typography */
        .font-serif {
            font-family: 'Lora', serif;
            color: var(--brand-dark);
        }

        /* Navbar Custom */
        .navbar-custom {
            background-color: #ffffff;
            border-bottom: 2px solid var(--card-border);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            padding: 1rem 0;
        }

        /* Card & Table Elements */
        .card-soft {
            background: #fff;
            border: 1px solid var(--card-border);
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            overflow: hidden;
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

        .table-custom th {
            background-color: #F3EBE1;
            color: var(--brand-dark);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: none;
            padding: 1.2rem 1rem;
        }

        .table-custom td {
            vertical-align: middle;
            border-bottom: 1px solid var(--card-border);
            padding: 1rem;
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

        /* Toast Container Custom */
        #toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        /* Pagination Styling */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            color: var(--text-brown);
            border-color: var(--card-border);
        }

        .page-item.active .page-link {
            background-color: var(--brand-yellow);
            border-color: var(--brand-yellow);
            color: #fff;
        }
    </style>
</head>

<body>
    <nav class="navbar-custom mb-5 sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo ChiiiZkut"
                    style="max-height: 55px; object-fit: contain;">
            </div>

            <div class="d-flex align-items-center gap-3">
                <span id="connection-status" class="badge bg-danger rounded-pill px-3 py-2">
                    <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Offline
                </span>
                <button class="btn btn-outline-secondary rounded-pill btn-sm fw-bold px-3" onclick="fetchTableData()">
                    <i class="bi bi-arrow-clockwise"></i> Sync
                </button>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger rounded-pill btn-sm fw-bold px-4">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
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
                    <div class="p-4 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3"
                        style="border-color: var(--card-border) !important;">
                        <div>
                            <h4 class="font-serif fw-bold mb-1">Monitoring Antrean</h4>
                            <p class="text-muted small mb-0">Kelola pesanan masuk hari ini.</p>
                        </div>
                        <div class="search-bar d-flex align-items-center" style="min-width: 300px;">
                            <i class="bi bi-search text-muted me-2"></i>
                            <input type="text" id="searchInput" placeholder="Cari nama atau no antrean..."
                                onkeyup="filterTable()">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-custom mb-0" id="transaksiTable">
                            <thead>
                                <tr>
                                    <th class="ps-4">Antrean</th>
                                    <th>Pelanggan</th>
                                    <th>Detail Pesanan</th>
                                    <th>Total Tagihan</th>
                                    <th>Status</th>
                                    <th class="text-center pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="transaksi-tbody">
                                @forelse($transaksis as $t)
                                    <tr id="row-{{ $t->id }}">
                                        <td class="ps-4 fw-bolder"
                                            style="color: var(--brand-yellow); font-size: 1.1rem;">
                                            #{{ str_pad($t->nomor_antrean, 3, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $t->nama ?? 'Guest' }}</div>
                                            <small class="text-muted"><i
                                                    class="bi bi-whatsapp me-1"></i>{{ $t->telepon ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach ($t->details as $detail)
                                                    <span class="badge bg-light text-dark border rounded-pill px-2 py-1"
                                                        style="font-weight: 500;">
                                                        {{ $detail->varian->produk->nama_produk }}
                                                        <span class="text-warning ms-1 text-uppercase">{{ $detail->varian->ukuran }}</span>
                                                        <span class="text-muted ms-1">x{{ $detail->qty }}</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="fw-bold">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $t->status }} px-3 py-2 rounded-pill fw-bold">
                                                {{ strtoupper($t->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center pe-4">
                                            @if ($t->status == 'pending')
                                                <div class="d-flex justify-content-center gap-2">
                                                    <form action="{{ route('transaksi.updateStatus', $t->id) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="sukses">
                                                        <button type="button"
                                                            class="btn btn-sm btn-success rounded-pill px-3 fw-bold shadow-sm"
                                                            onclick="confirmAction(this, 'Terima Pesanan Ini?')">
                                                            <i class="bi bi-check-lg"></i> Terima
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('transaksi.updateStatus', $t->id) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="gagal">
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger rounded-pill fw-bold"
                                                            onclick="confirmAction(this, 'Batalkan Pesanan Ini?', 'Stok barang akan dikembalikan')">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <small class="text-muted fw-semibold fst-italic">Processed</small>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-2 fw-medium">Belum ada transaksi masuk.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 border-top d-flex justify-content-center"
                        style="border-color: var(--card-border) !important;">
                        {{ $transaksis->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // SweetAlert2 Konfirmasi Tombol (Sangat Menarik)
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
                    button.closest('form').submit(); // Submit form jika diklik Ya
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
                // Kolom 0 = Antrean, Kolom 1 = Pelanggan
                let tdAntrean = tr[i].getElementsByTagName("td")[0];
                let tdPelanggan = tr[i].getElementsByTagName("td")[1];

                if (tdAntrean || tdPelanggan) {
                    let txtValueAntrean = tdAntrean.textContent || tdAntrean.innerText;
                    let txtValuePelanggan = tdPelanggan.textContent || tdPelanggan.innerText;

                    if (txtValueAntrean.toLowerCase().indexOf(filter) > -1 || txtValuePelanggan.toLowerCase().indexOf(
                            filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Echo Reverb Websocket Logic (Sama seperti sebelumnya)
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Echo !== 'undefined') {
                const status = document.getElementById('connection-status');
                status.classList.replace('bg-danger', 'bg-success');
                status.innerHTML = '<i class="bi bi-wifi me-1"></i> Online';

                Echo.channel('kasir-channel')
                    .listen('PesananBaru', (e) => {
                        showBeautifulToast(e.jumlahPesanan);
                        const audio = new Audio(
                            'https://assets.mixkit.co/active_storage/sfx/2358/2358-preview.mp3');
                        audio.play();
                        fetchTableData();
                    });
            }
        });

        // Toast yang diubah gayanya agar senada dengan bakery
        function showBeautifulToast(total) {
            const container = document.getElementById('toast-container');
            const id = 'toast-' + Date.now();

            container.innerHTML = `
                <div id="${id}" class="alert alert-warning border-0 shadow-lg d-flex align-items-center show fade" role="alert" style="background-color: #fff; border-left: 6px solid #F6AA1C !important; border-radius: 12px;">
                    <div class="flex-grow-1">
                        <strong class="d-block" style="color: #8A4117;"><i class="bi bi-bell-fill text-warning me-2"></i>Pesanan Baru Masuk!</strong>
                        <small class="text-muted">Ada total <b class="text-dark">${total}</b> antrean pending saat ini.</small>
                    </div>
                    <button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>
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
                });
        }
    </script>
</body>

</html>
