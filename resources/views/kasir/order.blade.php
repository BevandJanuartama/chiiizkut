@extends('layouts.app2')

@section('title', 'ChiiiZkut - Self Ordering Kiosk')

@section('body-attributes')
x-data='kioskApp(@json($produks ?? []), @json($bestSellerProducts ?? []))' x-init="init()"
@endsection

@section('content')
<div class="kiosk-container w-100 d-flex flex-column px-2 px-sm-3 px-md-4 py-2 py-sm-3">
    <!-- Navbar Custom -->
        <nav class="navbar-custom mb-3 mb-md-5">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <img src="/images/logo.png" alt="Logo ChiiiZkut" style="max-height: 50px; object-fit: contain;"
                        onerror="this.onerror=null; this.style.display='none'">
                </div>

                <div class="d-flex align-items-center gap-2 gap-sm-3 flex-wrap justify-content-center">
                    <!-- Tombol Monitoring Antrean -->
                    <a href="{{ route('kasir.dashboard') }}"
                        class="btn btn-nav-monitoring rounded-pill btn-sm fw-bold px-2 px-sm-3" style="font-size: 0.7rem;">
                        <i class="bi bi-display me-1"></i> <span class="d-none d-sm-inline">Monitoring Antrean</span>
                    </a>

                    <!-- Tombol Manajemen Pemesanan -->
                    <a href="{{ route('kasir.order') }}"
                        class="btn btn-nav-manajemen rounded-pill btn-sm fw-bold px-2 px-sm-3"
                        style="font-size: 0.7rem;">
                        <i class="bi bi-receipt me-1"></i> <span class="d-none d-sm-inline">Manajemen Pemesanan</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-danger rounded-pill btn-sm fw-bold px-3 px-sm-4"
                            style="font-size: 0.7rem;">
                            <i class="bi bi-box-arrow-right"></i> <span class="d-none d-sm-inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

    <div class="row flex-grow-1 overflow-hidden" style="min-height: 0;">
        
        <!-- MENU SECTION -->
        <div class="col-lg-8 h-100 overflow-auto custom-scrollbar pe-0 pe-sm-2 pe-md-4 pb-4">
            
            <!-- BEST SELLER SECTION -->
            <div class="menu-section mb-4">
                <h3 class="section-title" style="font-size: clamp(1.1rem, 5vw, 1.5rem);">
                    <i class="fas fa-crown"></i> Best Seller
                </h3>
                
                <div x-show="bestSellerList.length > 0" class="row g-2 g-sm-3 g-md-4">
                    <template x-for="product in bestSellerList" :key="product.id">
                        <div class="col-6 col-md-6 col-lg-4">
                            <div class="card product-card h-100">
                                
                                <div class="best-seller-badge">
                                    <i class="fas fa-crown me-1"></i> BEST SELLER
                                </div>

                                <div x-show="product.stok <= 0" class="position-absolute w-100 h-100 bg-white bg-opacity-75" style="z-index: 10; border-radius: 20px; backdrop-filter: grayscale(100%);">
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                        <span class="badge bg-dark px-4 py-2 text-uppercase shadow-sm" style="font-size: clamp(0.7rem, 3vw, 0.9rem);">Habis</span>
                                    </div>
                                </div>

                                <div class="img-wrapper">
                                    <img :src="'/storage/' + product.image" class="product-img" alt="Product">
                                </div>
                                
                                <div class="card-body d-flex flex-column p-2 p-sm-3">
                                    <h6 class="card-title fw-bold mb-1 text-truncate" style="font-size: clamp(0.8rem, 3vw, 0.95rem);" x-text="product.name"></h6>
                                    <p class="card-text text-muted small mb-2 d-none d-sm-block" style="font-size: clamp(0.7rem, 2.5vw, 0.8rem);" x-text="product.deskripsi"></p>
                                    
                                    <div class="mt-auto">
                                        <button @click="openDetail(product)" class="btn-tambah w-100 d-flex align-items-center justify-content-center py-2" :disabled="product.stok <= 0">
                                            <span class="icon-tambah"><i class="fas fa-plus fa-xs"></i></span> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                
                <div x-show="bestSellerList.length === 0" class="empty-best-seller text-center py-4">
                    <i class="fas fa-chart-line fs-1 mb-3 opacity-50"></i>
                    <p class="mb-0">Belum ada produk Best Seller</p>
                    <small class="text-muted">Produk akan muncul setelah ada transaksi yang berhasil</small>
                </div>
            </div>

            <!-- ALL MENU SECTION -->
            <div class="menu-section">
                <h3 class="section-title" style="font-size: clamp(1.1rem, 5vw, 1.5rem);">
                    <i class="fas fa-utensils"></i> All Menu
                </h3>
                <div class="row g-2 g-sm-3 g-md-4">
                    <template x-for="product in allProducts" :key="product.id">
                        <div class="col-6 col-md-6 col-lg-4">
                            <div class="card product-card h-100">
                                
                                <div x-show="product.isBestSeller" class="best-seller-badge">
                                    <i class="fas fa-crown me-1"></i> BEST SELLER
                                </div>

                                <div x-show="product.stok <= 0" class="position-absolute w-100 h-100 bg-white bg-opacity-75" style="z-index: 10; border-radius: 20px; backdrop-filter: grayscale(100%);">
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                        <span class="badge bg-dark px-4 py-2 text-uppercase shadow-sm" style="font-size: clamp(0.7rem, 3vw, 0.9rem);">Habis</span>
                                    </div>
                                </div>

                                <div class="img-wrapper">
                                    <img :src="'/storage/' + product.image" class="product-img" alt="Product">
                                </div>
                                
                                <div class="card-body d-flex flex-column p-2 p-sm-3">
                                    <h6 class="card-title fw-bold mb-1 text-truncate" style="font-size: clamp(0.8rem, 3vw, 0.95rem);" x-text="product.name"></h6>
                                    
                                    <div class="mt-auto">
                                        <button @click="openDetail(product)" class="btn-tambah w-100 d-flex align-items-center justify-content-center py-2" :disabled="product.stok <= 0">
                                            <span class="icon-tambah"><i class="fas fa-plus fa-xs"></i></span> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>

        <!-- SIDEBAR CART -->
        <div class="col-lg-4 h-100 d-flex flex-column pb-3 mt-3 mt-lg-0">
            @include('layouts.payment-and-popup')
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    /* Root variables dari Kasir Panel */
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

    /* Background dari Kasir Panel (diubah seperti code kedua) */
    body {
        background-color: var(--bg-cream);
        color: var(--text-brown);
        font-family: 'Plus Jakarta Sans', sans-serif;
        overflow-x: hidden;
        margin: 0;
        padding: 0;
        overflow-y: scroll !important;
    }

    /* Navbar Custom - PERSIS dari Kasir Panel (sama dengan code kedua) */
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

    /* Pastikan container kiosk memiliki background cream */
    .kiosk-container {
        background-color: var(--bg-cream);
        min-height: 100vh;
    }

    /* Tombol Monitoring Antrean (Langsung Kuning) */
        .btn-nav-monitoring {
            background-color: #F6AA1C !important;
            color: #ffffff !important; /* Teks putih */
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(246, 170, 28, 0.2);
        }
        
        /* Efek klik/geser yang halus (sedikit terangkat) */
        .btn-nav-monitoring:hover, 
        .btn-nav-monitoring:focus {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(246, 170, 28, 0.35);
            filter: brightness(1.05);
        }

        /* Tombol Manajemen Pemesanan (Langsung Coklat Gelap) */
        .btn-nav-manajemen {
            background-color: #8A4117 !important;
            color: #ffffff !important; /* Teks putih */
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(138, 65, 23, 0.2);
        }
        
        /* Efek klik/geser yang halus (sedikit terangkat) */
        .btn-nav-manajemen:hover, 
        .btn-nav-manajemen:focus {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(138, 65, 23, 0.35);
            filter: brightness(1.1);
        }

        .stok-warning {
            position: fixed;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #2c2c2c;
            color: #F2AF17;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            z-index: 9999;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            border: 2px solid #F2AF17;
        }
