@extends('layouts.admin')
@section('title', 'Riwayat Stok')

@section('content')

<style>
    /* Menggunakan font dan style yang sama persis dengan halaman produk */
    .text-brown-dark { color: #5C3D2E; }
    .text-brown-light { color: #a66a42; }
    .bg-yellow-custom { background-color: #F6AA1C; color: #5C3D2E; border: none; font-weight: 700; }
    .bg-yellow-custom:hover { background-color: #e09d2a; color: #5C3D2E; }
    
    .card-neo {
        background: #ffffff;
        border: 1px solid #F0E6D2;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    
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

    /* Search Input Styling - sama seperti produk */
    .search-wrapper {
        position: relative;
        max-width: 350px;
        width: 100%;
    }
    .search-wrapper i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #5C3D2E;
    }
    .search-input {
        padding-left: 40px;
        border: 1px solid #F0E6D2;
        border-radius: 50px;
        background-color: #fff;
        transition: all 0.2s;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9rem;
        padding-top: 0.6rem;
        padding-bottom: 0.6rem;
    }
    .search-input:focus {
        border-color: #F6AA1C;
        box-shadow: 0 0 0 0.25rem rgba(246, 170, 28, 0.15);
        outline: none;
    }
    
    /* Pagination Styling */
    .pagination-wrapper .pagination {
        margin: 0;
        gap: 5px;
    }
    .pagination-wrapper .page-item .page-link {
        color: #5C3D2E;
        background-color: #fff;
        border: 1px solid #F0E6D2;
        border-radius: 0.5rem;
        padding: 0.5rem 0.85rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .pagination-wrapper .page-item .page-link:hover,
    .pagination-wrapper .page-item .page-link:focus {
        background-color: #FFF4E0;
        color: #F6AA1C;
        border-color: #F6AA1C;
        box-shadow: none;
    }
    .pagination-wrapper .page-item.active .page-link {
        background-color: #F6AA1C;
        border-color: #F6AA1C;
        color: #5C3D2E;
    }
    .pagination-wrapper .page-item.disabled .page-link {
        color: #ccc;
        background-color: #f9f9f9;
        border-color: #eee;
    }

    /* Badge styling */
    .badge-custom {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
    }

    /* Hover effect */
    .hover-bg-light:hover {
        background-color: #FFFCF5;
    }
</style>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-1" style="color: #8A4117; font-family: 'Lora', serif; font-weight: 700;">Riwayat <span style="color: #F6AA1C;">Stok Produk</span></h2>
        <p class="text-secondary mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 500;">Riwayat aktivitas penambahan stok produk secara mendetail.</p>
    </div>
    <a href="{{ route('stok.edit') }}" class="btn bg-yellow-custom fw-bold px-4 py-2 rounded-3 shadow-sm d-inline-flex align-items-center gap-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <i class="bi bi-plus-lg"></i>
        TAMBAH STOK
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm fw-bold mb-4" role="alert" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card card-neo p-4">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom" style="border-color: #F0E6D2 !important;">
        <form action="{{ route('stok.logs') }}" method="GET" class="search-wrapper mb-3 mb-md-0">
            <i class="bi bi-search"></i>
            <input type="text" name="search" class="form-control search-input" placeholder="Cari nama produk atau keterangan..." value="{{ request('search') }}">
        </form>
        
        <div class="text-secondary small fw-medium" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            Menampilkan <span class="fw-bold text-dark">{{ $logs->firstItem() ?? 0 }}</span> - <span class="fw-bold text-dark">{{ $logs->lastItem() ?? 0 }}</span> dari <span class="fw-bold text-dark">{{ $logs->total() }}</span> riwayat.
        </div>
    </div>

    <div class="table-responsive mb-3">
        <table class="table table-custom table-borderless align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-3" style="font-family: 'Plus Jakarta Sans', sans-serif;">WAKTU / TANGGAL</th>
                    <th style="font-family: 'Plus Jakarta Sans', sans-serif;">NAMA PRODUK</th>
                    <th class="text-center" style="font-family: 'Plus Jakarta Sans', sans-serif;">JUMLAH</th>
                    <th class="text-center" style="font-family: 'Plus Jakarta Sans', sans-serif;">PERUBAHAN STOK</th>
                    <th class="pe-3" style="font-family: 'Plus Jakarta Sans', sans-serif;">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="hover-bg-light transition">
                    <td class="ps-3">
                        <span class="d-block fw-bold" style="color: #5C3D2E; font-family: 'Plus Jakarta Sans', sans-serif;">{{ $log->created_at->timezone('Asia/Makassar')->format('d M Y') }}</span>
                        <span class="text-muted small" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $log->created_at->timezone('Asia/Makassar')->format('H:i') }} WITA</span>
                    </td>

                    <td>
                        @php
                            $produk = optional($log->produkVarian->produk);
                            $ukuran = optional($log->produkVarian)->ukuran;
                            $isSmall = $ukuran === 'small';
                        @endphp

                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold" style="color: #5C3D2E; font-family: 'Plus Jakarta Sans', sans-serif; text-transform: uppercase;">
                                {{ $produk->nama_produk ?? '-' }}
                            </span>

                            @if($ukuran)
                                <span class="badge border rounded-2 px-2 py-1 text-uppercase" style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; font-size: 0.7rem;
                                    {{ $isSmall ? 'background-color: #FFF4E0; color: #F6AA1C; border-color: #F6AA1C;' : 'background-color: #FFF4E0; color: #8A4117; border-color: #8A4117;' }}">
                                    {{ $ukuran }}
                                </span>
                            @endif
                        </div>
                    </td>

                    <td class="text-center">
                        <span class="badge rounded-pill px-3 py-2 fw-bold" style="font-size: 0.9rem; font-family: 'Plus Jakarta Sans', sans-serif; background-color: #E8F5E9; color: #2E7D32; border: 1px solid #C8E6C9;">
                            +{{ $log->jumlah_masuk }}
                        </span>
                    </td>

                    <td class="text-center">
                        <div class="d-flex align-items-center justify-content-center gap-2 small" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <span class="text-muted fw-semibold">{{ $log->stok_sebelumnya }}</span>
                            <i class="bi bi-arrow-right" style="color: #5C3D2E;"></i>
                            <span class="fw-bold" style="color: #5C3D2E;">{{ $log->stok_sesudahnya }}</span>
                        </div>
                    </td>

                    <td class="text-muted fst-italic small pe-3" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ $log->keterangan ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-5 text-center fw-bold text-muted text-uppercase" style="letter-spacing: 1px; font-family: 'Plus Jakarta Sans', sans-serif;">
                        @if(request('search'))
                            Pencarian "{{ request('search') }}" tidak ditemukan.
                        @else
                            Belum ada riwayat stok masuk.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center justify-content-md-end mt-4 pt-3 border-top pagination-wrapper" style="border-color: #F0E6D2 !important;">
        {{ $logs->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection