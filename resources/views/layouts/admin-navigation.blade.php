<aside class="w-64 bg-gradient-to-b from-indigo-700 via-indigo-800 to-purple-900 text-white min-h-screen relative">
    <div class="p-4 font-bold text-lg border-b border-white/10">
        E-Tiketing Lempuyang
    </div>
    <nav class="mt-4 flex flex-col space-y-2 px-4">
        <a href="{{ route('admin.dashboard') }}"
           class="px-3 py-2 rounded hover:bg-indigo-600/60 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600/80' : '' }}">
           Dashboard
        </a>
        <a href="{{ route('admin.orders.index') }}"
           class="px-3 py-2 rounded hover:bg-indigo-600/60 {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600/80' : '' }}">
           Pesanan
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="px-3 py-2 rounded hover:bg-indigo-600/60 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600/80' : '' }}">
           Pengguna
        </a>
        <a href="{{ route('admin.reports') }}"
           class="px-3 py-2 rounded hover:bg-indigo-600/60 {{ request()->routeIs('admin.reports') ? 'bg-indigo-600/80' : '' }}">
           Laporan
        </a>
    </nav>

    {{-- Bagian bawah sidebar --}}
    <div class="absolute bottom-0 w-64 p-4 border-t border-white/10">
        <div class="flex items-center justify-between">
            <span class="text-sm">{{ Auth::user()->name ?? 'Admin' }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm bg-red-600 hover:bg-red-800 px-2 py-1 rounded">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</aside>
