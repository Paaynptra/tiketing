<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-semibold text-2xl text-gray-800">Pesanan Tiket</h2>
            <form method="GET" class="flex items-center gap-3 bg-white border border-gray-200 rounded-lg px-3 py-2 shadow-sm">
                <label class="text-sm text-gray-700 font-medium">Filter Status:</label>
                <select name="status" class="border-gray-300 rounded-md text-sm px-2 py-1 focus:ring-indigo-500 focus:border-indigo-500" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    @foreach (['pending','confirmed','cancelled','checked_in'] as $st)
                        <option value="{{ $st }}" @selected($status===$st)>{{ ucfirst(str_replace('_',' ', $st)) }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-md bg-green-50 border border-green-200 text-green-700 text-base shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <table class="w-full text-sm text-gray-800">
                <thead class="bg-gray-200 border-b text-gray-800 uppercase text-xs font-semibold tracking-wide">
                    <tr>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Kode</th>
                        <th class="px-4 py-3 text-left">Pengguna</th>
                        <th class="px-4 py-3 text-left">Tiket</th>
                        <th class="px-4 py-3 text-center">Qty</th>
                        <th class="px-4 py-3 text-left">Total</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($orders as $b)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $b->visit_date->format('d M Y') }}</td>
                            <td class="px-4 py-3 font-mono text-indigo-700 font-semibold">{{ $b->booking_code }}</td>
                            <td class="px-4 py-3">{{ optional($b->user)->name }}</td>
                            <td class="px-4 py-3">{{ optional($b->ticket)->name }}</td>
                            <td class="px-4 py-3 text-center font-medium">{{ $b->quantity }}</td>
                            <td class="px-4 py-3 font-semibold text-green-700">Rp {{ number_format($b->total_amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-300',
                                        'confirmed' => 'bg-green-100 text-green-800 border border-green-300',
                                        'cancelled' => 'bg-red-100 text-red-800 border border-red-300',
                                        'checked_in' => 'bg-blue-100 text-blue-800 border border-blue-300',
                                    ];
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-md {{ $statusColors[$b->status] ?? 'bg-gray-100 text-gray-800 border border-gray-300' }}">
                                    {{ ucfirst(str_replace('_',' ', $b->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <form method="POST" action="{{ route('admin.bookings.status', $b) }}" class="flex items-center justify-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="border-gray-300 rounded-md text-xs px-2 py-1 focus:ring-indigo-500 focus:border-indigo-500">
                                        @foreach (['pending','confirmed','cancelled','checked_in'] as $st)
                                            <option value="{{ $st }}" @selected($b->status === $st)>{{ ucfirst(str_replace('_',' ', $st)) }}</option>
                                        @endforeach
                                    </select>
                                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-md text-xs shadow">
                                        Simpan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4 border-t bg-gray-50">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
