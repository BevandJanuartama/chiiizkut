@extends('layouts.admin')
@section('title', 'Manajemen Produk')

@section('content')

<style>
    /* Menggunakan style tabel yang sama persis dengan halaman stok */
    .table-custom th {
        color: #5C3D2E;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #F0E6D2 !important;
        padding-bottom: 1rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .table-custom td {
        vertical-align: middle;
        padding: 1.25rem 0.5rem;
        border-bottom: 1px solid #F0E6D2;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .card-neo {
        background: #ffffff;
        border: 1px solid #F0E6D2;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    /* Badge styling sama seperti stok */
    .badge-stock {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 0.4em 0.8em;
        border-radius: 50rem;
    }

    .badge-stock-danger {
        background-color: #FFE5E5;
        color: #DC3545;
        border: 1px solid #FFCDCD;
    }

    .badge-stock-warning {
        background-color: #FFF4E0;
        color: #F6AA1C;
        border: 1px solid #FDEAB6;
    }

    .badge-stock-success {
        background-color: #E8F5E9;
        color: #2E7D32;
        border: 1px solid #C8E6C9;
    }

    /* Hover effect sama seperti stok */
    .hover-bg-light:hover {
        background-color: #FFFCF5;
    }

    /* Search wrapper - lebih pendek dan proporsional */
    .search-wrapper {
        position: relative;
        max-width: 280px;
        width: 100%;
    }
    
    .search-input {
        padding-left: 38px;
        border: 1px solid #F0E6D2;
        border-radius: 50px;
        background-color: #fff;
        padding-top: 0.55rem;
        padding-bottom: 0.55rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.85rem;
        width: 100%;
    }
    
    .search-input:focus {
        border-color: #F6AA1C;
        box-shadow: 0 0 0 0.2rem rgba(246, 170, 28, 0.1);
        outline: none;
    }
    
    .search-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #5C3D2E;
        font-size: 0.9rem;
    }

    /* Responsive table untuk mobile */
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table-custom th,
        .table-custom td {
            white-space: nowrap;
        }
        
        .card-neo {
            padding: 1rem !important;
        }
        
        .search-wrapper {
            max-width: 100%;
        }
    }

    /* Modal konfirmasi hapus */
    .modal-confirm {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .modal-confirm .modal-content {
        border-radius: 20px;
        border: 1px solid #F0E6D2;
        overflow: hidden;
    }
    .modal-confirm .modal-header {
        background-color: #FFF4E0;
        border-bottom: 1px solid #F0E6D2;
        padding: 1rem 1.5rem;
    }
    .modal-confirm .modal-body {
        padding: 1.5rem;
        text-align: center;
    }
    .modal-confirm .modal-footer {
        border-top: 1px solid #F0E6D2;
        padding: 1rem 1.5rem;
        background-color: #fafafa;
    }
    .modal-confirm .btn-confirm {
        background-color: #DC3545;
        color: white;
        border-radius: 10px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s;
        border: none;
    }
    .modal-confirm .btn-confirm:hover {
        background-color: #c82333;
        transform: translateY(-1px);
    }
    .modal-confirm .btn-cancel {
        background-color: #F0E6D2;
        color: #5C3D2E;
        border-radius: 10px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s;
        border: none;
    }
    .modal-confirm .btn-cancel:hover {
        background-color: #e6d8c4;
    }
    .modal-confirm .icon-warning {
        font-size: 3rem;
        color: #F6AA1C;
        margin-bottom: 1rem;
    }
</style>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="color: #8A4117; font-family: 'Lora', serif; font-weight: 700;">Manajemen <span
                style="color: #F6AA1C;">Produk</span></h2>
        <p class="text-secondary mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">Atur produk dan harga
            produk Anda di sini.</p>
    </div>
    <a href="{{ route('produks.create') }}"
        class="btn fw-bold px-4 py-2 mt-3 mt-md-0 rounded-3 shadow-sm d-inline-flex align-items-center gap-2"
        style="background-color: #F6AA1C; color: #5C3D2E; font-family: 'Plus Jakarta Sans', sans-serif;">
        <i class="bi bi-plus-lg"></i> Tambah Baru
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm fw-bold mb-4"
        role="alert" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm fw-bold mb-4"
        role="alert" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card card-neo p-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom"
        style="border-color: #F0E6D2 !important;">
        <form action="{{ route('produks.index') }}" method="GET" class="search-wrapper mb-3 mb-md-0">
            <i class="bi bi-search"></i>
            <input type="text" name="search" class="form-control search-input"
                placeholder="Cari nama kue atau deskripsi..." value="{{ request('search') }}">
        </form>

        <div class="text-secondary small mt-2 mt-md-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            Total: <span class="fw-bold text-dark">{{ $produks->total() }}</span> Produk
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-custom table-borderless align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-3" style="width: 10%; min-width: 80px;">GAMBAR</th>
                    <th style="width: 20%; min-width: 150px;">NAMA PRODUK</th>
                    <th style="width: 30%; min-width: 200px;">DESKRIPSI</th>
                    <th class="text-center" style="width: 15%; min-width: 120px;">SIZE SMALL</th>
                    <th class="text-center" style="width: 15%; min-width: 120px;">SIZE LARGE</th>
                    <th class="text-center pe-3" style="width: 10%; min-width: 90px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produks as $produk)
                    @php
                        $vSmall = $produk->varians->where('ukuran', 'small')->first();
                        $vLarge = $produk->varians->where('ukuran', 'large')->first();
                    @endphp
                    <tr class="hover-bg-light transition" id="row-{{ $produk->id }}">
                        <td class="ps-3">
                            <img src="{{ asset('storage/' . $produk->gambar) }}" class="rounded-3 product-img-mobile"
                                style="width: 65px; height: 65px; object-fit: cover; border: 1px solid #F0E6D2;"
                                alt="{{ $produk->nama_produk }}">
                        </td>
                        <td class="fw-bold" style="color: #5C3D2E; font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $produk->nama_produk }}</td>
                        <td class="text-secondary small" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ Str::limit($produk->deskripsi, 60) }}</td>

                        <td class="text-center">
                            @if ($vSmall)
                                <div class="fw-bold mb-1"
                                    style="color: #5C3D2E; font-family: 'Plus Jakarta Sans', sans-serif;">Rp
                                    {{ number_format($vSmall->harga, 0, ',', '.') }}</div>
                                <span
                                    class="badge-stock 
                                    {{ $vSmall->stok <= 0 ? 'badge-stock-danger' : ($vSmall->stok < 10 ? 'badge-stock-warning' : 'badge-stock-success') }}">
                                    Stok: {{ $vSmall->stok }}
                                </span>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if ($vLarge)
                                <div class="fw-bold mb-1"
                                    style="color: #5C3D2E; font-family: 'Plus Jakarta Sans', sans-serif;">Rp
                                    {{ number_format($vLarge->harga, 0, ',', '.') }}</div>
                                <span
                                    class="badge-stock 
                                    {{ $vLarge->stok <= 0 ? 'badge-stock-danger' : ($vLarge->stok < 10 ? 'badge-stock-warning' : 'badge-stock-success') }}">
                                    Stok: {{ $vLarge->stok }}
                                </span>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>

                        <td class="text-center pe-3">
                            <a href="{{ route('produks.edit', $produk->id) }}" class="btn btn-sm btn-action-edit"
                                style="background-color: #FFF4E0; color: #F6AA1C; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 0.4rem; transition: all 0.2s;"
                                onmouseover="this.style.backgroundColor='#F6AA1C'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='#FFF4E0'; this.style.color='#F6AA1C';">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-delete-trigger"
                                data-id="{{ $produk->id }}"
                                data-name="{{ $produk->nama_produk }}"
                                style="background-color: #FFE5E5; color: #DC3545; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 0.4rem; border: none; transition: all 0.2s;"
                                onmouseover="this.style.backgroundColor='#DC3545'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='#FFE5E5'; this.style.color='#DC3545';">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                <i class="bi bi-search display-4 d-block mb-3 opacity-25"></i>
                                @if (request('search'))
                                    Produk "{{ request('search') }}" tidak ditemukan.
                                @else
                                    Belum ada produk. Klik "Tambah Baru" untuk menambahkan produk.
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center justify-content-md-end mt-4 pt-3 border-top"
        style="border-color: #F0E6D2 !important;">
        {{ $produks->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade modal-confirm" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="deleteModalLabel" style="color: #5C3D2E;">
                    <i class="bi bi-exclamation-triangle-fill me-2" style="color: #F6AA1C;"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="icon-warning">
                    <i class="bi bi-trash3-fill"></i>
                </div>
                <p class="mb-0" style="font-size: 1rem;">
                    Apakah Anda yakin ingin menghapus produk <br>
                    <strong id="product-name-delete" style="color: #8A4117; font-size: 1.1rem;"></strong>?
                </p>
                <p class="text-muted small mt-3 mb-0">
                    <i class="bi bi-info-circle"></i> Tindakan ini tidak dapat dibatalkan. Semua data varian produk juga akan terhapus.
                </p>
            </div>
            <div class="modal-footer d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Batal
                </button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-confirm">
                        <i class="bi bi-check-lg me-1"></i> Ya, Hapus!
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi modal
        const deleteModalElement = document.getElementById('deleteModal');
        const deleteModal = new bootstrap.Modal(deleteModalElement);
        const deleteForm = document.getElementById('deleteForm');
        
        // Event listener untuk semua tombol hapus
        document.querySelectorAll('.btn-delete-trigger').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                
                // Set nama produk di modal
                document.getElementById('product-name-delete').textContent = productName;
                
                // PERBAIKAN UTAMA: Set action form dengan URL yang benar
                // Karena route memiliki prefix 'admin', maka URL harus /admin/produks/{id}
                deleteForm.action = `/admin/produks/${productId}`;
                
                // Tampilkan modal
                deleteModal.show();
            });
        });
        
        // Handle form submit untuk loading state
        deleteForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('.btn-confirm');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Menghapus...';
        });
    });
</script>
@endpush