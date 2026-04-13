@extends('layouts.admin')

@section('content')
<header class="flex justify-between items-center mb-12">
    <div>
        <h2 class="text-4xl font-black tracking-tight">Kinerja Toko <span class="text-chiiiz italic">ChiiiZkut</span></h2>
        <p class="text-gray-600 mt-1 font-medium">Ringkasan data hari ini.</p>
    </div>
    <div class="text-right">
        <p class="font-bold text-lg">{{ now()->isoFormat('D MMMM YYYY') }}</p>
    </div>
</header>

<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
    <div class="card-neo card-neo-orange p-6 flex items-center gap-4 border-chiiiz">
        <div class="p-3 bg-chiiiz rounded-full border-2 border-black">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2"></path></svg>
        </div>
        <div>
            <p class="text-xs font-black uppercase text-gray-500">Pendapatan</p>
            <p class="text-2xl font-black text-chiiiz">Rp 8.7M</p>
        </div>
    </div>
    </section>

<section class="grid grid-cols-1 xl:grid-cols-2 gap-8">
    <div class="card-neo p-8 bg-white">
        <h3 class="text-2xl font-black mb-6">Tren Mingguan</h3>
        <div class="h-64">
            <canvas id="salesTrendChart"></canvas>
        </div>
    </div>
</section>
@endsection

@push('scripts')
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
@endpush