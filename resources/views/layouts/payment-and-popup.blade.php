<!-- SIDEBAR CART - Responsive -->
<div class="sidebar-wrapper flex-grow-1 d-flex flex-column h-100 w-100">

    <!-- Header Sidebar -->
    <div class="sidebar-dark text-center flex-shrink-0">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-sidebar img-fluid" style="max-width: 100px;">
        <p class="small text-white mb-0 mt-2 d-none d-sm-block">Lanjut ke Pembayaran</p>
        <p class="small text-light opacity-75 mb-0 d-none d-sm-block">Konfirmasi Pesanan dan Pilih Metode Pembayaranmu</p>
    </div>

    <!-- Area Scroll untuk List Pesanan -->
    <div class="flex-grow-1 bg-white p-2 p-sm-3 overflow-auto custom-scrollbar" style="height: 0; min-height: 0;">

        <!-- DETAIL PESANAN -->
        <div class="detail-pesanan-section">
            <div class="d-flex align-items-center mb-3 pb-2 border-bottom border-warning border-opacity-50">
                <i class="fas fa-receipt text-chiiiz me-2 fs-5"></i>
                <span class="fw-bold text-dark">Detail Pesanan</span>
            </div>

            <template x-if="cart.length === 0">
                <div class="text-center text-muted py-4 py-sm-5">
                    <i class="fas fa-shopping-basket" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="mt-3 mb-0 fw-semibold">Keranjang Masih Kosong</p>
                    <p class="small text-muted d-none d-sm-block mt-1">Yuk, pilih menu dulu!</p>
                </div>
            </template>

            <template x-if="cart.length > 0">
                <div>
                    <div class="order-items-list">
                        <template x-for="item in cart" :key="item.cartKey">
                            <div class="cart-item-card d-flex align-items-center justify-content-between mb-3 p-2 rounded-3 border bg-white">
                                <!-- Info Produk -->
                                <div class="d-flex align-items-center flex-grow-1 me-2" style="min-width: 0;">
                                    <img :src="'/storage/' + item.image" class="rounded-3 me-2" 
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="flex-grow-1" style="min-width: 0;">
                                        <h6 class="fw-bold text-dark mb-0 text-truncate" x-text="item.name"></h6>
                                        <p x-show="item.varianLabel" class="mb-0 text-chiiiz small fw-semibold" x-text="item.varianLabel"></p>
                                        <p class="mb-0 text-muted fw-semibold small" x-text="'Rp ' + item.price.toLocaleString('id-ID')"></p>
                                        <!-- Stok indicator -->
                                        <p class="stok-indicator mb-0 small" x-show="item.stokTersedia !== undefined && item.stokTersedia <= 3" 
                                           x-text="'⚠️ Stok tersisa: ' + item.stokTersedia"></p>
                                    </div>
                                </div>

                                <!-- Tombol Plus/Minus dan Qty -->
                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                    <button @click="decreaseQty(item)" class="qty-btn rounded-circle d-flex align-items-center justify-content-center p-0" 
                                        style="width: 32px; height: 32px; background: #f0f0f0; border: none; color: #F2AF17;">
                                        <i class="fas fa-minus fa-xs"></i>
                                    </button>
                                    <span class="fw-bold text-dark" style="min-width: 30px; text-align: center;" x-text="item.qty"></span>
                                    <button @click="increaseQty(item)" 
                                        :disabled="item.qty >= item.stokTersedia"
                                        class="qty-btn rounded-circle d-flex align-items-center justify-content-center p-0" 
                                        style="width: 32px; height: 32px; background: #F2AF17; border: none; color: white;">
                                        <i class="fas fa-plus fa-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- TOTAL & TOMBOL -->
    <div class="summary-container flex-shrink-0 p-3 border-top border-warning border-opacity-25" style="background: white;">
        <template x-if="cart.length > 0">
            <div class="total-section mb-3">
                <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="background: #f8f9fa;">
                    <span class="fw-bold text-dark">
                        <i class="fas fa-tag me-2 text-chiiiz"></i> Total Tagihan
                    </span>
                    <span class="fw-black text-chiiiz fs-3 fw-bolder" x-text="'Rp ' + cartTotal.toLocaleString('id-ID')"></span>
                </div>
            </div>
        </template>

        <button @click="openPaymentModal()" class="btn btn-checkout w-100 d-flex justify-content-center align-items-center gap-2 py-3" 
            :class="cart.length > 0 ? 'ready' : ''" :disabled="cart.length === 0">
            <i class="fas fa-arrow-right"></i>
            <span>Lanjut ke Pembayaran</span>
        </button>
    </div>
