<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChiiiZkut - Kasir Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background-color: #000 !important; border-bottom: 3px solid #F2AF17; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        
        /* Animasi Highlight untuk baris baru */
        @keyframes highlightFade {
            0% { background-color: #fff3cd; transform: scale(1.01); }
            100% { background-color: transparent; transform: scale(1); }
        }
        .new-order-row { animation: highlightFade 4s ease-out; border-left: 5px solid #F2AF17 !important; }
        
        .badge-pending { background-color: #ffc107; color: #000; font-weight: 800; }
        .badge-sukses { background-color: #198754; color: #fff; }
        .badge-gagal { background-color: #dc3545; color: #fff; }
        
        /* Styling Toast/Popup */
        #toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark mb-4">
        <div class="container">
            <span class="navbar-brand fw-bold italic">CHIIIZ <span style="color: #F2AF17;">KASIR</span></span>
            <div class="d-flex align-items-center">
                <span id="connection-status" class="badge bg-danger me-2">Offline</span>
                <button class="btn btn-sm btn-outline-warning" onclick="fetchTableData()">Manual Sync</button>
            </div>
        </div>
    </nav>

    <div class="container">
        <div id="toast-container"></div>

        <div class="row">
            <div class="col-12">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Monitoring Pesanan Hari Ini</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Antrean</th>
                                        <th>Pelanggan</th>
                                        <th>Pesanan</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="transaksi-tbody">
                                    @forelse($transaksis as $t)
                                    <tr id="row-{{ $t->id }}" class="transition-all">
                                        <td class="ps-4 fw-bold text-primary">#{{ str_pad($t->nomor_antrean, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $t->nama ?? 'Guest' }}</div>
                                            <small class="text-muted">{{ $t->telepon ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <div class="small">
                                                @foreach($t->details as $detail)
                                                    <span class="badge bg-light text-dark border">{{ $detail->produk->nama_produk }} x{{ $detail->qty }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="fw-bold">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $t->status }} px-3 py-2 rounded-pill">
                                                {{ strtoupper($t->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($t->status == 'pending')
                                                <div class="btn-group">
                                                    <form action="{{ route('transaksi.updateStatus', $t->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="sukses">
                                                        <button class="btn btn-sm btn-success px-3">Terima</button>
                                                    </form>
                                                    <form action="{{ route('transaksi.updateStatus', $t->id) }}" method="POST" class="ms-1">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="gagal">
                                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Batalkan?')">X</button>
                                                    </form>
                                                </div>
                                            @else
                                                <small class="text-muted italic">Processed</small>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">Belum ada transaksi masuk.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Echo !== 'undefined') {
                const status = document.getElementById('connection-status');
                status.classList.replace('bg-danger', 'bg-success');
                status.innerText = 'Online';

                // Listen Sinyal Reverb
                Echo.channel('kasir-channel')
                    .listen('PesananBaru', (e) => {
                        console.log('Sinyal Masuk:', e);

                        // 1. TAMPILKAN POPUP (TOAST)
                        showToast(e.jumlahPesanan);

                        // 2. MAIN KAN SUARA
                        const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2358/2358-preview.mp3');
                        audio.play();

                        // 3. UPDATE TABEL (TANPA RELOAD)
                        fetchTableData();
                    });
            }
        });

        function showToast(total) {
            const container = document.getElementById('toast-container');
            const id = 'toast-' + Date.now();
            
            container.innerHTML = `
                <div id="${id}" class="alert alert-warning border-0 shadow-lg d-flex align-items-center show fade" role="alert" style="border-left: 5px solid #000 !important;">
                    <div class="flex-grow-1">
                        <strong class="d-block">Pesanan Baru Masuk! 🧀</strong>
                        <small>Ada total ${total} antrean pending saat ini.</small>
                    </div>
                    <button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>
                </div>
            `;

            // Hilang otomatis dalam 6 detik
            setTimeout(() => {
                const toastEl = document.getElementById(id);
                if(toastEl) toastEl.classList.remove('show');
            }, 6000);
        }

        function fetchTableData() {
            // Kita hit ke URL yang sama (index)
            fetch(window.location.href)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.getElementById('transaksi-tbody').innerHTML;
                    
                    const tbody = document.getElementById('transaksi-tbody');
                    tbody.innerHTML = newContent;

                    // Beri efek highlight pada baris teratas (paling baru)
                    const firstRow = tbody.querySelector('tr');
                    if(firstRow && !firstRow.innerText.includes('Belum ada')) {
                        firstRow.classList.add('new-order-row');
                    }
                });
        }
    </script>
</body>
</html>