<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ChiiiZkut</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F2AF17] min-h-screen flex items-center justify-center p-6">

    <div class="bg-white w-full max-w-xl rounded-[2rem] border-4 border-black p-8 md:p-12 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]">
        <div class="mb-10">
            <h2 class="text-4xl font-black uppercase">Buat Akun</h2>
            <p class="text-gray-600 font-bold">Gabung jadi ChiiiZ-Lovers sekarang!</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="grid md:grid-cols-2 gap-6">
            @csrf
            <div class="col-span-2">
                <label class="block font-black mb-1">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full border-2 border-black rounded-xl p-3 focus:ring-4 focus:ring-[#F2AF17] outline-none">
            </div>

            <div class="col-span-2">
                <label class="block font-black mb-1">Email</label>
                <input type="email" name="email" required class="w-full border-2 border-black rounded-xl p-3 focus:ring-4 focus:ring-[#F2AF17] outline-none">
            </div>

            <div>
                <label class="block font-black mb-1">Password</label>
                <input type="password" name="password" required class="w-full border-2 border-black rounded-xl p-3 focus:ring-4 focus:ring-[#F2AF17] outline-none">
            </div>

            <div>
                <label class="block font-black mb-1">Konfirmasi</label>
                <input type="password" name="password_confirmation" required class="w-full border-2 border-black rounded-xl p-3 focus:ring-4 focus:ring-[#F2AF17] outline-none">
            </div>

            <div class="col-span-2 pt-4">
                <button type="submit" class="w-full bg-black text-[#F2AF17] font-black py-4 rounded-xl text-xl hover:scale-[1.02] transition-transform shadow-lg">
                    DAFTAR AKUN
                </button>
            </div>
        </form>

        <div class="mt-8 text-center border-t-2 border-gray-100 pt-6">
            <span class="text-gray-500">Sudah jadi member?</span>
            <a href="{{ route('login') }}" class="font-black hover:text-[#F2AF17] transition">Login di sini</a>
        </div>
    </div>

</body>
</html>