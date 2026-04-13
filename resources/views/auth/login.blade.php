<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ChiiiZkut</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .chiiiz-orange { color: #F2AF17; }
        .bg-chiiiz { background-color: #F2AF17; }
        .border-chiiiz { border-color: #F2AF17; }
    </style>
</head>
<body class="bg-black min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-[2.5rem] overflow-hidden shadow-[10px_10px_0px_0px_rgba(242,175,23,1)] border-2 border-black">
        <div class="bg-white p-8 text-center border-b-2 border-gray-100">
            <div class="inline-block bg-black text-[#F2AF17] px-6 py-2 rounded-full text-3xl font-black italic tracking-tighter mb-2">
                ChiiiZkut
            </div>
            <p class="text-sm text-gray-500 font-bold uppercase tracking-widest">Login Cashier & Admin</p>
        </div>

        <div class="p-8">
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-xs font-black uppercase mb-1">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                        class="w-full border-2 border-black rounded-xl p-3 focus:ring-4 focus:ring-[#F2AF17] focus:outline-none font-bold transition-all">
                    @error('username')
                        <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-black uppercase mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full border-2 border-black rounded-xl p-3 focus:ring-4 focus:ring-[#F2AF17] focus:outline-none font-bold transition-all">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-black border-2 border-black rounded focus:ring-[#F2AF17]">
                    <label for="remember_me" class="ml-2 text-sm font-bold text-gray-600">Ingat Saya</label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-black text-[#F2AF17] font-black py-4 rounded-2xl hover:bg-[#F2AF17] hover:text-black transition-all duration-300 shadow-lg uppercase tracking-widest">
                        Masuk Ke Sistem
                    </button>
                </div>

                <div class="text-center mt-4">
                    <a class="text-xs font-bold text-gray-400 hover:text-black underline transition" href="{{ route('register') }}">
                        Belum punya akun kasir? Daftar di sini
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>