</style>
@endpush

@push('body-scripts')
<script>
    function kioskApp(dbProducts, dbBestSellerProducts) {
        return {
            // ===== TOAST NOTIFICATION STATE =====
            showStokWarning: false,
            stokWarningMessage: '',
            warningTimeout: null,

            // ===== PRODUCT DETAIL POPUP STATE =====
            showDetail: false,
            selectedProduct: null,
            selectedVarian: null,

            // ===== PEMBAYARAN POPUP STATE =====
            showPaymentModal: false,
            step: 'payment_method',
            paymentMethod: '',
            customerName: '',
            customerPhone: '',
            queueNumber: '000',
            validationErrors: {
                name: '',
                phone: ''
            },
            
            // ===== DATA =====
            cart: [],
            allProducts: [],
            bestSellerList: [],
            
            init() {
                this.allProducts = (Array.isArray(dbProducts) ? dbProducts : []).map(p => ({
                    id: p.id,
                    name: p.nama_produk,
                    deskripsi: p.deskripsi,
                    image: p.gambar,
                    varians: p.varians || [],
                    price: p.varians && p.varians.length > 0
                        ? Math.min(...p.varians.map(v => parseFloat(v.harga)))
                        : 0,
                    stok: p.varians ? p.varians.reduce((sum, v) => sum + parseInt(v.stok || 0), 0) : 0,
                    isBestSeller: false
                }));
                
                this.bestSellerList = (Array.isArray(dbBestSellerProducts) ? dbBestSellerProducts : []).map(p => ({
                    id: p.id,
                    name: p.nama_produk,
                    deskripsi: p.deskripsi,
                    price: parseFloat(p.harga || 0),
                    image: p.gambar,
                    stok: p.varians ? p.varians.reduce((sum, v) => sum + parseInt(v.stok || 0), 0) : 0,
                    total_terjual: p.total_terjual || 0,
                    varians: p.varians || []
                }));
                
                const bestSellerIds = this.bestSellerList.map(p => p.id);
                this.allProducts = this.allProducts.map(p => {
                    p.isBestSeller = bestSellerIds.includes(p.id);
                    return p;
                });
            },
            
            get cartTotal() { 
                return this.cart.reduce((sum, i) => sum + (i.price * i.qty), 0); 
            },

            // ===== FUNGSI UNTUK MEMUNCULKAN CUSTOM TOAST =====
            showCustomAlert(message) {
                this.stokWarningMessage = message;
                this.showStokWarning = true;
                
                if(this.warningTimeout) {
                    clearTimeout(this.warningTimeout);
                }
                
                this.warningTimeout = setTimeout(() => {
                    this.showStokWarning = false;
                }, 3000);
            },

            openDetail(product) {
                this.selectedProduct = product;
                if (product.varians && product.varians.length > 0) {
                    this.selectedVarian = product.varians[0];
                } else {
                    this.selectedVarian = null;
                }
                this.showDetail = true;
            },

            addToCartFromDetail() {
                if (!this.selectedProduct) return;

                if (this.selectedProduct.varians && this.selectedProduct.varians.length > 0 && !this.selectedVarian) {
                    this.showCustomAlert('Pilih ukuran terlebih dahulu!');
                    return;
                }

                const price = this.selectedVarian
                    ? parseFloat(this.selectedVarian.harga)
                    : this.selectedProduct.price;

                const stokTersedia = this.selectedVarian
                    ? parseInt(this.selectedVarian.stok || 0)
                    : parseInt(this.selectedProduct.stok || 0);

                const varianLabel = this.selectedVarian ? this.selectedVarian.ukuran : '';
                const cartKey = this.selectedProduct.id + '_' + (this.selectedVarian ? this.selectedVarian.id : 'default');

                const existingItem = this.cart.find(item => item.cartKey === cartKey);
                const qtyDiKeranjang = existingItem ? existingItem.qty : 0;

                if (qtyDiKeranjang + 1 > stokTersedia) {
                    this.showCustomAlert('Stok tidak mencukupi!');
                    return;
                }

                if (existingItem) {
                    existingItem.qty++;
                } else {
                    this.cart.push({
                        cartKey: cartKey,
                        id: this.selectedProduct.id,
                        name: this.selectedProduct.name,
                        image: this.selectedProduct.image,
                        price: price,
                        varianId: this.selectedVarian ? this.selectedVarian.id : null,
                        varianLabel: varianLabel,
                        qty: 1
                    });
                }

                this.showDetail = false;
            },

            // ===== FUNGSI PLUS MINUS DI SIDEBAR =====
            decreaseQty(item) {
                if (item.qty > 1) {
                    item.qty--;
                } else {
                    const index = this.cart.findIndex(i => i.cartKey === item.cartKey);
                    if (index !== -1) {
                        this.cart.splice(index, 1);
                    }
                }
            },

            increaseQty(item) {
                const product = this.allProducts.find(p => p.id === item.id);
                const varian = product?.varians?.find(v => v.id === item.varianId);
                const stokTersedia = varian ? parseInt(varian.stok) : parseInt(product?.stok || 0);
                
                if (item.qty + 1 > stokTersedia) {
                    this.showCustomAlert('Stok tidak mencukupi!');
                    return;
                }
                item.qty++;
            },

            // ===== PAYMENT MODAL METHODS =====
            openPaymentModal() {
                if (this.cart.length === 0) return;
                this.showPaymentModal = true;
                this.step = 'payment_method';
                this.paymentMethod = '';
                this.customerName = '';
                this.customerPhone = '';
                this.validationErrors = { name: '', phone: '' };
            },

            closePaymentModal() {
                this.showPaymentModal = false;
                this.step = 'payment_method';
            },

            processToNextStep() {
                if (!this.paymentMethod) {
                    this.showCustomAlert('Pilih metode pembayaran terlebih dahulu!');
                    return;
                }
                
                if (this.paymentMethod === 'qris') {
                    this.step = 'qris_display';
                } else if (this.paymentMethod === 'cash') {
                    this.step = 'customer_form';
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
                if (!this.validateCustomerData()) return;
                
                try {
                    const response = await fetch("{{ route('checkout') }}", {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json', 
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                        },
                        body: JSON.stringify({
                            total: this.cartTotal, 
                            items: this.cart.map(item => ({
                                id: item.id,
                                name: item.name,
                                price: item.price,
                                qty: item.qty,
                                varian_id: item.varianId,
                                varian_label: item.varianLabel
                            })),
                            name: this.customerName, 
                            phone: this.customerPhone, 
                            payment_method: this.paymentMethod
                        })
                    });
                    
                    const result = await response.json();

                    if (result.success) {
                        this.queueNumber = result.queue_number.toString().padStart(3, '0');
                        this.cart = []; 
                        this.step = 'success';
                        
                        setTimeout(() => {
                            location.reload();
                        }, 8000);
                        
                    } else {
                        this.showCustomAlert(result.message || 'Terjadi kesalahan, silakan coba lagi');
                    }
                } catch (error) { 
                    console.error('Error:', error);
                    this.showCustomAlert('Error Sistem: Cek Koneksi Server/Database');
                }
            },

            reset() { 
                location.reload(); 
            }
        }
    }
</script>
@endpush