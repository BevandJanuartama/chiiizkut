<aside class="w-64 bg-black text-white p-6 flex flex-col border-r-4 border-chiiiz min-h-screen sticky top-0">
    <div class="mb-12 text-center">
        <h1 class="text-3xl font-black italic text-chiiiz tracking-tighter">ChiiiZkut.</h1>
        <p class="text-xs uppercase font-bold text-gray-500 tracking-widest mt-1">Admin Panel</p>
    </div>
    
    <nav class="space-y-3 flex-grow">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 py-3 px-4 {{ request()->routeIs('admin.dashboard') ? 'bg-chiiiz text-black' : 'text-gray-300 hover:text-white hover:bg-gray-800' }} rounded-xl font-extrabold transition shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        <a href="{{ route('produks.index') }}" class="flex items-center gap-3 py-3 px-4 {{ request()->is('admin/produk*') ? 'bg-chiiiz text-black' : 'text-gray-300 hover:text-white hover:bg-gray-800' }} rounded-xl transition font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            Produk Cake
        </a>

        <a href="{{ route('stok.logs') }}" class="flex items-center gap-3 py-3 px-4 {{ request()->is('admin/stok/logs') ? 'bg-chiiiz text-black' : 'text-gray-300 hover:text-white hover:bg-gray-800' }} rounded-xl transition font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Riwayat Stok
        </a>
    </nav>

    <div class="border-t-2 border-gray-800 pt-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-red-600 hover:bg-black text-white font-black rounded-xl border-2 border-black transition-all group shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
                LOGOUT
            </button>
        </form>
    </div>
</aside>