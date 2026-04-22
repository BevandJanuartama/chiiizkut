@extends('layouts.admin')
@section('title', 'Update Stok')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<style>
    /* Variabel Warna */
    .text-brown-dark { color: #8b4513; }
    .text-chiiiz { color: #f4b236; }
    
    /* Tombol Kustom */
    .bg-yellow-custom { 
        background-color: #f4b236; 
        color: white; 
        border: none; 
        transition: all 0.2s ease-in-out;
    }
    .bg-yellow-custom:hover { 
        background-color: #e09d2a; 
        color: white; 
        transform: translateY(-1px);
    }
    
    /* Kotak Form Utama */
    .card-neo-soft {
        background: #ffffff;
        border: none;
        border-radius: 1.2rem;
        box-shadow: 0 8px 30px rgt(0,0,0,0.04);
        min-height: 550px; /* Menambah tinggi vertikal form */
    }
    
    /* Label Form */
    .form-label-custom {
        color: #8b4513;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.6rem;
    }

    /* Input Kustom */
    .custom-input {
        background-color: #fdfcfb;
        border: 1.5px solid #eaddcf;
        border-radius: 0.8rem;
        padding: 1rem 1.25rem;
        color: #333;
        font-size: 1rem;
        transition: all 0.2s;
    }
    .custom-input:focus {
        border-color: #f4b236;
        box-shadow: 0 0 0 0.25rem rgba(244, 178, 54, 0.15);
        outline: none;
    }
    .custom-input.is-invalid {
        border-color: #dc3545;
        background-color: #fcf6f6;
    }

    /* ==========================================
       STYLING KHUSUS SELECT2
       ========================================== */
    .select2-container--bootstrap-5 .select2-selection {
        background-color: #fdfcfb !important;
        border: 1.5px solid #eaddcf !important;
        border-radius: 0.8rem !important;
        padding: 0.5rem 0.2rem !important;
        min-height: 56px;
        color: #333;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #f4b236 !important;
        box-shadow: 0 0 0 0.25rem rgba(244, 178, 54, 0.15) !important;
    }
    .select2-container--bootstrap-5 .select2-dropdown {
        border-color: #eaddcf;
        border-radius: 0.8rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .select2-container--bootstrap-5 .select2-results__group {
        background-color: #fbf5ea;
        color: #8b4513;
        font-weight: 800;
        font-size: 0.85rem;
        text-transform: uppercase;
        padding: 8px 12px;
        letter-spacing: 0.5px;
    }
    .select2-container--bootstrap-5 .select2-results__options .select2-results__option--group {
        border-bottom: 1px solid #f0e6d8;
    }
    .select2-container--bootstrap-5 .select2-results__options .select2-results__option--group:last-child {
        border-bottom: none;
    }
</style>

<div class="container-fluid py-4 px-md-4">
    
    <div class="mb-5">
        <a href="{{ route('stok.logs') }}" class="text-decoration-none text-secondary small mb-3 d-inline-flex align-items-center fw-medium">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Riwayat
        </a>
        <h2 class="fw-bold text-brown-dark mb-1" style="font-size: 2.2rem;">
            Update <span class="text-chiiiz">Stok Produk</span>
        </h2>
        <p class="text-secondary fw-medium">Tambahkan jumlah stok ke produk yang sudah ada di inventaris.</p>
    </div>

    <div class="card card-neo-soft p-4 p-md-5 mx-auto d-flex flex-column" style="max-width: 800px;">
        <form action="{{ route('stok.update') }}" method="POST" class="flex-grow-1 d-flex flex-column">
            @csrf
            @method('PUT')

            <div class="mb-4 pb-2">
                <label class="form-label-custom">PILIH PRODUK <span class="text-danger">*</span></label>
                
                <select name="produk_varian_id" id="produkSelect" required class="form-select custom-input fw-medium text-secondary @error('produk_varian_id') is-invalid @enderror">
                    <option></option> @foreach($produks as $produk)
                        <optgroup label="{{ $produk->nama_produk }}">
                            @foreach($produk->varians as $varian)
                                <option value="{{ $varian->id }}" {{ old('produk_varian_id') == $varian->id ? 'selected' : '' }}>
                                    Ukuran {{ strtoupper($varian->ukuran) }} &nbsp;&mdash;&nbsp; Stok Saat Ini: {{ $varian->stok }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>

                @error('produk_varian_id')
                    <div class="text-danger small fw-bold mt-2"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="row g-4 mb-4 pb-2">
                
                <div class="col-md-6">
                    <label class="form-label-custom">JUMLAH TAMBAHAN <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 @error('jumlah_stok') border-danger bg-danger-subtle @enderror" style="border-color: #eaddcf; border-top-left-radius: 0.8rem; border-bottom-left-radius: 0.8rem; padding: 1rem;">
                            <i class="bi bi-box-seam text-secondary"></i>
                        </span>
                        <input type="number" name="jumlah_stok" min="1" max="1000" class="form-control custom-input border-start-0 ps-1 fw-medium @error('jumlah_stok') is-invalid @enderror" placeholder="Misal: 50" value="{{ old('jumlah_stok') }}" required style="border-top-left-radius: 0; border-bottom-left-radius: 0; background-color: #fdfcfb;">
                    </div>
                    @error('jumlah_stok')
                        <div class="text-danger small fw-bold mt-2"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}</div>
                    @else
                        <div class="form-text small text-secondary mt-2">*Stok otomatis dijumlahkan dengan stok saat ini.</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label-custom">KETERANGAN <span class="text-muted fw-normal text-lowercase">(Opsional)</span></label>
                    <input type="text" name="keterangan" class="form-control custom-input fw-medium @error('keterangan') is-invalid @enderror" placeholder="Contoh: Baru Keluar Dari Produksi" value="{{ old('keterangan') }}" maxlength="100">
                    @error('keterangan')
                        <div class="text-danger small fw-bold mt-2"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="alert bg-light border mt-auto mb-4" style="border-color: #eaddcf !important; border-radius: 0.8rem;">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-info-circle-fill text-warning fs-4"></i>
                    <p class="mb-0 text-secondary small fw-medium">
                        Pastikan jumlah barang yang dimasukkan sudah sesuai.
                    </p>
                </div>
            </div>

            <hr class="border-secondary-subtle mb-4" style="opacity: 0.5;">

            <div class="d-flex justify-content-end align-items-center gap-4">
                <a href="{{ route('stok.logs') }}" class="text-dark text-decoration-none fw-bold small transition" style="letter-spacing: 0.5px;">Batalkan</a>
                <button type="submit" class="btn bg-yellow-custom fw-bold px-4 py-3" style="border-radius: 0.8rem; font-size: 1rem;">
                    <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2 pada dropdown produk
        $('#produkSelect').select2({
            theme: 'bootstrap-5',
            placeholder: "Tentukan produk yang ingin ditambah stoknya...",
            allowClear: true,
            width: '100%' // Memastikan dropdown memenuhi lebar kotak input
        });
    });
</script>

@endsection