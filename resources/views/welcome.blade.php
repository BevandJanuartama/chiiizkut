<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChiiiZkut - Specialist Cheesecake</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-chiiiz { background-color: #F2AF17; }
        .text-chiiiz { color: #F2AF17; }
        .border-chiiiz { border-color: #F2AF17; }
    </style>
</head>
<body class="bg-white font-sans text-gray-900">

    <nav class="bg-black text-white p-5">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-chiiiz rounded-full flex items-center justify-center font-black text-black">C</div>
                <span class="text-2xl font-black tracking-tighter text-chiiiz">ChiiiZkut</span>
            </div>
            <div class="hidden md:flex space-x-8 font-bold">
                <a href="#" class="hover:text-chiiiz transition">Menu</a>
                <a href="#" class="hover:text-chiiiz transition">Promo</a>
                <a href="{{ route('login') }}" class="text-chiiiz border-2 border-chiiiz px-5 py-1 rounded-full hover:bg-chiiiz hover:text-black transition">Login</a>
            </div>
        </div>
    </nav>

    <header class="bg-black text-white py-24 px-6 border-b-[12px] border-chiiiz text-center">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-6xl md:text-8xl font-black mb-6 leading-none italic">
                SAY <span class="text-chiiiz">CHIIIIZ!</span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 text-gray-400">Cheesecake premium dengan tekstur lembut yang bikin nagih.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-chiiiz text-black px-10 py-4 rounded-full text-xl font-black hover:scale-105 transition-transform">
                    DAFTAR SEKARANG
                </a>
            </div>
        </div>
    </header>

    <section class="py-20 container mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-10">
            @foreach(['Original', 'Double Cheese', 'Choco ChiiiZ'] as $item)
            <div class="bg-white border-4 border-black p-6 rounded-3xl hover:translate-x-2 hover:-translate-y-2 transition-all hover:shadow-[10px_10px_0px_0px_rgba(0,0,0,1)]">
                <div class="bg-gray-100 aspect-square rounded-2xl mb-4 flex items-center justify-center text-gray-400 italic border-2 border-dashed border-gray-300">
                    Foto Kue
                </div>
                <h3 class="text-2xl font-black uppercase">{{ $item }}</h3>
                <p class="text-chiiiz font-bold text-lg mt-2">Rp 45.000,00</p>
            </div>
            @endforeach
        </div>
    </section>

</body>
</html>