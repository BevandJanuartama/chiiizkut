@extends('layouts.app2')

@section('title', 'ChiiiZkut - Self Ordering Kiosk')

@section('body-attributes')
x-data='kioskApp(@json($produks ?? []), @json($bestSellerProducts ?? []))' x-init="init()"
@endsection

@section('content')
<div class="kiosk-container w-100 d-flex flex-column px-2 px-sm-3 px-md-4 py-2 py-sm-3">
    
    <header class="d-flex flex-wrap justify-content-between align-items-center mb-3 mb-sm-4 pb-2 pb-sm-3 border-bottom flex-shrink-0">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-header img-fluid" style="height: clamp(35px, 6vw, 50px); width: auto;">
        </div>
        <div class="text-end">
            <h4 class="mb-1 text-secondary fw-bold" style="font-size: clamp(0.9rem, 4vw, 1.25rem);">Halo, selamat datang !</h4>
            <p class="mb-0 text-muted small fw-semibold d-none d-sm-block">Siap mencicipi kelezatan Chiiizkut hari ini?</p>
        </div>
    </header>

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
                                    <img :src="'/storage/' + product.image" class="product-img" alt="Product" loading="lazy">
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
                                    <img :src="'/storage/' + product.image" class="product-img" alt="Product" loading="lazy">
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
                
                // Clear timeout supaya tidak bertumpuk jika diklik berkali-kali dengan cepat
                if(this.warningTimeout) {
                    clearTimeout(this.warningTimeout);
                }
                
                // Sembunyikan otomatis setelah 3 detik
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
                    // MENGGANTI ALERT BAWAAN
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
                    // MENGGANTI ALERT BAWAAN
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
                    // MENGGANTI ALERT BAWAAN
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
                    // MENGGANTI ALERT BAWAAN
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
                        // MENGGANTI ALERT BAWAAN
                        this.showCustomAlert(result.message || 'Terjadi kesalahan, silakan coba lagi');
                    }
                } catch (error) { 
                    console.error('Error:', error);
                    // MENGGANTI ALERT BAWAAN
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