<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Pemesanan</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        <h1 class="text-2xl font-semibold mb-4">Riwayat Pemesanan</h1>
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="p-2">Tanggal</th>
                        <th class="p-2">Kode</th>
                        <th class="p-2">Tiket</th>
                        <th class="p-2">Jumlah</th>
                        <th class="p-2">Total</th>
                        <th class="p-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr class="border-b">
                            <td class="p-2">{{ $booking->visit_date->format('d M Y') }}</td>
                            <td class="p-2 font-mono">{{ $booking->booking_code }}</td>
                            <td class="p-2">{{ $booking->ticket->name }}</td>
                            <td class="p-2">{{ $booking->quantity }}</td>
                            <td class="p-2">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</td>
                            <td class="p-2 capitalize">{{ $booking->status }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-4 text-center text-gray-500">Belum ada pemesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $bookings->links() }}</div>
        <div class="mt-4"><a href="{{ route('booking.index') }}" class="text-blue-600">Buat Pemesanan</a></div>
    </div>
</x-app-layout>
