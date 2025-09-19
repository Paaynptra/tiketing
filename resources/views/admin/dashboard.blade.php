<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
            <form method="GET" class="flex items-center gap-2">
                <label class="text-sm text-gray-600">Rentang</label>
                <select name="range" class="border rounded p-1 text-sm" onchange="this.form.submit()">
                    <option value="day" @selected($range==='day')>Hari ini</option>
                    <option value="month" @selected($range==='month')>Bulan ini</option>
                    <option value="year" @selected($range==='year')>Tahun ini</option>
                    <option value="all" @selected($range==='all')>Semua</option>
                </select>
            </form>
        </div>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Admin Dashboard</h1>
    @if (session('success'))
        <div class="mb-4 max-w-6xl mx-auto p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-gray-500 text-sm">Total Pendapatan</div>
            <div class="text-2xl font-bold">Rp {{ number_format($revenueTotal, 0, ',', '.') }}</div>
            <div class="text-xs text-gray-500 mt-1">Status: confirmed & checked_in</div>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-gray-500 text-sm">Tiket Terjual</div>
            <div class="text-2xl font-bold">{{ $ticketsSold }}</div>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-gray-500 text-sm">Total Pengguna</div>
            <div class="text-2xl font-bold">{{ $totalUsers }}</div>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-gray-500 text-sm">Booking Pending</div>
            <div class="text-2xl font-bold">{{ $pendingBookings }}</div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">Pemesanan Terbaru</h2>
            <a href="{{ route('admin.reports') }}" class="text-blue-600">Laporan</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead><tr class="text-left border-b">
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Kode</th>
                    <th class="p-2">Pengguna</th>
                    <th class="p-2">Tiket</th>
                    <th class="p-2">Qty</th>
                    <th class="p-2">Total</th>
                    <th class="p-2">Status</th>
                </tr></thead>
                <tbody>
                @foreach ($recent as $b)
                    <tr class="border-b">
                        <td class="p-2">{{ $b->visit_date->format('d M Y') }}</td>
                        <td class="p-2 font-mono">{{ $b->booking_code }}</td>
                        <td class="p-2">{{ optional($b->user)->name }}</td>
                        <td class="p-2">{{ optional($b->ticket)->name }}</td>
                        <td class="p-2">{{ $b->quantity }}</td>
                        <td class="p-2">Rp {{ number_format($b->total_amount, 0, ',', '.') }}</td>
                        <td class="p-2 capitalize">
                            <form method="POST" action="{{ route('admin.bookings.status', $b) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="border rounded p-1 text-sm">
                                    @foreach (['pending','confirmed','cancelled','checked_in'] as $st)
                                        <option value="{{ $st }}" @selected($b->status === $st)>{{ ucfirst(str_replace('_',' ', $st)) }}</option>
                                    @endforeach
                                </select>
                                <button class="bg-indigo-600 text-white px-2 py-1 rounded text-xs">Ubah</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
</x-admin-layout>
