<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">QR Code Pemesanan</h2>
    </x-slot>

    <div class="py-6 max-w-md mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 text-center">
            <h1 class="text-2xl font-semibold mb-4">Pemesanan {{ $booking->booking_code }}</h1>
            <div class="mb-4">
                <img src="{{ $qr->generateSigned(json_encode([
                    'code' => $booking->booking_code,
                    'ticket' => $booking->ticket->name,
                    'date' => $booking->visit_date->format('d M Y'),
                    'qty' => $booking->quantity,
                ])) }}" alt="QR Code" class="mx-auto" />
            </div>
            <div class="text-left">
                <p><strong>Tiket:</strong> {{ $booking->ticket->name }}</p>
                <p><strong>Tanggal Kunjungan:</strong> {{ $booking->visit_date->format('d M Y') }}</p>
                <p><strong>Jumlah:</strong> {{ $booking->quantity }}</p>
            </div>
            <div class="mt-6">
                <a href="{{ route('booking.history') }}" class="text-blue-600">Kembali ke Riwayat</a>
            </div>
        </div>
    </div>
</x-app-layout>
