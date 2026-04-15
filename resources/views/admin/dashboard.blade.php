@extends('layouts.admin')

@section('content')
<header class="flex justify-between items-center mb-12">
    <div>
        <h2 class="text-4xl font-black tracking-tight uppercase">Dashboard <span class="text-chiiiz italic">Statistik</span></h2>
        <p class="text-gray-600 mt-1 font-medium">Laporan real-time performa toko Anda.</p>
    </div>
    <div class="text-right">
        <p class="font-bold text-lg bg-black text-white px-4 py-1 rounded-full border-2 border-chiiiz">
            {{ now()->isoFormat('D MMMM YYYY') }}
        </p>
    </div>
</header>

<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
    <div class="card-neo bg-white p-6 flex items-center gap-4 border-chiiiz">
        <div class="p-3 bg-chiiiz rounded-2xl border-2 border-black">
            <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <p class="text-[10px] font-black uppercase text-gray-400">Pendapatan Hari Ini</p>
            <p class="text-2xl font-black">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="card-neo bg-white p-6 flex items-center gap-4 border-black">
        <div class="p-3 bg-blue-500 rounded-2xl border-2 border-black">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="3" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
        </div>
        <div>
            <p class="text-[10px] font-black uppercase text-gray-400">Total Pesanan</p>
            <p class="text-2xl font-black">{{ $totalPesananHariIni }} Pesanan</p>
        </div>
    </div>

    <div class="card-neo bg-white p-6 flex items-center gap-4 border-red-500">
        <div class="p-3 bg-red-500 rounded-2xl border-2 border-black">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <div>
            <p class="text-[10px] font-black uppercase text-gray-400">Stok Menipis (<10)</p>
            <p class="text-2xl font-black text-red-600">{{ $stokMenipis }} Produk</p>
        </div>
    </div>

    <div class="card-neo bg-white p-6 flex items-center gap-4 border-black">
        <div class="p-3 bg-black rounded-2xl border-2 border-chiiiz">
            <svg class="w-8 h-8 text-chiiiz" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="3" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
        </div>
        <div>
            <p class="text-[10px] font-black uppercase text-gray-400">Varian Produk</p>
            <p class="text-2xl font-black">{{ $totalProduk }} Item</p>
        </div>
    </div>
</section>

<section class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <div class="xl:col-span-2 card-neo p-8 bg-white">
        <h3 class="text-2xl font-black mb-6 uppercase italic">Tren Mingguan <span class="text-gray-300">/ Sales</span></h3>
        <div class="h-80">
            <canvas id="salesTrendChart"></canvas>
        </div>
    </div>

    <div class="card-neo p-8 bg-white border-chiiiz">
        <h3 class="text-2xl font-black mb-6 uppercase italic text-center">Top <span class="text-chiiiz">Selling</span></h3>
        <div class="h-80">
            <canvas id="productFavoriteChart"></canvas>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof Chart === 'undefined') return;

        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.color = '#000000';

        // 1. Grafik Tren (Data dari Controller)
        const weeklyData = @json($weeklySales);
        const salesCtx = document.getElementById('salesTrendChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: weeklyData.map(d => d.date),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: weeklyData.map(d => d.total),
                    borderColor: '#F2AF17',
                    backgroundColor: 'rgba(242, 175, 23, 0.1)',
                    borderWidth: 5,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointBackgroundColor: 'black'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 2. Grafik Top Produk (Data dari Controller)
        const topProducts = @json($topProducts);
        const productCtx = document.getElementById('productFavoriteChart').getContext('2d');
        new Chart(productCtx, {
            type: 'doughnut',
            data: {
                labels: topProducts.map(p => p.nama_produk),
                datasets: [{
                    data: topProducts.map(p => p.total_qty),
                    backgroundColor: ['#F2AF17', '#000000', '#3B82F6', '#EF4444', '#10B981'],
                    borderColor: 'white',
                    borderWidth: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, padding: 20, font: { weight: 'bold' } } }
                }
            }
        });
    });
</script>
@endpush