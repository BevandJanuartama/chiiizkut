<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ChiiiZkut</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black min-h-screen flex items-center justify-center p-6">

    <div class="bg-white w-full max-w-md rounded-[40px] overflow-hidden shadow-2xl">
        <div class="bg-[#F2AF17] p-10 text-center">
            <h2 class="text-4xl font-black italic tracking-tighter">ChiiiZkut</h2>
            <p class="font-bold mt-2">Selamat Datang Kembali!</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="p-10 space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-black uppercase mb-1">Email</label>
                <input type="email" name="email" required class="w-full border-b-4 border-black p-2 focus:outline-none focus:border-[#F2AF17] transition-colors" placeholder="nama@email.com">
            </div>

            <div>
                <label class="block text-sm font-black uppercase mb-1">Password</label>
                <input type="password" name="password" required class="w-full border-b-4 border-black p-2 focus:outline-none focus:border-[#F2AF17] transition-colors" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-black text-white font-black py-4 rounded-2xl hover:bg-[#F2AF17] hover:text-black transition duration-300 uppercase tracking-widest">
                Masuk
            </button>

            <p class="text-center text-sm font-medium">
                Belum punya akun? <a href="{{ route('register') }}" class="text-[#F2AF17] font-black underline">Daftar Sekarang</a>
            </p>
        </form>
    </div>

</body>
</html>