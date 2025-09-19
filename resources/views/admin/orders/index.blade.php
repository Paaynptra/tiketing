<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesanan Tiket</h2>
            <form method="GET" class="flex items-center gap-2">
                <label class="text-sm text-gray-600">Status</label>
                <select name="status" class="border rounded p-1 text-sm" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    @foreach (['pending','confirmed','cancelled','checked_in'] as $st)
                        <option value="{{ $st }}" @selected($status===$st)>{{ ucfirst(str_replace('_',' ', $st)) }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded shadow p-4 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                <tr class="text-left border-b">
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Kode</h2>
                    <th class="p-2">Pengguna</th>
                    <th class="p-2">Tiket</th>
                    <th class="p-2">Qty</th>
                    <th class="p-2">Total</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $b)
                    <tr class="border-b">
                        <td class="p-2">{{ $b->visit_date->format('d M Y') }}</td>
                        <td class="p-2 font-mono">{{ $b->booking_code }}</td>
                        <td class="p-2">{{ optional($b->user)->name }}</td>
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
            <div class="mt-4">{{ $orders->links() }}</div>
        </div>
    </div>
</x-admin-layout>

