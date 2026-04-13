<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - ChiiiZkut. 🧀</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .bg-chiiiz { background-color: #F2AF17; }
        .text-chiiiz { color: #F2AF17; }
        .border-chiiiz { border-color: #F2AF17; }
        
        /* Neo-Brutalism Style Utilities */
        .card-neo {
            background: white;
            border: 3px solid black;
            border-radius: 1.5rem;
            box-shadow: 8px 8px 0px 0px rgba(0,0,0,1);
            transition: all 0.2s ease;
        }
        .card-neo-orange {
            box-shadow: 8px 8px 0px 0px rgba(242,175,23,1);
        }
        .card-neo:hover {
            transform: translate(-2px, -2px);
            box-shadow: 10px 10px 0px 0px rgba(0,0,0,1);
        }
        .card-neo-orange:hover {
            box-shadow: 10px 10px 0px 0px rgba(242,175,23,1);
        }
    </style>
</head>
<body class="bg-gray-100 text-black">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-black text-white p-6 flex flex-col border-r-4 border-chiiiz">
            <div class="mb-12 text-center">
                <h1 class="text-3xl font-black italic text-chiiiz tracking-tighter">ChiiiZkut.</h1>
                <p class="text-xs uppercase font-bold text-gray-500 tracking-widest mt-1">Admin Panel</p>
            </div>
            
            <nav class="space-y-3 flex-grow">
                <a href="#" class="flex items-center gap-3 py-3 px-4 bg-chiiiz text-black rounded-xl font-extrabold shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('produks.index') }}" class="flex items-center gap-3 py-3 px-4 hover:bg-gray-800 rounded-xl transition font-semibold text-gray-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Produk Cake
                </a>
                <a href="#" class="flex items-center gap-3 py-3 px-4 hover:bg-gray-800 rounded-xl transition font-semibold text-gray-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a２ ２ ０ ０１２ －２ｖ１４ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ Ａ２ ＩＮＴＥＲＮＡＬＩＺＥＤ＿ＳＴＲＩＮＧＳ
                    Laporan
                </a>
                <a href="#" class="flex items-center gap-3 py-3 px-4 hover:bg-gray-800 rounded-xl transition font-semibold text-gray-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 01-9-4.354m3 8.646h.01"></path></svg>
                    Karyawan
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full p-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-red-600 hover:bg-black text-white font-black rounded-xl border-2 border-black transition-all group shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                        <svg class="w-5 h-5 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        LOGOUT
                    </button>
                </form>
            </nav>

            <div class="border-t-2 border-gray-800 pt-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-chiiiz rounded-full border-2 border-white flex items-center justify-center font-black text-black text-xl">A</div>
                    <div>
                        <p class="font-bold text-sm">{{ Auth::user()->username ?? 'Admin Dummy' }}</p>
                        <p class="text-xs text-gray-400 capitalize">{{ Auth::user()->role ?? 'admin' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-center py-2 px-4 bg-red-600 hover:bg-red-700 rounded-xl font-bold text-sm text-white transition">
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-8 md:p-12 bg-gray-50">
            <header class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-4xl font-black tracking-tight">Kinerja Toko <span class="text-chiiiz italic">ChiiiZkut</span></h2>
                    <p class="text-gray-600 mt-1 font-medium">Ringkasan data penjualan dan operasional hari ini (Dummy Data).</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-lg">{{ now()->isoFormat('D MMMM YYYY') }}</p>
                    <p class="text-sm text-gray-500">{{ now()->format('H:i') }} WIB</p>
                </div>
            </header>

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div class="card-neo card-neo-orange p-6 flex items-center gap-4 border-chiiiz">
                    <div class="p-3 bg-chiiiz rounded-full border-2 border-black text-black">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase text-gray-500 tracking-wider">Pendapatan Hari Ini</p>
                        <p class="text-3xl font-black mt-1 text-chiiiz">Rp 8.7M</p>
                    </div>
                </div>
                <div class="card-neo p-6 flex items-center gap-4">
                    <div class="p-3 bg-gray-100 rounded-full border-2 border-black text-black">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase text-gray-500 tracking-wider">Cake Terjual</p>
                        <p class="text-3xl font-black mt-1">195</p>
                    </div>
                </div>
                <div class="card-neo p-6 flex items-center gap-4">
                    <div class="p-3 bg-gray-100 rounded-full border-2 border-black text-black">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase text-gray-500 tracking-wider">Pelanggan Baru</p>
                        <p class="text-3xl font-black mt-1">45</p>
                    </div>
                </div>
                <div class="card-neo p-6 flex items-center gap-4">
                    <div class="p-3 bg-gray-100 rounded-full border-2 border-black text-black">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase text-gray-500 tracking-wider">Stok Kritis</p>
                        <p class="text-3xl font-black mt-1 text-red-600">3</p>
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-12">
                <div class="card-neo xl:col-span-2 p-8 bg-white border-2 border-black">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black tracking-tight">Tren Penjualan Mingguan</h3>
                        <span class="text-xs font-bold text-gray-400">Update: 5 menit yang lalu</span>
                    </div>
                    <div class="h-80">
                        <canvas id="salesTrendChart"></canvas>
                    </div>
                </div>

                <div class="card-neo p-8 bg-white border-2 border-black shadow-[8px_8px_0px_0px_rgba(242,175,23,1)] border-chiiiz">
                    <h3 class="text-2xl font-black tracking-tight mb-6 text-center">Produk Terlaris</h3>
                    <div class="h-80 flex justify-center">
                        <canvas id="productFavoriteChart"></canvas>
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="card-neo p-8 bg-white border-2 border-black">
                    <h3 class="text-2xl font-black tracking-tight mb-6">Performa Transaksi Kasir</h3>
                    <div class="h-64">
                        <canvas id="cashierPerformanceChart"></canvas>
                    </div>
                </div>

                <div class="card-neo p-8 bg-white border-2 border-black">
                    <h3 class="text-2xl font-black tracking-tight mb-6">Log Transaksi Terakhir</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="border-b-2 border-black text-xs uppercase font-black text-gray-500 tracking-wider">
                                <tr>
                                    <th class="p-3">ID Trx</th>
                                    <th class="p-3">Waktu</th>
                                    <th class="p-3">Kasir</th>
                                    <th class="p-3 text-right">Total</th>
                                    <th class="p-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-semibold divide-y divide-gray-100">
                                <tr>
                                    <td class="p-3 font-mono text-chiiiz">#CZK1005</td>
                                    <td class="p-3">15:30</td>
                                    <td class="p-3">Budi</td>
                                    <td class="p-3 text-right font-bold">Rp 155.000</td>
                                    <td class="p-3"><span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full border border-green-300">Lunas</span></td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-mono text-chiiiz">#CZK1004</td>
                                    <td class="p-3">15:22</td>
                                    <td class="p-3">Siti</td>
                                    <td class="p-3 text-right font-bold">Rp 90.000</td>
                                    <td class="p-3"><span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full border border-green-300">Lunas</span></td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-mono text-chiiiz">#CZK1003</td>
                                    <td class="p-3">15:15</td>
                                    <td class="p-3">Budi</td>
                                    <td class="p-3 text-right font-bold">Rp 210.000</td>
                                    <td class="p-3"><span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full border border-green-300">Lunas</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Cek apakah library Chart sudah terload
            if (typeof Chart === 'undefined') {
                console.error("Gagal memuat Chart.js. Pastikan koneksi internet stabil.");
                alert("Grafik tidak bisa ditampilkan karena library Chart.js gagal dimuat.");
                return;
            }

            // Konfigurasi Global
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            Chart.defaults.color = '#000000';

            // 1. Sales Trend Chart
            const salesCtx = document.getElementById('salesTrendChart');
            if (salesCtx) {
                new Chart(salesCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                        datasets: [{
                            label: 'Pendapatan (Juta Rp)',
                            data: [5.2, 6.1, 4.8, 7.5, 9.2, 12.1, 10.8],
                            borderColor: '#F2AF17',
                            backgroundColor: 'rgba(242, 175, 23, 0.1)',
                            borderWidth: 4,
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: 'black',
                            pointRadius: 5
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            }

            // 2. Product Favorite Chart
            const productCtx = document.getElementById('productFavoriteChart');
            if (productCtx) {
                new Chart(productCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Original', 'Choco', 'Berry', 'Pandan'],
                        datasets: [{
                            data: [40, 25, 20, 15],
                            backgroundColor: ['#F2AF17', '#8B4513', '#FF69B4', '#32CD32'],
                            borderColor: 'black',
                            borderWidth: 2
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            }

            // 3. Cashier Performance Chart
            const cashierCtx = document.getElementById('cashierPerformanceChart');
            if (cashierCtx) {
                new Chart(cashierCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Budi', 'Siti', 'Agus', 'Lina'],
                        datasets: [{
                            label: 'Transaksi',
                            data: [65, 82, 41, 55],
                            backgroundColor: '#000000',
                            borderRadius: 10
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            }
        });
    </script>
</body>
</html>