<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ChiiiZkut</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F2AF17] min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-lg rounded-[3rem] p-10 border-4 border-black shadow-[15px_15px_0px_0px_rgba(0,0,0,1)]">
        <div class="mb-8">
            <h2 class="text-4xl font-black italic text-black tracking-tighter">JOIN THE TEAM.</h2>
            <p class="text-gray-600 font-bold">Daftarkan akun kasir/admin baru ChiiiZkut.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="username" class="block text-sm font-black mb-1">USERNAME</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required
                    class="w-full border-2 border-black rounded-2xl p-3 focus:bg-gray-50 outline-none transition font-bold shadow-sm">
                @error('username')
                    <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-black mb-1">AKSES ROLE</label>
                <select id="role" name="role" required
                    class="w-full border-2 border-black rounded-2xl p-3 bg-white font-bold outline-none focus:ring-2 focus:ring-black transition cursor-pointer">
                    <option value="">-- Pilih Akses --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                </select>
                @error('role')
                    <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-black mb-1">PASSWORD</label>
                    <input id="password" type="password" name="password" required
                        class="w-full border-2 border-black rounded-2xl p-3 outline-none">
                    @error('password')
                        <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-black mb-1">KONFIRMASI</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full border-2 border-black rounded-2xl p-3 outline-none">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-black text-[#F2AF17] font-black py-4 rounded-2xl text-xl hover:scale-95 transition-transform duration-200">
                    DAFTARKAN SEKARANG
                </button>
            </div>

            <div class="text-center">
                <a class="text-sm font-bold text-black underline" href="{{ route('login') }}">
                    Sudah punya akses? Login
                </a>
            </div>
        </form>
    </div>

</body>
</html>