@extends('layouts.admin')
@section('title', 'Tambah Produk')

@section('content')

<style>
    .text-brown-dark { color: #8b4513; }
    .text-chiiiz { color: #f4b236; }

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

    .card-neo-soft {
        background: #ffffff;
        border: none;
        border-radius: 1.2rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.04);
    }

    .form-label-custom {
        color: #8b4513;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.6rem;
    }

    .custom-input {
        background-color: #fdfcfb;
        border: 1.5px solid #eaddcf;
        border-radius: 0.8rem;
        padding: 0.9rem 1.2rem;
        font-size: 0.95rem;
    }

    .custom-input:focus {
        border-color: #f4b236;
        box-shadow: 0 0 0 0.25rem rgba(244, 178, 54, 0.15);
    }

    .upload-box {
        border: 2px dashed #eaddcf;
        border-radius: 1rem;
        min-height: 220px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background: #fdfcfb;
        cursor: pointer;
        transition: 0.2s;
    }

    .upload-box:hover {
        border-color: #f4b236;
    }

    #preview {
        max-height: 200px;
        display: none;
        border-radius: 10px;
    }
</style>

<div class="container-fluid py-4 px-md-4">

    <!-- HEADER -->
    <div class="mb-5">
        <a href="{{ route('produks.index') }}" class="text-decoration-none text-secondary small mb-3 d-inline-flex align-items-center fw-medium">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Katalog
        </a>

        <h2 class="fw-bold text-brown-dark mb-1" style="font-size: 2.2rem;">
            Input <span class="text-chiiiz">Produk Baru</span>
        </h2>

        <p class="text-secondary fw-medium">
            Tambahkan kue terbaru ke dalam koleksi ChiiiZkut.
        </p>
    </div>

    <!-- CARD -->
    <div class="card card-neo-soft p-4 p-md-5 mx-auto" style="max-width: 900px;">
        
        <form action="{{ route('produks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">

                <!-- KIRI -->
                <div class="col-md-7">

                    <div class="mb-3">
                        <label class="form-label-custom">NAMA KUE</label>
                        <input type="text" name="nama_produk" class="form-control custom-input" placeholder="Tuliskan nama produk..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">DESKRIPSI</label>
                        <textarea name="deskripsi" rows="3" class="form-control custom-input" placeholder="Berikan deskripsi singkat." required></textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label-custom">HARGA SMALL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0" style="border-color:#eaddcf;">Rp</span>
                                <input type="text" id="small_display" class="form-control custom-input border-start-0">
                                <input type="hidden" name="harga_small" id="small">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">HARGA LARGE</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0" style="border-color:#eaddcf;">Rp</span>
                                <input type="text" id="large_display" class="form-control custom-input border-start-0">
                                <input type="hidden" name="harga_large" id="large">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- KANAN -->
                <div class="col-md-5">
                    <label class="form-label-custom">VISUAL PRODUK</label>

                    <div class="upload-box" onclick="document.getElementById('gambar').click()">
                        <div id="placeholder" class="text-center">
                            <i class="bi bi-camera fs-2 text-secondary"></i>
                            <p class="fw-bold text-secondary mb-1">Unggah Foto</p>
                            <small class="text-muted">Max 2MB</small>
                        </div>

                        <img id="preview">
                        <input type="file" name="gambar" id="gambar" hidden onchange="previewImage(event)">
                    </div>
                </div>

            </div>

            <!-- ALERT -->
            <div class="alert bg-light border mt-4" style="border-color: #eaddcf; border-radius: 0.8rem;">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-info-circle-fill text-warning fs-4"></i>
                    <p class="mb-0 text-secondary small fw-medium">
                        Pastikan data produk yang dimasukkan sudah benar.
                    </p>
                </div>
            </div>

            <hr class="border-secondary-subtle mb-4" style="opacity: 0.5;">

            <!-- BUTTON -->
            <div class="d-flex justify-content-end align-items-center gap-4">
                <a href="{{ route('produks.index') }}" class="text-dark text-decoration-none fw-bold small">
                    Batalkan
                </a>

                <button type="submit" class="btn bg-yellow-custom fw-bold px-4 py-3" style="border-radius: 0.8rem;">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Produk
                </button>
            </div>

        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('placeholder');

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        placeholder.style.display = 'none';
    }
}

// format rupiah
function rupiah(display, hidden) {
    display.addEventListener('input', function(e) {
        let val = e.target.value.replace(/[^0-9]/g, '');
        hidden.value = val;
        e.target.value = val ? new Intl.NumberFormat('id-ID').format(val) : '';
    });
}

rupiah(document.getElementById('small_display'), document.getElementById('small'));
rupiah(document.getElementById('large_display'), document.getElementById('large'));
</script>

@endsection