<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pemesanan Tiket</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        <h1 class="text-2xl font-semibold mb-4">Pemesanan Tiket Pura Lempuyang</h1>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('booking.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Jenis Tiket</label>
                <select name="ticket_id" class="w-full border rounded p-2">
                    @foreach ($tickets as $ticket)
                        <option value="{{ $ticket->id }}">{{ $ticket->name }} - Rp {{ number_format($ticket->price, 0, ',', '.') }}</option>
                    @endforeach
                </select>
                @error('ticket_id')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Kunjungan</label>
                <input type="date" name="visit_date" value="{{ old('visit_date') }}" class="w-full border rounded p-2">
                @error('visit_date')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Jumlah Tiket</label>
                <input type="number" name="quantity" min="1" max="10" value="{{ old('quantity', 1) }}" class="w-full border rounded p-2">
                @error('quantity')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Kontak</label>
                    <input type="text" name="contact_name" value="{{ old('contact_name') }}" class="w-full border rounded p-2">
                    @error('contact_name')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email Kontak</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email') }}" class="w-full border rounded p-2">
                    @error('contact_email')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">No. Telepon</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone') }}" class="w-full border rounded p-2">
                    @error('contact_phone')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Catatan</label>
                <textarea name="notes" rows="3" class="w-full border rounded p-2">{{ old('notes') }}</textarea>
            </div>
            <div class="flex items-center justify-between">
                <a href="{{ route('booking.history') }}" class="text-blue-600">Riwayat Pemesanan</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Pesan Sekarang</button>
            </div>
        </form>
    </div>
    <p class="text-xs text-gray-500 mt-3">Form responsif untuk desktop dan mobile.</p>
    
    </div>
</x-app-layout>
