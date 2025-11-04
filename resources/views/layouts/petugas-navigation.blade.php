<aside class="w-64 bg-gradient-to-b from-teal-700 via-teal-800 to-cyan-900 text-white min-h-screen relative">
    <div class="p-4 font-bold text-lg border-b border-white/10">
        E-Tiketing Lempuyang
    </div>
    <nav class="mt-4 flex flex-col space-y-2 px-4">
        <a href="{{ route('petugas.dashboard') }}"
           class="px-3 py-2 rounded hover:bg-teal-600/60 {{ request()->routeIs('petugas.dashboard') ? 'bg-teal-600/80' : '' }}">
           Verifikasi Tiket
        </a>
        <a href="{{ route('petugas.bookings.index') }}"
           class="px-3 py-2 rounded hover:bg-teal-600/60 {{ request()->routeIs('petugas.bookings.*') ? 'bg-teal-600/80' : '' }}">
           Manajemen Pesanan
        </a>
    </nav>

    {{-- Bagian bawah sidebar --}}
    <div class="absolute bottom-0 w-64 p-4 border-t border-white/10">
        <div class="flex items-center justify-between">
            <span class="text-sm">{{ Auth::user()->name ?? 'Petugas' }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm bg-red-600 hover:bg-red-800 px-2 py-1 rounded">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</aside>
