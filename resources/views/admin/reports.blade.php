<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Kunjungan</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">

        <!-- Filter Form -->
        <form method="GET" class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Dari</label>
                <input type="date" name="start_date" value="{{ $start }}"
                       class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md p-2 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
    <div>
    <label class="block text-sm font-medium text-gray-600 mb-1">Sampai</label>
    <input type="date" name="end_date" value="{{ $end }}"
           class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md p-2 text-sm focus:ring-2 focus:ring-indigo-500">

    <div class="flex justify-end mt-2">
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
            Terapkan
        </button>
    </div>
</div>

            <div class="flex items-end">
                <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-lg w-full border border-gray-200 dark:border-gray-700">
                    <div class="text-xs text-gray-500">Ringkasan</div>
                    <div class="flex flex-col gap-1 mt-1 text-sm">
                        <div>Booking: <strong>{{ $totals['bookings'] }}</strong></div>
                        <div>Pengunjung: <strong>{{ $totals['visitors'] }}</strong></div>
                        <div>Pendapatan: <strong>Rp {{ number_format($totals['revenue'], 0, ',', '.') }}</strong></div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="mb-4 max-w-6xl mx-auto p-3 bg-green-100 text-green-800 rounded-md shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Data Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-indigo-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 uppercase text-xs font-semibold">
                        <tr>
                            <th class="p-3 text-left">Tanggal</th>
                            <th class="p-3 text-left">Kode</th>
                            <th class="p-3 text-left">Tiket</th>
                            <th class="p-3 text-center">Qty</th>
                            <th class="p-3 text-left">Total</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($bookings as $b)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                                <td class="p-3">{{ $b->visit_date->format('d M Y') }}</td>
                                <td class="p-3 font-mono">{{ $b->booking_code }}</td>
                                <td class="p-3">{{ optional($b->ticket)->name }}</td>
                                <td class="p-3 text-center">{{ $b->quantity }}</td>
                                <td class="p-3">Rp {{ number_format($b->total_amount, 0, ',', '.') }}</td>
                                <td class="p-3 capitalize">
                                    <span class="px-2 py-1 rounded text-xs
                                        @if($b->status === 'confirmed') bg-green-100 text-green-700
                                        @elseif($b->status === 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($b->status === 'cancelled') bg-red-100 text-red-700
                                        @else bg-blue-100 text-blue-700
                                        @endif">
                                        {{ str_replace('_', ' ', ucfirst($b->status)) }}
                                    </span>
                                </td>
                                <td class="p-3 text-center">
                                    <form method="POST" action="{{ route('admin.bookings.status', $b) }}" class="flex items-center justify-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="border-gray-300 dark:border-gray-700 rounded-md p-1 text-xs focus:ring-1 focus:ring-indigo-500">
                                            @foreach (['pending','confirmed','cancelled','checked_in'] as $st)
                                                <option value="{{ $st }}" @selected($b->status === $st)>{{ ucfirst(str_replace('_',' ', $st)) }}</option>
                                            @endforeach
                                        </select>
                                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-2 py-1 rounded text-xs transition">
                                            Simpan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
