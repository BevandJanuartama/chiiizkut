<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChiiiZkut - Self Ordering Kiosk</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #ffffff;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        
        .bg-chiiiz { background-color: #F2AF17 !important; }
        .text-chiiiz { color: #F2AF17 !important; }
        
        .kiosk-container { 
            background-color: #ffffff; 
            height: 100vh; 
            max-width: 1600px;
            margin: 0 auto;
        }
        
        .product-card { 
            border: 1px solid rgba(0,0,0,0.05); 
            border-radius: 20px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.03); 
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            background: #ffffff;
            position: relative;
        }
        .product-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 12px 25px rgba(0,0,0,0.08); 
        }
        .img-wrapper { overflow: hidden; border-top-left-radius: 20px; border-top-right-radius: 20px; position: relative; }
        .product-img { height: 150px; object-fit: cover; width: 100%; transition: transform 0.5s ease; }
        .product-card:hover .product-img { transform: scale(1.05); }

        .best-seller-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: linear-gradient(135deg, #F2AF17 0%, #e09e15 100%);
            color: #2c2c2c;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 20px;
            z-index: 11;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .btn-tambah { background-color: #F2AF17; color: black; border-radius: 50px; font-weight: 700; font-size: 0.85rem; border: none; padding: 8px 15px; transition: all 0.2s ease-in-out; }
        .btn-tambah:hover { background-color: #e09e15; transform: translateY(-2px); }
        .btn-tambah:active { transform: scale(0.95); }
        .icon-tambah { background-color: #212529; color: #F2AF17; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.6rem; margin-right: 6px; }

        .sidebar-wrapper {
            background-color: #ffffff;
            border-radius: 24px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.06);
            overflow: hidden;
        }
        
        .sidebar-dark { 
            background-color: #222222; 
            color: white; 
            border-bottom: 4px solid #F2AF17;
            padding: 1.5rem;
        }

        .logo-sidebar {
            max-width: 120px;
            margin-bottom: 10px;
        }

        .cart-item { 
            border: 1px solid #e9ecef; 
            border-radius: 16px; 
            background-color: #ffffff; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.02); 
            transition: all 0.2s ease;
        }
        .cart-item:hover { border-color: #F2AF17; }
        
        .qty-btn { background-color: #212529; color: white; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border: none; font-size: 0.8rem; transition: all 0.2s; }
        .qty-btn:hover { background-color: #F2AF17; color: black; }
        .qty-btn:active { transform: scale(0.9); }

        .summary-container {
            background: #ffffff;
            z-index: 5;
            padding: 1.5rem;
            border-top: 1px solid #f1f3f5;
        }

        .detail-pesanan { 
            background-color: #fffcf5; 
            border: 2px dashed #f2ce7c;
            border-radius: 16px; 
            padding: 1rem;
            transition: all 0.3s ease; 
        }
        .detail-pesanan:hover { border-color: #F2AF17; }
        
        .btn-checkout { 
            background-color: #F2AF17; 
            color: black; 
            border-radius: 50px; 
            font-weight: 800; 
            padding: 14px; 
            border: none; 
            box-shadow: 0 6px 15px rgba(242, 175, 23, 0.25); 
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        .btn-checkout:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(242, 175, 23, 0.4); background-color: #e5a30e; }
        .btn-checkout:active:not(:disabled) { transform: scale(0.98); }

        @keyframes pulse-soft {
            0% { box-shadow: 0 0 0 0 rgba(242, 175, 23, 0.5); }
            70% { box-shadow: 0 0 0 15px rgba(242, 175, 23, 0); }
            100% { box-shadow: 0 0 0 0 rgba(242, 175, 23, 0); }
        }
        .btn-checkout.ready { animation: pulse-soft 2.5s infinite; }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }
        .empty-cart-icon { animation: float 3s ease-in-out infinite; color: #dee2e6; }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #ced4da; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #adb5bd; }
        
        [x-cloak] { display: none !important; }

        .logo-header {
            height: 50px;
            width: auto;
        }

        .popup-overlay {
            background: rgba(44, 44, 44, 0.6);
            backdrop-filter: blur(4px);
        }

        .popup-container {
            background: #ffffff;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            overflow: hidden;
            position: relative;
        }

        .popup-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: #F2AF17;
            z-index: 1;
        }

        .popup-header {
            background: #ffffff;
            padding: 1.5rem;
            position: relative;
            border-bottom: 2px solid #F2AF17;
            text-align: center;
        }

        .popup-header h4 {
            color: #2c2c2c;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .popup-header h4 i {
            color: #F2AF17;
            margin-right: 8px;
        }

        .payment-option-card {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 20px;
            padding: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .payment-option-card:hover {
            border-color: #F2AF17;
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            background: #ffffff;
        }

        .payment-option-card.selected {
            border-color: #F2AF17;
            background: linear-gradient(135deg, #fffbf0 0%, #ffffff 100%);
            box-shadow: 0 0 0 3px rgba(242,175,23,0.15);
        }

        .payment-option-card i {
            transition: all 0.3s ease;
        }

        .payment-option-card:hover i {
            transform: scale(1.1);
        }

        .input-modern {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 16px;
            padding: 12px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input-modern:focus {
            border-color: #F2AF17;
            background: white;
            box-shadow: 0 0 0 4px rgba(242,175,23,0.1);
            outline: none;
        }

        .btn-popup-primary {
            background: linear-gradient(135deg, #F2AF17 0%, #e09e15 100%);
            color: #2c2c2c;
            font-weight: 800;
            padding: 14px;
            border-radius: 16px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-popup-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(242,175,23,0.3);
        }

        .btn-popup-secondary {
            background: #f8f9fa;
            color: #2c2c2c;
            font-weight: 600;
            padding: 12px;
            border-radius: 16px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .btn-popup-secondary:hover {
            background: #e9ecef;
            border-color: #2c2c2c;
            transform: translateY(-1px);
        }

        .qris-card {
            background: #f8f9fa;
            border-radius: 24px;
            padding: 2rem;
            text-align: center;
            border: 2px solid #e9ecef;
        }

        .qris-image {
            background: white;
            padding: 1rem;
            border-radius: 20px;
            display: inline-block;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .validation-error {
            background: #fee2e2;
            border-left: 4px solid #dc2626;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.875rem;
            color: #991b1b;
            margin-top: 8px;
        }

        .info-card {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .info-card .label {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .info-card .value {
            color: #2c2c2c;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .info-card .value.text-warning {
            color: #F2AF17 !important;
        }

        .menu-section {
            margin-bottom: 40px;
        }
        .section-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #F2AF17;
            display: inline-block;
            color: #2c2c2c;
        }
        .section-title i {
            color: #F2AF17;
            margin-right: 10px;
        }
        .empty-best-seller {
            text-align: center;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 20px;
            color: #6c757d;
        }
    </style>
</head>

<body x-data='kioskApp(@json($produks ?? []), @json($bestSellerProducts ?? []))' x-init="init()">

    <div class="kiosk-container w-100 d-flex flex-column px-4 py-3">
        
        <header class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-shrink-0">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-header" style="height: 50px;">
            </div>
            <div class="text-end">
                <h4 class="mb-1 text-secondary fw-bold">Halo, selamat datang !</h4>
                <p class="mb-0 text-muted small fw-semibold">Siap mencicipi kelezatan Chiiizkut hari ini?</p>
            </div>
        </header>

        <div class="row flex-grow-1 overflow-hidden" style="min-height: 0;">
            
            <div class="col-lg-8 h-100 overflow-auto custom-scrollbar pe-4 pb-4">
                
                <!-- BEST SELLER SECTION -->
                <div class="menu-section">
                    <h3 class="section-title">
                        <i class="fas fa-crown"></i> Best Seller
                    </h3>
                    
                    <div x-show="bestSellerList.length > 0" class="row g-4">
                        <template x-for="product in bestSellerList" :key="product.id">
                            <div class="col-md-6 col-lg-4">
                                <div class="card product-card h-100">
                                    
                                    <div class="best-seller-badge">
                                        <i class="fas fa-crown me-1"></i> BEST SELLER
                                    </div>

                                    <div x-show="product.stok <= 0" class="position-absolute w-100 h-100 bg-white bg-opacity-75" style="z-index: 10; border-radius: 20px; backdrop-filter: grayscale(100%);">
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                            <span class="badge bg-dark px-4 py-2 text-uppercase fs-6 shadow-sm">Habis</span>
                                        </div>
                                    </div>

                                    <div class="img-wrapper">
                                        <img :src="'/storage/' + product.image" class="product-img" alt="Product">
                                    </div>
                                    
                                    <div class="card-body d-flex flex-column p-3">
                                        <h6 class="card-title fw-bold mb-1 text-truncate" style="font-size: 0.95rem;" x-text="product.name"></h6>
                                        <p class="card-text fw-semibold mb-3 text-muted" style="font-size: 0.85rem;" x-text="'Rp ' + product.price.toLocaleString('id-ID')"></p>
                                        
                                        <div class="mt-auto">
                                            <button @click="addToCart(product)" class="btn-tambah w-100 d-flex align-items-center justify-content-center" :disabled="product.stok <= 0">
                                                <span class="icon-tambah"><i class="fas fa-plus"></i></span> Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <div x-show="bestSellerList.length === 0" class="empty-best-seller">
                        <i class="fas fa-chart-line fs-1 mb-3 opacity-50"></i>
                        <p class="mb-0">Belum ada produk Best Seller</p>
                        <small class="text-muted">Produk akan muncul setelah ada transaksi yang berhasil</small>
                    </div>
                </div>

                <!-- ALL MENU SECTION -->
                <div class="menu-section">
                    <h3 class="section-title">
                        <i class="fas fa-utensils"></i> All Menu
                    </h3>
                    <div class="row g-4">
                        <template x-for="product in allProducts" :key="product.id">
                            <div class="col-md-6 col-lg-4">
                                <div class="card product-card h-100">
                                    
                                    <div x-show="product.isBestSeller" class="best-seller-badge">
                                        <i class="fas fa-crown me-1"></i> BEST SELLER
                                    </div>

                                    <div x-show="product.stok <= 0" class="position-absolute w-100 h-100 bg-white bg-opacity-75" style="z-index: 10; border-radius: 20px; backdrop-filter: grayscale(100%);">
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                            <span class="badge bg-dark px-4 py-2 text-uppercase fs-6 shadow-sm">Habis</span>
                                        </div>
                                    </div>

                                    <div class="img-wrapper">
                                        <img :src="'/storage/' + product.image" class="product-img" alt="Product">
                                    </div>
                                    
                                    <div class="card-body d-flex flex-column p-3">
                                        <h6 class="card-title fw-bold mb-1 text-truncate" style="font-size: 0.95rem;" x-text="product.name"></h6>
                                        <p class="card-text fw-semibold mb-3 text-muted" style="font-size: 0.85rem;" x-text="'Rp ' + product.price.toLocaleString('id-ID')"></p>
                                        
                                        <div class="mt-auto">
                                            <button @click="addToCart(product)" class="btn-tambah w-100 d-flex align-items-center justify-content-center" :disabled="product.stok <= 0">
                                                <span class="icon-tambah"><i class="fas fa-plus"></i></span> Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

            <div class="col-lg-4 h-100 d-flex flex-column pb-3">
                <div class="sidebar-wrapper flex-grow-1 d-flex flex-column h-100">
                    
                    <div class="sidebar-dark text-center flex-shrink-0">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-sidebar">
                        <h6 class="fw-bold text-white mb-1">Lanjut ke pembayaran</h6>
                        <p class="small text-light opacity-75 mb-0">Konfirmasi pesanan & pilih metode favoritmu</p>
                    </div>

                    <div class="flex-grow-1 bg-white p-3 overflow-auto custom-scrollbar" style="height: 0; min-height: 0;">
                        
                        <template x-if="cart.length === 0">
                            <div class="text-center text-muted h-100 d-flex flex-column justify-content-center align-items-center">
                                <i class="fas fa-shopping-basket empty-cart-icon" style="font-size: 3.5rem; opacity: 0.3;"></i>
                                <h6 class="fw-bold mt-4 text-dark">Keranjang Masih Kosong</h6>
                                <p class="small text-muted mb-0">Yuk, pilih menu dulu!</p>
                            </div>
                        </template>

                        <template x-for="(item, index) in cart" :key="item.id">
                            <div class="cart-item p-2 mb-3 d-flex align-items-center"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-x-10"
                                 x-transition:enter-end="opacity-100 translate-x-0"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 translate-x-0"
                                 x-transition:leave-end="opacity-0 translate-x-10 scale-95">
                                 
                                <img :src="'/storage/' + item.image" class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                <div class="ms-3 flex-grow-1">
                                    <h6 class="mb-1 fw-bold text-dark" style="font-size: 0.85rem;" x-text="item.name"></h6>
                                    <p class="mb-0 text-muted fw-semibold" style="font-size: 0.8rem;" x-text="'Rp ' + item.price.toLocaleString('id-ID')"></p>
                                </div>
                                <div class="d-flex align-items-center me-1">
                                    <button @click="removeFromCart(index)" class="qty-btn shadow-sm"><i class="fas fa-minus"></i></button>
                                    <span class="mx-2 fw-bold text-dark" style="font-size: 1rem; width: 20px; text-align: center;" x-text="item.qty"></span>
                                    <button @click="addToCart(item)" class="qty-btn shadow-sm"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="summary-container flex-shrink-0">
                        <div class="detail-pesanan mb-3">
                            <div class="d-flex align-items-center mb-2 pb-2 border-bottom border-warning border-opacity-50">
                                <i class="fas fa-receipt text-muted me-2"></i>
                                <span class="fw-bold text-muted small">Detail Pesanan</span>
                            </div>
                            
                            <div class="overflow-auto mb-1 custom-scrollbar" style="max-height: 70px;">
                                <template x-for="item in cart">
                                    <div class="d-flex justify-content-between small mb-1 fw-semibold text-secondary">
                                        <span class="text-truncate pe-2"><span x-text="item.name"></span> <span class="text-warning fw-bolder ms-1" x-text="'x' + item.qty"></span></span>
                                        <span x-text="'Rp ' + (item.price * item.qty).toLocaleString('id-ID')"></span>
                                    </div>
                                </template>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-warning border-opacity-50">
                                <span class="fw-bold text-dark small"><i class="fas fa-tag me-1 text-muted"></i> Total Tagihan</span>
                                <span class="fw-black text-chiiiz fs-5 fw-bolder" x-text="'Rp ' + cartTotal.toLocaleString('id-ID')"></span>
                            </div>
                        </div>

                        <button @click="openModal = true; step = 'payment'" 
                                class="btn btn-checkout w-100 d-flex justify-content-center align-items-center"
                                :class="cart.length > 0 ? 'ready' : ''"
                                :disabled="cart.length === 0">
                            <i class="fas fa-check-circle fs-5 me-2"></i> Konfirmasi & Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- POPUP -->
    <div x-show="openModal" class="position-fixed top-0 start-0 w-100 h-100 popup-overlay" style="z-index: 1050;" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak>
         
        <div class="w-100 h-100 d-flex align-items-center justify-content-center p-4">
            
            <div @click.away="if(step !== 'success') openModal = false" class="popup-container" style="width: 100%; max-width: 500px;"
                 x-show="openModal"
                 x-transition:enter="transition ease-out duration-300 delay-100"
                 x-transition:enter-start="opacity-0 scale-90 translate-y-5"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-90 translate-y-5">
                
                <div x-show="step === 'payment'">
                    <div class="popup-header">
                        <h4 class="text-center">
                            <i class="fas fa-wallet"></i> Pilih Metode Pembayaran
                        </h4>
                    </div>
                    <div class="p-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <div @click="selectPayment('cash')" 
                                     class="payment-option-card text-center"
                                     :class="{'selected': paymentMethod === 'cash'}">
                                    <i class="fas fa-money-bill-wave fs-1 mb-2" style="color: #28a745;"></i>
                                    <h6 class="fw-bold mb-1 text-dark">CASH</h6>
                                    <p class="text-muted small mb-0">Bayar Tunai</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div @click="selectPayment('qris')" 
                                     class="payment-option-card text-center"
                                     :class="{'selected': paymentMethod === 'qris'}">
                                    <i class="fas fa-qrcode fs-1 mb-2" style="color: #F2AF17;"></i>
                                    <h6 class="fw-bold mb-1 text-dark">QRIS</h6>
                                    <p class="text-muted small mb-0">Scan QR Code</p>
                                </div>
                            </div>
                        </div>
                        <button @click="openModal = false" class="btn-popup-secondary w-100 mt-4">
                            <i class="fas fa-arrow-left me-2"></i> Batal
                        </button>
                    </div>
                </div>

                <div x-show="step === 'qris_display'" x-cloak>
                    <div class="popup-header">
                        <h4 class="text-center">
                            <i class="fas fa-qrcode"></i> Scan QRIS
                        </h4>
                    </div>
                    <div class="p-4">
                        <div class="info-card">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="label">Total Pesanan:</span>
                                <span class="value text-warning" x-text="'Rp ' + cartTotal.toLocaleString('id-ID')"></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="label">Metode Pembayaran:</span>
                                <span class="value">QRIS (Digital)</span>
                            </div>
                        </div>
                        
                        <div class="qris-card">
                            <div class="qris-image">
                                <img src="{{ asset('images/monyet.jpg') }}" alt="QRIS" style="width: 200px; height: 200px; object-fit: cover;">
                            </div>
                            <p class="text-muted small mt-3 mb-0">
                                <i class="fas fa-info-circle me-1"></i> Scan menggunakan E-Wallet atau M-Banking
                            </p>
                        </div>
                        <button @click="step = 'customer'" class="btn-popup-primary w-100 mt-4">
                            <i class="fas fa-check-circle me-2"></i> Saya Sudah Bayar
                        </button>
                        <button @click="step = 'payment'" class="btn-popup-secondary w-100 mt-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </button>
                    </div>
                </div>

                <div x-show="step === 'customer' && paymentMethod === 'cash'" x-cloak>
                    <div class="popup-header">
                        <h4 class="text-center">
                            <i class="fas fa-user-circle"></i> Data Pemesan
                        </h4>
                    </div>
                    <div class="p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark mb-2">
                                <i class="fas fa-user me-1 text-chiiiz"></i> Nama Lengkap
                            </label>
                            <input type="text" x-model="customerName" 
                                   class="input-modern w-100" 
                                   placeholder="Masukkan nama lengkap Anda"
                                   @input="validationErrors.name = ''">
                            <div x-show="validationErrors.name" x-text="validationErrors.name" class="validation-error"></div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark mb-2">
                                <i class="fab fa-whatsapp me-1 text-chiiiz"></i> Nomor WhatsApp
                            </label>
                            <input type="tel" x-model="customerPhone" 
                                   class="input-modern w-100" 
                                   placeholder="Contoh: 081234567890"
                                   @input="validationErrors.phone = ''">
                            <div x-show="validationErrors.phone" x-text="validationErrors.phone" class="validation-error"></div>
                        </div>

                        <button @click="finishOrder()" class="btn-popup-primary w-100 mb-2">
                            <i class="fas fa-paper-plane me-2"></i> Konfirmasi Pesanan
                        </button>
                        <button @click="step = 'payment'" class="btn-popup-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Pembayaran
                        </button>
                    </div>
                </div>

                <div x-show="step === 'customer' && paymentMethod === 'qris'" x-cloak>
                    <div class="popup-header">
                        <h4 class="text-center">
                            <i class="fas fa-user-circle"></i> Konfirmasi Pesanan
                        </h4>
                    </div>
                    <div class="p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark mb-2">
                                <i class="fas fa-user me-1 text-chiiiz"></i> Nama Lengkap
                            </label>
                            <input type="text" x-model="customerName" 
                                   class="input-modern w-100" 
                                   placeholder="Masukkan nama lengkap Anda"
                                   @input="validationErrors.name = ''">
                            <div x-show="validationErrors.name" x-text="validationErrors.name" class="validation-error"></div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark mb-2">
                                <i class="fab fa-whatsapp me-1 text-chiiiz"></i> Nomor WhatsApp
                            </label>
                            <input type="tel" x-model="customerPhone" 
                                   class="input-modern w-100" 
                                   placeholder="Contoh: 081234567890"
                                   @input="validationErrors.phone = ''">
                            <div x-show="validationErrors.phone" x-text="validationErrors.phone" class="validation-error"></div>
                        </div>

                        <button @click="finishOrder()" class="btn-popup-primary w-100 mb-2">
                            <i class="fas fa-check-circle me-2"></i> Selesaikan Pesanan
                        </button>
                        <button @click="step = 'qris_display'" class="btn-popup-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke QRIS
                        </button>
                    </div>
                </div>

                <div x-show="step === 'success'" x-cloak>
                    <div class="popup-header" style="background: #F2AF17;">
                        <h4 class="text-center text-dark">
                            <i class="fas fa-check-circle me-2"></i> Pesanan Berhasil!
                        </h4>
                    </div>
                    <div class="p-4 text-center">
                        <div class="mb-4">
                            <i class="fas fa-check-circle" style="font-size: 5rem; color: #F2AF17;"></i>
                        </div>
                        <h5 class="fw-bold mb-3 text-dark">Terima Kasih Telah Memesan!</h5>
                        <div class="info-card mb-4" style="background: #2c2c2c;">
                            <p class="text-white-50 small mb-2 text-uppercase">Nomor Antrean Anda</p>
                            <h1 class="display-1 fw-bolder mb-0" style="color: #F2AF17; font-family: 'Courier New', monospace;" x-text="queueNumber"></h1>
                        </div>
                        <p class="text-muted small mb-4">
                            <i class="fas fa-clock me-1"></i> Silakan tunggu nomor Anda dipanggil oleh kasir
                        </p>
                        <button @click="reset()" class="btn-popup-primary w-100">
                            <i class="fas fa-shopping-cart me-2"></i> Pesan Lagi
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function kioskApp(dbProducts, dbBestSellerProducts) {
            return {
                step: 'cart', 
                openModal: false,
                paymentMethod: '',
                customerName: '',
                customerPhone: '',
                queueNumber: '000',
                cart: [],
                validationErrors: {
                    name: '',
                    phone: ''
                },
                
                allProducts: [],
                bestSellerList: [],
                
                init() {
                    // Semua produk (All Menu)
                    this.allProducts = (Array.isArray(dbProducts) ? dbProducts : []).map(p => {
                        return {
                            id: p.id, 
                            name: p.nama_produk || 'Produk Tanpa Nama', 
                            price: parseFloat(p.harga || 0), 
                            image: p.gambar,
                            stok: parseInt(p.stok || 0),
                            isBestSeller: false
                        };
                    });
                    
                    // Best Seller Products (dari backend, SAMA LOGIKA DENGAN ADMIN)
                    this.bestSellerList = (Array.isArray(dbBestSellerProducts) ? dbBestSellerProducts : []).map(p => {
                        return {
                            id: p.id,
                            name: p.nama_produk,
                            price: parseFloat(p.harga || 0),
                            image: p.gambar,
                            stok: parseInt(p.stok || 0),
                            total_terjual: p.total_terjual || 0
                        };
                    });
                    
                    // Update isBestSeller di allProducts
                    const bestSellerIds = this.bestSellerList.map(p => p.id);
                    this.allProducts = this.allProducts.map(p => {
                        p.isBestSeller = bestSellerIds.includes(p.id);
                        return p;
                    });
                    
                    // Debug console
                    console.log('========== BEST SELLER ==========');
                    console.log('Data dari order_items (transaksi sukses)');
                    console.log('Jumlah Best Seller: ' + this.bestSellerList.length);
                    if (this.bestSellerList.length > 0) {
                        this.bestSellerList.forEach(p => {
                            console.log('✅ ' + p.name + ' | Terjual: ' + p.total_terjual + ' pcs');
                        });
                    } else {
                        console.log('Belum ada produk Best Seller');
                    }
                    console.log('=================================');
                },
                
                get cartTotal() { 
                    return this.cart.reduce((sum, i) => sum + (i.price * i.qty), 0); 
                },

                addToCart(p) {
                    let productInState = this.allProducts.find(prod => prod.id === p.id);
                    let existingInCart = this.cart.find(item => item.id === p.id);
                    
                    if (existingInCart) {
                        if(existingInCart.qty < productInState.stok) existingInCart.qty++;
                        else alert('Stok tidak mencukupi untuk menambah item!');
                    } else {
                        if(productInState.stok > 0) this.cart.push({ ...productInState, qty: 1 });
                        else alert('Maaf, produk ini sedang habis!');
                    }
                },

                removeFromCart(index) {
                    if (this.cart[index].qty > 1) this.cart[index].qty--;
                    else this.cart.splice(index, 1);
                },

                selectPayment(method) {
                    this.paymentMethod = method;
                    if (method === 'qris') {
                        this.step = 'qris_display';
                    } else {
                        this.step = 'customer';
                    }
                },

                validateCustomerData() {
                    let isValid = true;
                    
                    if (!this.customerName.trim()) {
                        this.validationErrors.name = '⚠️ Nama lengkap harus diisi';
                        isValid = false;
                    } else if (this.customerName.trim().length < 2) {
                        this.validationErrors.name = '⚠️ Nama terlalu pendek (minimal 2 karakter)';
                        isValid = false;
                    } else {
                        this.validationErrors.name = '';
                    }
                    
                    if (!this.customerPhone.trim()) {
                        this.validationErrors.phone = '⚠️ Nomor WhatsApp harus diisi';
                        isValid = false;
                    } else if (!/^[0-9]{10,13}$/.test(this.customerPhone.trim())) {
                        this.validationErrors.phone = '⚠️ Nomor tidak valid (10-13 digit angka)';
                        isValid = false;
                    } else {
                        this.validationErrors.phone = '';
                    }
                    
                    return isValid;
                },

                async finishOrder() {
                    if(!this.validateCustomerData()) return;
                    
                    try {
                        const response = await fetch("{{ route('checkout') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({
                                total: this.cartTotal, 
                                items: this.cart.map(item => ({
                                    id: item.id,
                                    name: item.name,
                                    price: item.price,
                                    qty: item.qty
                                })),
                                name: this.customerName, 
                                phone: this.customerPhone, 
                                payment_method: this.paymentMethod
                            })
                        });
                        
                        const result = await response.json();
                        if(result.success) {
                            this.queueNumber = result.queue_number.toString().padStart(3, '0');
                            this.cart = []; 
                            this.step = 'success';
                            
                            // Reload halaman setelah 2 detik agar best seller terupdate
                            setTimeout(() => {
                                location.reload();
                            }, 1080000);
                            
                        } else {
                            alert(result.message || 'Terjadi kesalahan, silakan coba lagi');
                        }
                    } catch (error) { 
                        console.error('Error:', error);
                        alert('Error Sistem: Cek Koneksi Server/Database');
                    }
                },

                reset() { location.reload(); }
            }
        }
    </script>
</body>
</html>