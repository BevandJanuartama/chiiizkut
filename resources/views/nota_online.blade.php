<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota {{ $transaksi->kode_unik }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 1rem;
        }
        .invoice-wrapper {
            width: 100%;
            max-width: 480px; 
        }
        .invoice-card {
            background-color: #ffffff;
            border: 2px solid #0088ff; 
            border-radius: 8px;
            padding: 2.5rem 2.2rem; 
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        .invoice-card::before {
            content: "";
            position: absolute;
            top: 4px;   
            left: 4px;  
            right: 4px; 
            height: 25px; 
            background-color: #333333; 
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }
        .logo-text {
            color: #ffb703;
            font-weight: 900;
            font-size: 2.2rem; 
            letter-spacing: 1px;
            margin-top: 0.5rem;
        }
        .dotted-divider {
            border-top: 2px dotted #f4d03f;
            margin: 1.3rem 0;
        }
        .text-yellow-custom {
            color: #ffb703;
        }
        .status-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 1rem;
            font-size: 1.05rem; 
        }
        .btn-download {
            background-color: #ffb703;
            color: #ffffff;
            font-weight: bold;
            border-radius: 30px;
            padding: 1rem; 
            font-size: 1.1rem;
            transition: all 0.2s ease-in-out;
        }
        .btn-download:hover {
            background-color: #fb8500;
            color: #ffffff;
        }
        .content-text {
            font-size: 1rem;
        }
        .sub-text {
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="invoice-wrapper">
        
        <div class="invoice-card mb-3" id="kertas-nota">
            
            <div class="text-center mb-4 mt-2">
                <div class="mb-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Chiiizkut" style="max-height: 70px; object-fit: contain;">
                </div>
                <h5 class="fw-bold mb-1 fs-4">INVOICE</h5>
                <div class="text-secondary content-text">#{{ $transaksi->kode_unik }}</div>
                <div class="text-secondary content-text">{{ $transaksi->created_at->format('d M Y') }}</div>
            </div>

            <div class="dotted-divider"></div>

            <div class="d-flex justify-content-between content-text mb-2">
                <span class="text-secondary">Pelanggan</span>
                <span class="fw-bold">{{ $transaksi->nama ?? 'Guest' }}</span>
            </div>
            <div class="d-flex justify-content-between content-text mb-2">
                <span class="text-secondary">No Hp</span>
                <span class="fw-bold text-dark">
                    <i class="fa-brands fa-whatsapp text-success me-1"></i>{{ $transaksi->telepon ?? '-' }}
                </span>
            </div>
            <div class="d-flex justify-content-between content-text mb-2">
                <span class="text-secondary">Tipe Pesanan</span>
                <span class="fw-bold">{{ $transaksi->tipe_pesanan ?? 'Take Away' }}</span>
            </div>

            <div class="dotted-divider"></div>

            @foreach($transaksi->details as $detail)
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <div class="fw-bold content-text">{{ $detail->varian->produk->nama_produk }}</div>
                    <div class="text-secondary sub-text">
                        {{ $detail->qty }} x Rp {{ number_format($detail->subtotal / $detail->qty, 0, ',', '.') }}
                    </div>
                </div>
                <div class="fw-bold content-text align-self-center">
                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                </div>
            </div>
            @endforeach

            <div class="dotted-divider"></div>

            <div class="d-flex justify-content-between content-text mb-2">
                <span class="text-secondary">Subtotal</span>
                <span class="fw-bold">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
            </div>

            <div class="dotted-divider"></div>

            <div class="d-flex justify-content-between mb-4 mt-2">
                <span class="fw-bold text-dark fs-5">Total Pembayaran</span>
                <span class="fw-bold text-dark fs-5">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
            </div>

            <div class="status-box text-center mb-4">
                <span class="text-success fs-5 align-middle"><i class="fa-solid fa-circle-check"></i></span>
                <span class="fw-bold text-secondary ms-2 align-middle">Pembayaran Berhasil</span>
            </div>

            <div class="text-center mt-2">
                <div class="text-yellow-custom fw-bold content-text">"Life is better with a box of Chiiizkut"</div>
                <div class="text-secondary mt-1 sub-text">Terimakasih telah berbelanja di Chiiizkut</div>
            </div>
            
        </div>

        <button class="btn btn-download w-100 border-0 shadow-sm" onclick="unduhSebagaiGambar()">
            <i class="fa-solid fa-download me-2"></i> Unduh Struk
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        function unduhSebagaiGambar() {
            // Ambil elemen yang ingin dijadikan gambar berdasarkan ID
            const elemenNota = document.getElementById('kertas-nota');
            
            // Ubah teks tombol sementara agar user tahu sedang diproses
            const tombol = document.querySelector('.btn-download');
            const teksAsli = tombol.innerHTML;
            tombol.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Memproses...';
            tombol.disabled = true;

            // Gunakan html2canvas
            html2canvas(elemenNota, {
                scale: 2, // Membuat kualitas gambar HD (tidak blur)
                useCORS: true, // Mengizinkan render gambar eksternal (logo)
                backgroundColor: "#ffffff" // Background warna putih
            }).then(canvas => {
                // Buat elemen link <a> sementara
                let link = document.createElement('a');
                // Set nama file saat diunduh otomatis
                link.download = 'Nota-Chiiizkut-{{ $transaksi->kode_unik }}.png';
                // Ubah canvas menjadi URL Data gambar
                link.href = canvas.toDataURL('image/png');
                // Klik link tersebut secara otomatis
                link.click();

                // Kembalikan tombol seperti semula
                tombol.innerHTML = teksAsli;
                tombol.disabled = false;
            }).catch(err => {
                console.error("Terjadi kesalahan saat mengunduh: ", err);
                alert("Gagal mengunduh nota. Silakan coba lagi.");
                
                tombol.innerHTML = teksAsli;
                tombol.disabled = false;
            });
        }
    </script>
</body>
</html>