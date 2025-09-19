<nav class="bg-indigo-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-14">
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.dashboard') }}" class="font-semibold">Admin Panel</a>
                <a href="{{ route('admin.dashboard') }}" class="hover:underline {{ request()->routeIs('admin.dashboard') ? 'underline' : '' }}">Dashboard</a>
                <a href="{{ route('admin.orders.index') }}" class="hover:underline {{ request()->routeIs('admin.orders.*') ? 'underline' : '' }}">Pesanan</a>
                <a href="{{ route('admin.users.index') }}" class="hover:underline {{ request()->routeIs('admin.users.*') ? 'underline' : '' }}">Pengguna</a>
                <a href="{{ route('admin.reports') }}" class="hover:underline {{ request()->routeIs('admin.reports') ? 'underline' : '' }}">Laporan</a>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm hidden sm:inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-white/10 hover:bg-white/20 px-3 py-1 rounded text-sm">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</nav>
