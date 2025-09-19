<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Kunjungan</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Laporan Kunjungan</h1>
    <form method="GET" class="bg-white dark:bg-gray-800 rounded shadow p-4 mb-4 grid grid-cols-1 md:grid-cols-4 gap-3">
        <div>
            <label class="block text-sm">Dari</label>
            <input type="date" name="start_date" value="{{ $start }}" class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm">Sampai</label>
            <input type="date" name="end_date" value="{{ $end }}" class="w-full border rounded p-2">
        </div>
        <div class="flex items-end">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Terapkan</button>
        </div>
        <div class="flex items-end">
            <div class="p-2 bg-gray-50 dark:bg-gray-900 rounded w-full">
                <div class="text-xs text-gray-500">Ringkasan</div>
                <div class="flex gap-4 text-sm">
                    <div>Booking: <strong>{{ $totals['bookings'] }}</strong></div>
                    <div>Pengunjung: <strong>{{ $totals['visitors'] }}</strong></div>
                    <div>Pendapatan: <strong>Rp {{ number_format($totals['revenue'], 0, ',', '.') }}</strong></div>
                </div>
            </div>
        </div>
    </form>

    @if (session('success'))
        <div class="mb-4 max-w-6xl mx-auto p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="p-2">Tanggal</th>
                        <th class="p-2">Kode</th>
                        <th class="p-2">Tiket</th>
                        <th class="p-2">Qty</th>
                        <th class="p-2">Total</th>
                        <th class="p-2">Status</th>
                        <th class="p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $b)
                        <tr class="border-b">
                            <td class="p-2">{{ $b->visit_date->format('d M Y') }}</td>
                            <td class="p-2 font-mono">{{ $b->booking_code }}</td>
                            <td class="p-2">{{ optional($b->ticket)->name }}</td>
                            <td class="p-2">{{ $b->quantity }}</td>
                            <td class="p-2">Rp {{ number_format($b->total_amount, 0, ',', '.') }}</td>
                            <td class="p-2 capitalize">{{ $b->status }}</td>
                            <td class="p-2">
                                <form method="POST" action="{{ route('admin.bookings.status', $b) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="border rounded p-1 text-sm">
                                        @foreach (['pending','confirmed','cancelled','checked_in'] as $st)
                                            <option value="{{ $st }}" @selected($b->status === $st)>{{ ucfirst(str_replace('_',' ', $st)) }}</option>
                                        @endforeach
                                    </select>
                                    <button class="bg-indigo-600 text-white px-2 py-1 rounded text-xs">Simpan</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $bookings->links() }}</div>
    </div>
    </div>
</x-admin-layout>
