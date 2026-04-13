<form method="POST" action="{{ route('logout') }}" class="w-full p-4">
    @csrf
    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-red-600 hover:bg-black text-white font-black rounded-xl border-2 border-black transition-all group shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1">
        <svg class="w-5 h-5 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        LOGOUT
    </button>
</form>