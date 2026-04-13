<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChiiiZkut - Self Ordering Kiosk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-chiiiz { background-color: #F2AF17; }
        .text-chiiiz { color: #F2AF17; }
        .neo-card { border: 4px solid black; box-shadow: 8px 8px 0px 0px rgba(0,0,0,1); transition: all 0.2s ease; }
        .neo-card:active { transform: translate(3px, 3px); box-shadow: 2px 2px 0px 0px rgba(0,0,0,1); }
        .active-category { background-color: #F2AF17 !important; color: black !important; border: 4px solid black !important; box-shadow: 4px 4px 0px 0px black; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-gray-100 text-black overflow-hidden" x-data="kioskApp({{ $produks->toJson() }})">

    <div class="flex flex-col lg:flex-row h-screen w-full overflow-hidden">
        
        <aside class="w-full lg:w-32 bg-black lg:h-full flex lg:flex-col items-center p-4 lg:py-10 gap-6 border-b-4 lg:border-r-4 border-chiiiz z-20 overflow-x-auto no-scrollbar">
            <template x-for="cat in categories" :key="cat.id">
                <button @click="activeCategory = cat.id" 
                    :class="activeCategory === cat.id ? 'active-category' : 'text-gray-500'"
                    class="min-w-[70px] w-16 h-16 lg:w-20 lg:h-20 rounded-2xl flex flex-col items-center justify-center border-2 flex-shrink-0 group">
                    <span class="text-xl lg:text-3xl" x-text="cat.icon"></span>
                    <span class="text-[9px] font-black uppercase mt-1" x-text="cat.name"></span>
                </button>
            </template>
        </aside>

        <section class="flex-1 flex flex-col bg-white overflow-hidden relative">
            <header class="p-6 flex justify-between items-center border-b-4 border-gray-100">
                <div>
                    <h2 class="text-2xl lg:text-4xl font-black italic uppercase leading-none">CHIIIZ <span class="text-chiiiz">KIOSK</span></h2>
                    <p class="text-xs font-bold text-gray-400 mt-1 uppercase">Pesan & Bayar Mandiri</p>
                </div>
                <button @click="reset()" class="bg-red-500 text-white font-black px-4 py-2 rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_black] active:shadow-none active:translate-y-1">BATALKAN SEMUA</button>
            </header>

            <div class="flex-1 overflow-y-auto p-8 bg-gray-50/50">
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <div @click="addToCart(product)" class="neo-card rounded-[2.5rem] p-4 bg-white cursor-pointer group">
                            <div class="aspect-square bg-gray-100 rounded-[2rem] mb-4 overflow-hidden border-2 border-black">
                                <img :src="'/storage/' + product.image" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            </div>
                            <h4 class="font-black text-xs lg:text-md uppercase line-clamp-1" x-text="product.name"></h4>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-chiiiz font-extrabold text-lg" x-text="'Rp' + (product.price/1000) + 'k'"></span>
                                <div class="w-8 h-8 bg-black text-chiiiz rounded-full flex items-center justify-center font-black" 
                                     :class="product.stok <= 0 ? 'bg-gray-400 opacity-50' : ''">+</div>
                            </div>
                            <p class="text-[9px] font-bold mt-1 text-gray-400 uppercase" x-text="'Stok: ' + product.stok"></p>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <aside class="w-full lg:w-96 bg-black text-white flex flex-col border-t-4 lg:border-l-4 border-chiiiz z-30 transition-all duration-300"
            :class="cart.length > 0 ? 'translate-y-0 h-[450px] lg:h-full' : 'translate-y-full lg:translate-y-0 h-0 lg:h-full'">
            
            <div class="p-6 border-b border-gray-800 flex justify-between items-center">
                <h3 class="text-xl font-black italic text-chiiiz uppercase tracking-tighter">My Order</h3>
                <button @click="cart = []" class="text-[10px] text-red-500 font-bold uppercase underline">Kosongkan</button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-4 no-scrollbar">
                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="flex items-center gap-4 bg-zinc-900 p-4 rounded-3xl border-2 border-zinc-800">
                        <img :src="'/storage/' + item.image" class="w-12 h-12 rounded-xl object-cover">
                        <div class="flex-1">
                            <p class="font-black text-[10px] uppercase" x-text="item.name"></p>
                            <p class="text-chiiiz font-bold text-xs" x-text="'Rp ' + (item.price * item.qty).toLocaleString()"></p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button @click="removeFromCart(index)" class="w-6 h-6 bg-zinc-800 rounded-lg font-black">-</button>
                            <span class="text-xs font-black" x-text="item.qty"></span>
                            <button @click="addToCart(item)" class="w-6 h-6 bg-chiiiz text-black rounded-lg font-black">+</button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="p-6 bg-white text-black border-t-4 border-chiiiz">
                <div class="flex justify-between items-end mb-6">
                    <p class="text-3xl font-black" x-text="'Rp' + cartTotal.toLocaleString()"></p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase" x-text="totalItems + ' Items'"></p>
                </div>
                <button @click="openModal = true; step = 'payment'" 
                    class="w-full bg-black text-chiiiz font-black py-5 rounded-[2rem] text-xl shadow-[6px_6px_0px_0px_#F2AF17]">
                    BAYAR SEKARANG
                </button>
            </div>
        </aside>

        <div x-show="openModal" class="fixed inset-0 bg-black/95 backdrop-blur-md z-50 flex items-center justify-center p-4" x-cloak>
            <div class="bg-white rounded-[3rem] w-full max-w-md p-10 border-4 border-black relative">
                
                <div x-show="step === 'payment'">
                    <h3 class="text-2xl font-black uppercase mb-6 text-center italic">Pilih <span class="text-chiiiz">Metode Pembayaran</span></h3>
                    <div class="grid grid-cols-2 gap-4">
                        <button @click="selectPayment('cash')" class="neo-card p-6 rounded-[2rem] flex flex-col items-center gap-2 hover:bg-chiiiz transition">
                            <span class="text-4xl">💵</span>
                            <span class="font-black uppercase text-xs">CASH</span>
                        </button>
                        <button @click="selectPayment('qris')" class="neo-card p-6 rounded-[2rem] flex flex-col items-center gap-2 hover:bg-chiiiz transition">
                            <span class="text-4xl">📱</span>
                            <span class="font-black uppercase text-xs">QRIS</span>
                        </button>
                    </div>
                    <button @click="openModal = false" class="w-full mt-6 text-xs font-bold uppercase underline">Kembali</button>
                </div>

                <div x-show="step === 'qris_display'" class="text-center">
                    <h3 class="text-xl font-black uppercase mb-4 text-center">SCAN <span class="text-chiiiz">QRIS</span></h3>
                    <div class="bg-gray-100 p-4 rounded-3xl border-2 border-black inline-block mb-4">
                        <img src="/img/qris-placeholder.png" class="w-48 h-48 mx-auto">
                    </div>
                    <p class="text-[10px] font-bold text-gray-400 mb-6 italic uppercase">Silakan bayar, lalu klik tombol di bawah.</p>
                    <button @click="step = 'customer'" class="w-full bg-black text-chiiiz font-black py-4 rounded-2xl shadow-[4px_4px_0px_0px_#F2AF17]">SAYA SUDAH BAYAR</button>
                </div>

                <div x-show="step === 'customer'">
                    <h3 class="text-2xl font-black uppercase mb-6 text-center">Data <span class="text-chiiiz">Pesanan</span></h3>
                    <div class="space-y-4">
                        <input type="text" x-model="customerName" placeholder="NAMA LENGKAP" class="w-full border-4 border-black p-4 rounded-2xl font-black uppercase">
                        <input type="tel" x-model="customerPhone" placeholder="NOMOR WHATSAPP" class="w-full border-4 border-black p-4 rounded-2xl font-black">
                        <button @click="finishOrder()" class="w-full bg-black text-chiiiz font-black py-5 rounded-2xl text-xl mt-4">KONFIRMASI PESANAN 🧀</button>
                    </div>
                    <button @click="step = 'payment'" class="w-full mt-4 text-xs font-bold uppercase underline text-gray-400">Kembali</button>
                </div>

                <div x-show="step === 'success'" class="text-center">
                    <h3 class="text-2xl font-black uppercase text-chiiiz">PESANAN BERHASIL!</h3>
                    <div class="bg-black text-chiiiz p-10 rounded-[3rem] border-4 border-chiiiz my-8">
                        <p class="text-xs font-bold uppercase opacity-60 mb-2 tracking-widest">Nomor Antrean</p>
                        <h4 class="text-8xl font-black" x-text="queueNumber"></h4>
                    </div>
                    <p class="text-xs font-bold mb-6 italic text-gray-500">Silakan ambil struk Anda dan tunggu dipanggil.</p>
                    <button @click="reset()" class="font-black underline text-sm uppercase">PESAN LAGI</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function kioskApp(dbProducts) {
            return {
                step: 'cart', 
                activeCategory: 'all',
                openModal: false,
                paymentMethod: '',
                customerName: '',
                customerPhone: '',
                queueNumber: '000',
                cart: [],
                categories: [
                    { id: 'all', name: 'Semua', icon: '🍮' },
                    { id: 'slice', name: 'Slice', icon: '🍰' },
                    { id: 'whole', name: 'Whole', icon: '🎂' },
                    { id: 'drink', name: 'Drink', icon: '🥤' }
                ],
                products: dbProducts.map(p => ({
                    id: p.id, 
                    name: p.nama_produk, 
                    price: parseFloat(p.harga), 
                    image: p.gambar,
                    stok: p.stok,
                    category: p.nama_produk.toLowerCase().includes('drink') ? 'drink' : (p.nama_produk.toLowerCase().includes('whole') ? 'whole' : 'slice')
                })),

                get filteredProducts() { 
                    return this.activeCategory === 'all' ? this.products : this.products.filter(p => p.category === this.activeCategory); 
                },
                get cartTotal() { return this.cart.reduce((sum, i) => sum + (i.price * i.qty), 0); },
                get totalItems() { return this.cart.reduce((sum, i) => sum + i.qty, 0); },

                addToCart(p) {
                    let existing = this.cart.find(item => item.id === p.id);
                    if (existing) {
                        if(existing.qty < p.stok) existing.qty++;
                        else alert('Maaf, stok sudah habis!');
                    } else {
                        if(p.stok > 0) this.cart.push({ ...p, qty: 1 });
                        else alert('Maaf, produk ini sedang kosong!');
                    }
                },
                removeFromCart(index) {
                    if (this.cart[index].qty > 1) this.cart[index].qty--;
                    else this.cart.splice(index, 1);
                },

                selectPayment(method) {
                    this.paymentMethod = method;
                    if(method === 'qris') {
                        this.step = 'qris_display';
                    } else {
                        this.step = 'customer';
                    }
                },

                async finishOrder() {
                    if(!this.customerName || !this.customerPhone) return alert('Harap lengkapi Nama dan No WhatsApp!');
                    
                    try {
                        const response = await fetch("{{ route('checkout') }}", {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json', 
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                            },
                            body: JSON.stringify({
                                total: this.cartTotal,
                                items: this.cart,
                                name: this.customerName,
                                phone: this.customerPhone,
                                payment_method: this.paymentMethod
                            })
                        });
                        
                        const result = await response.json();
                        if(result.success) {
                            this.queueNumber = result.queue_number.toString().padStart(3, '0');
                            this.step = 'success';
                        } else {
                            alert(result.message);
                        }
                    } catch (error) { 
                        alert('Terjadi kesalahan sistem. Silakan hubungi kasir.'); 
                    }
                },

                reset() {
                    location.reload(); 
                }
            }
        }
    </script>
</body>
</html>