<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-2xl text-warm-900 leading-tight">Pemesanan Tiket</h2>
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('packages') }}" class="inline-flex items-center px-3 py-2 rounded-md border border-warm-300 text-warm-800 bg-white hover:bg-warm-50 focus:outline-none focus:ring-2 focus:ring-brand-accent-500">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                Go Back
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white ring-1 ring-warm-200 shadow-sm sm:rounded-lg p-6">
        <h1 class="font-display text-2xl text-warm-900 mb-1">Pemesanan Tiket Pura Lempuyang</h1>
        <p class="text-sm text-warm-700 mb-4">Silakan lengkapi detail kunjungan Anda.</p>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('booking.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-warm-800 mb-1">Jenis Tiket</label>
                <select name="ticket_id" class="w-full rounded-md border-warm-300 focus:border-brand-accent-500 focus:ring-brand-accent-500">
                    @php $selected = old('ticket_id', request('ticket_id')); @endphp
                    @foreach ($tickets as $ticket)
                        <option value="{{ $ticket->id }}" @selected($selected == $ticket->id)>
                            {{ $ticket->name }} - Rp {{ number_format($ticket->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('ticket_id')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-warm-800 mb-1">Tanggal Kunjungan</label>
                <input type="date" name="visit_date" value="{{ old('visit_date') }}" class="w-full rounded-md border-warm-300 focus:border-brand-accent-500 focus:ring-brand-accent-500">
                @error('visit_date')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-warm-800 mb-1">Jumlah Tiket</label>
                <input type="number" name="quantity" min="1" max="10" value="{{ old('quantity', 1) }}" class="w-full rounded-md border-warm-300 focus:border-brand-accent-500 focus:ring-brand-accent-500">
                @error('quantity')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-warm-800 mb-1">Nama Kontak</label>
                    <input type="text" name="contact_name" value="{{ old('contact_name') }}" class="w-full rounded-md border-warm-300 focus:border-brand-accent-500 focus:ring-brand-accent-500">
                    @error('contact_name')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-warm-800 mb-1">Email Kontak</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email') }}" class="w-full rounded-md border-warm-300 focus:border-brand-accent-500 focus:ring-brand-accent-500">
                    @error('contact_email')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-warm-800 mb-1">No. Telepon</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone') }}" class="w-full rounded-md border-warm-300 focus:border-brand-accent-500 focus:ring-brand-accent-500">
                    @error('contact_phone')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-warm-800 mb-1">Catatan</label>
                <textarea name="notes" rows="3" class="w-full rounded-md border-warm-300 focus:border-brand-accent-500 focus:ring-brand-accent-500">{{ old('notes') }}</textarea>
            </div>
            <div class="flex items-center justify-between">
                <a href="{{ route('booking.history') }}" class="text-warm-700 hover:text-warm-900 underline">Riwayat Pemesanan</a>
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-md bg-brand-primary-600 text-white hover:bg-brand-primary-700 focus:outline-none focus:ring-2 focus:ring-brand-accent-500">Pesan Sekarang</button>
            </div>
        </form>
    </div>
    <p class="text-xs text-warm-600 mt-3">Form responsif untuk desktop dan mobile.</p>
    
    </div>
</x-app-layout>