</div>

<!-- ====================================== -->
<!-- NOTIFIKASI STOK (TOAST NOTIFICATION)    -->
<!-- ====================================== -->
<div x-show="showStokWarning" x-cloak class="stok-warning" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-5"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-5">
    <i class="fas fa-exclamation-triangle"></i>
    <span x-text="stokWarningMessage"></span>
</div>

<!-- ====================================== -->
<!-- POPUP DETAIL PRODUK DENGAN VALIDASI STOK -->
<!-- ====================================== -->
<div x-show="showDetail" x-cloak class="position-fixed top-0 start-0 w-100 h-100 popup-overlay" style="z-index: 1060; background: rgba(0,0,0,0.7);" 
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <div class="w-100 h-100 d-flex align-items-center justify-content-center p-2 p-sm-4">
        <div @click.away="showDetail = false" class="popup-container bg-white rounded-4" style="width: 100%; max-width: 450px;" x-show="showDetail"
            x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 scale-90 translate-y-5"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-5">

            <div class="position-relative">
                <img :src="selectedProduct ? '/storage/' + selectedProduct.image : ''" class="product-detail-img w-100 rounded-top-4" 
                    style="height: 250px; object-fit: cover;" alt="Product">
                <button @click="showDetail = false" class="btn btn-dark position-absolute top-0 end-0 m-2 m-sm-3 rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 36px; height: 36px; opacity: 0.8; padding: 0;">
                    <i class="fas fa-times"></i>
                </button>
                <!-- Badge stok -->
                <div x-show="selectedProduct && selectedProduct.stok <= 5 && selectedProduct.stok > 0" 
                     class="position-absolute bottom-0 start-0 m-2 bg-warning text-dark px-2 py-1 rounded-pill small fw-bold">
                    <i class="fas fa-box me-1"></i> Stok: <span x-text="selectedProduct.stok"></span>
                </div>
                <div x-show="selectedProduct && selectedProduct.stok === 0" 
                     class="position-absolute bottom-0 start-0 m-2 bg-danger text-white px-2 py-1 rounded-pill small fw-bold">
                    <i class="fas fa-times-circle me-1"></i> Stok Habis
                </div>
            </div>

            <div class="p-3 p-sm-4">
                <h4 class="fw-800 mb-1" style="font-weight: 800; color: #2c2c2c;" x-text="selectedProduct?.name"></h4>
                <p class="text-muted mb-3 mb-sm-4" x-text="selectedProduct?.deskripsi"></p>

                <template x-if="selectedProduct?.varians && selectedProduct.varians.length > 0">
                    <div>
                        <label class="fw-bold mb-2 d-block">
                            <i class="fas fa-tag me-1 text-chiiiz"></i> Pilih Ukuran:
                        </label>
                        <div class="d-flex gap-2 gap-sm-3 mb-3 mb-sm-4 flex-wrap">
                            <template x-for="varian in selectedProduct.varians" :key="varian.id">
                                <div class="size-card px-3 py-2 rounded-3 border text-center cursor-pointer position-relative"
                                    :class="selectedVarian?.id === varian.id ? 'active border-warning bg-warning bg-opacity-10' : 'border-secondary'"
                                    @click="selectedVarian = varian" style="min-width: 70px;">
                                    <div class="text-uppercase small fw-bold text-muted mb-1" x-text="varian.ukuran"></div>
                                    <div class="fw-bold text-chiiiz" x-text="'Rp ' + parseInt(varian.harga).toLocaleString('id-ID')"></div>
                                    <div x-show="varian.stok <= 3 && varian.stok > 0" 
                                         class="small text-warning mt-1" x-text="'Stok: ' + varian.stok"></div>
                                    <div x-show="varian.stok === 0" 
                                         class="small text-danger mt-1 fw-bold">Habis</div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <div class="pt-2 pt-sm-3 border-top">
                    <button @click="addToCartFromDetail()" 
                        :disabled="(selectedProduct?.varians && selectedProduct.varians.length > 0 && !selectedVarian) || (selectedProduct?.stok === 0) || (selectedVarian?.stok === 0)"
                        class="btn-popup-primary w-100 py-2 py-sm-3 d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-shopping-bag"></i>
                        <span x-show="!((selectedProduct?.varians && selectedProduct.varians.length > 0 && !selectedVarian) || (selectedProduct?.stok === 0) || (selectedVarian?.stok === 0))">Tambah ke Pesanan</span>
                        <span x-show="(selectedProduct?.varians && selectedProduct.varians.length > 0 && !selectedVarian)">Pilih Ukuran Dulu</span>
                        <span x-show="(selectedProduct?.stok === 0) || (selectedVarian?.stok === 0)">Stok Habis</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ====================================== -->
<!-- POPUP TRANSAKSI PEMBAYARAN -->
<!-- ====================================== -->
<div x-show="showPaymentModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100 popup-overlay" style="z-index: 1050; background: rgba(0,0,0,0.7);" 
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <div class="w-100 h-100 d-flex align-items-center justify-content-center p-2 p-sm-4">
        <div @click.away="if(step !== 'success' && step !== 'qris_display') closePaymentModal()" class="popup-container bg-white rounded-4" 
            style="width: 100%; max-width: 550px;" x-show="showPaymentModal"
            x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 scale-90 translate-y-5"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-5">

            <!-- Step: Pilih Metode Pembayaran -->
            <div x-show="step === 'payment_method'">
                <div class="popup-header p-3 p-sm-4 border-bottom">
                    <h4 class="text-center mb-1">
                        <i class="fas fa-credit-card me-2"></i> Transaksi Pembayaran
                    </h4>
                    <p class="text-center text-muted small mb-0">Konfirmasi pesanan & pilih metode favoritmu</p>
                </div>

                <div class="p-3 p-sm-4">
                    <!-- Detail Pesanan di Popup -->
                    <div class="detail-pesanan-popup mb-3 mb-sm-4 p-2 p-sm-3 rounded-3" style="background: #f8f9fa;">
                        <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                            <i class="fas fa-receipt text-chiiiz me-2"></i>
                            <span class="fw-bold text-dark">Detail Pesanan</span>
                        </div>

                        <div class="order-items-list mb-2" style="max-height: 150px; overflow-y: auto;">
                            <template x-for="item in cart" :key="item.cartKey">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="fw-semibold text-dark" x-text="item.name"></span>
                                        <span x-show="item.varianLabel" class="text-chiiiz small" x-text="'(' + item.varianLabel + ')'"></span>
                                        <span class="text-muted small" x-text="'x' + item.qty"></span>
                                    </div>
                                    <div>
                                        <span class="fw-semibold text-dark" x-text="'Rp ' + (item.price * item.qty).toLocaleString('id-ID')"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-2 mt-2 border-top">
                            <span class="fw-bold text-dark">Total:</span>
                            <span class="fw-black text-chiiiz fs-4 fw-bolder" x-text="'Rp ' + cartTotal.toLocaleString('id-ID')"></span>
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="metode-pembayaran-popup">
                        <div class="d-flex align-items-center mb-2 mb-sm-3">
                            <i class="fas fa-wallet text-chiiiz me-2"></i>
                            <span class="fw-bold text-dark">Metode Pembayaran</span>
                        </div>

                        <div class="row g-2 g-sm-3">
                            <div class="col-6">
                                <div @click="paymentMethod = 'cash'" class="payment-option-card text-center p-3 p-sm-4 rounded-3 border cursor-pointer h-100"
                                    :class="{ 'selected': paymentMethod === 'cash' }">
                                    <i class="fas fa-money-bill-wave fs-1 mb-2" style="color: #F2AF17;"></i>
                                    <h6 class="fw-bold mb-0 text-dark">CASH</h6>
                                    <p class="text-muted small mb-0 d-none d-sm-block">Bayar Tunai di Kasir</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div @click="paymentMethod = 'qris'" class="payment-option-card text-center p-3 p-sm-4 rounded-3 border cursor-pointer h-100"
                                    :class="{ 'selected': paymentMethod === 'qris' }">
                                    <i class="fas fa-qrcode fs-1 mb-2" style="color: #F2AF17;"></i>
                                    <h6 class="fw-bold mb-0 text-dark">QRIS</h6>
                                    <p class="text-muted small mb-0 d-none d-sm-block">Scan QR Code</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button @click="processToNextStep()" class="btn-popup-primary w-100 mt-4 py-3" :disabled="!paymentMethod">
                        <i class="fas fa-check-circle me-2"></i> Konfirmasi & Bayar Sekarang
                    </button>
                    <button @click="closePaymentModal()" class="btn-popup-secondary w-100 mt-2 py-2">
                        <i class="fas fa-times me-2"></i> Batal
                    </button>
                </div>
            </div>

            <!-- Step: Form Data Customer -->
            <div x-show="step === 'customer_form'" x-cloak>
                <div class="popup-header p-3 p-sm-4 border-bottom">
                    <h4 class="text-center mb-1">
                        <i class="fas fa-user-circle me-2"></i> Data Pemesan
                    </h4>
                    <p class="text-center text-muted small mb-0">Isi data diri untuk konfirmasi pesanan</p>
                </div>
                <div class="p-3 p-sm-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="fas fa-user me-1 text-chiiiz"></i> Nama Lengkap
                        </label>
                        <input type="text" x-model="customerName" class="input-modern w-100 py-2 px-3 rounded-3 border" 
                            placeholder="Masukkan nama lengkap Anda" @input="validationErrors.name = ''">
                        <div x-show="validationErrors.name" x-text="validationErrors.name" class="validation-error text-danger small mt-1"></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="fab fa-whatsapp me-1 text-chiiiz"></i> Nomor WhatsApp
                        </label>
                        <input type="tel" x-model="customerPhone" class="input-modern w-100 py-2 px-3 rounded-3 border" 
                            placeholder="Contoh: 081234567890" @input="validationErrors.phone = ''">
                        <div x-show="validationErrors.phone" x-text="validationErrors.phone" class="validation-error text-danger small mt-1"></div>
                    </div>
                    <button @click="finishOrder()" class="btn-popup-primary w-100 mb-2 py-3">
                        <i class="fas fa-paper-plane me-2"></i> Selesaikan Pesanan
                    </button>
                    <button @click="step = 'payment_method'" class="btn-popup-secondary w-100 py-2">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </button>
                </div>
            </div>

            <!-- Step: Tampil QRIS -->
            <div x-show="step === 'qris_display'" x-cloak>
                <div class="popup-header p-3 p-sm-4 text-center" style="background: #F2AF17;">
                    <h4 class="text-center text-dark mb-0">
                        <i class="fas fa-qrcode me-2"></i> Scan QRIS
                    </h4>
                </div>
                <div class="p-3 p-sm-4 text-center">
                    <div class="info-card mb-4 p-3 rounded-3" style="background: #f8f9fa;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Pesanan:</span>
                            <span class="fw-bold text-dark fs-5" x-text="'Rp ' + cartTotal.toLocaleString('id-ID')"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Metode:</span>
                            <span class="fw-bold text-dark">QRIS</span>
                        </div>
                    </div>
                    <div class="qris-card mb-4">
                        <div class="qris-image d-flex justify-content-center">
                            <img src="{{ asset('images/monyet.jpg') }}" alt="QRIS" style="width: 180px; height: 180px; object-fit: cover; border-radius: 20px;" class="img-fluid">
                        </div>
                        <p class="text-muted small mt-3 mb-0">
                            <i class="fas fa-info-circle me-1"></i> Scan menggunakan E-Wallet atau M-Banking
                        </p>
                    </div>
                    <button @click="step = 'customer_form'" class="btn-popup-primary w-100 mb-2 py-3">
                        <i class="fas fa-check-circle me-2"></i> Saya Sudah Bayar
                    </button>
                    <button @click="step = 'payment_method'" class="btn-popup-secondary w-100 py-2">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </button>
                </div>
            </div>

            <!-- Step: Sukses -->
            <div x-show="step === 'success'" x-cloak>
                <div class="popup-header p-3 p-sm-4 text-center" style="background: #F2AF17;">
                    <h4 class="text-center text-dark mb-0">
                        <i class="fas fa-check-circle me-2"></i> Pesanan Berhasil!
                    </h4>
                </div>
                <div class="p-3 p-sm-4 text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle" style="font-size: 4rem; color: #F2AF17;"></i>
                    </div>
                    <h5 class="fw-bold mb-3 text-dark">Terima Kasih Telah Memesan!</h5>
                    <div class="info-card mb-4 p-3 rounded-3" style="background: #2c2c2c;">
                        <p class="text-white-50 small mb-2 text-uppercase">Nomor Antrean Anda</p>
                        <h1 class="fw-bolder mb-0" style="color: #F2AF17; font-family: 'Courier New', monospace; font-size: 4rem;" x-text="queueNumber"></h1>
                    </div>
                    <p class="text-muted small mb-4">
                        <i class="fas fa-clock me-1"></i> Silakan tunggu nomor Anda dipanggil
                    </p>
                    <button @click="reset()" class="btn-popup-primary w-100 py-3">
                        <i class="fas fa-shopping-cart me-2"></i> Pesan Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .cursor-pointer:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .payment-option-card.selected {
        border: 2px solid #F2AF17 !important;
        background: linear-gradient(135deg, #fffbf0 0%, #ffffff 100%);
        box-shadow: 0 0 0 3px rgba(242,175,23,0.15);
    }
    .detail-pesanan-popup {
        background: #f8f9fa;
        border-radius: 12px;
    }
    .qty-btn {
        transition: all 0.2s ease;
    }
    .qty-btn:hover:not(:disabled) {
        transform: scale(1.05);
        opacity: 0.9;
    }
    .qty-btn:active:not(:disabled) {
        transform: scale(0.95);
    }
    .qty-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Stok indicator */
    .stok-indicator {
        font-size: 0.65rem;
        color: #dc2626;
        font-weight: 500;
    }

    /* ========== RESPONSIVE FIXES ========== */
    
    @media (max-width: 576px) {
        .sidebar-dark {
            padding: 12px !important;
        }
        .summary-container {
            padding: 12px !important;
        }
        .btn-checkout {
            padding: 10px !important;
            font-size: 14px;
        }
        .cart-item-card {
            padding: 8px !important;
        }
        .cart-item-card h6 {
            font-size: 14px;
        }
        .cart-item-card .small {
            font-size: 11px;
        }
        .qty-btn {
            width: 28px !important;
            height: 28px !important;
        }
        .qty-btn i {
            font-size: 10px;
        }
        .payment-option-card {
            padding: 12px !important;
        }
        .payment-option-card i {
            font-size: 1.5rem !important;
            margin-bottom: 8px !important;
        }
        .payment-option-card h6 {
            font-size: 14px !important;
        }
        .popup-container {
            max-width: 95% !important;
        }
        .popup-container .p-3 {
            padding: 12px !important;
        }
        .product-detail-img {
            height: 200px !important;
        }
        .popup-header {
            padding: 12px !important;
        }
        .popup-header h4 {
            font-size: 1.1rem !important;
        }
        .detail-pesanan-popup .d-flex {
            font-size: 12px;
        }
        .btn-popup-primary, .btn-popup-secondary {
            padding: 10px !important;
            font-size: 14px !important;
        }
        .size-card {
            padding: 8px 12px !important;
        }
        .size-card .small {
            font-size: 10px;
        }
    }
    
    @media (min-width: 577px) and (max-width: 768px) {
        .payment-option-card {
            padding: 16px !important;
        }
        .payment-option-card i {
            font-size: 1.75rem !important;
        }
        .payment-option-card h6 {
            font-size: 15px !important;
        }
        .popup-container {
            max-width: 90% !important;
        }
    }
    
    @media (min-width: 769px) and (max-width: 991px) {
        .col-lg-4 {
            width: 35% !important;
        }
        .col-lg-8 {
            width: 65% !important;
        }
    }
    
    @media (max-width: 767px) {
        .sidebar-wrapper {
            margin-top: 16px;
        }
    }
    
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #F2AF17;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #d4940a;
    }
    
    @media (max-width: 576px) {
        .cart-item-card {
            flex-wrap: wrap;
        }
        .cart-item-card > .d-flex:first-child {
            width: 100%;
            margin-bottom: 8px;
        }
        .cart-item-card .flex-shrink-0 {
            width: 100%;
            justify-content: flex-end;
        }
    }
    
    .btn-checkout:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    @keyframes pulse-soft {
        0% { box-shadow: 0 0 0 0 rgba(242, 175, 23, 0.5); }
        70% { box-shadow: 0 0 0 15px rgba(242, 175, 23, 0); }
        100% { box-shadow: 0 0 0 0 rgba(242, 175, 23, 0); }
    }
    .btn-checkout.ready {
        animation: pulse-soft 2.5s infinite;
    }
    
    .input-modern {
        font-size: 14px;
    }
    @media (max-width: 576px) {
        .input-modern {
            font-size: 13px;
            padding: 8px 12px !important;
        }
    }
    
    .validation-error {
        font-size: 12px;
    }
    @media (max-width: 576px) {
        .validation-error {
            font-size: 11px;
        }
    }
    
    .qris-image img {
        max-width: 100%;
        height: auto;
    }
    @media (max-width: 576px) {
        .qris-image img {
            width: 150px !important;
            height: 150px !important;
        }
    }
</style>