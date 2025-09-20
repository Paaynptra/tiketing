<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-2xl text-warm-900 leading-tight">Pemesanan Tiket</h2>
        </div>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white ring-1 ring-green-400 shadow-lg sm:rounded-lg p-8 relative overflow-hidden">

            <!-- Logo / Placeholder -->
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-md">
                    <span class="text-white font-bold text-lg">LOGO</span>
                </div>
            </div>

            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="font-display text-3xl text-warm-900 mb-2">Pemesanan Tiket Pura Lempuyang</h1>
                <p class="text-sm text-warm-600">Silakan lengkapi detail kunjungan Anda dengan benar.</p>
            </div>

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('booking.store') }}" class="space-y-6">
                @csrf

                <!-- Jenis Tiket + Tanggal + Jumlah -->
                <div class="border border-green-400 p-4 rounded-lg bg-warm-50 space-y-4">
                    <!-- Jenis Tiket -->
                    <div>
                        <label class="block text-sm font-medium text-warm-800 mb-1">Jenis Tiket</label>
                        <select name="ticket_id" class="w-full rounded-md border-warm-300 focus:border-green-500 focus:ring-green-500">
                            @php $selected = old('ticket_id', request('ticket_id')); @endphp
                            @foreach ($tickets as $ticket)
                                <option value="{{ $ticket->id }}" @selected($selected == $ticket->id)>
                                    {{ $ticket->name }} - Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('ticket_id')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-sm font-medium text-warm-800 mb-1">Tanggal Kunjungan</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400">
                                <!-- Icon Calendar -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 9h18M4.5 7.5h15a1.5 1.5 0 011.5 1.5v9.75a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18.75V9z"/>
                                </svg>
                            </span>
                            <input type="date" name="visit_date" value="{{ old('visit_date') }}"
                                   class="w-full pl-10 rounded-md border-warm-300 focus:border-green-500 focus:ring-green-500">
                        </div>
                        @error('visit_date')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                    </div>

                    <!-- Jumlah Tiket -->
                    <div>
                        <label class="block text-sm font-medium text-warm-800 mb-1">Jumlah Tiket</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400">
                                <!-- Icon Ticket -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5M3.75 15h16.5M9 3.75v16.5M15 3.75v16.5"/>
                                </svg>
                            </span>
                            <input type="number" name="quantity" min="1" max="10" value="{{ old('quantity', 1) }}"
                                   class="w-full pl-10 rounded-md border-warm-300 focus:border-green-500 focus:ring-green-500">
                        </div>
                        @error('quantity')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Kontak (VERTIKAL) -->
                <div class="border border-green-400 p-4 rounded-lg bg-warm-50 space-y-4">
                    <h2 class="text-lg font-semibold text-warm-900 mb-3">Data Kontak</h2>

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-warm-800 mb-1">Nama Kontak</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400">
                                <!-- Icon User -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 1115 0v.75H4.5v-.75z"/>
                                </svg>
                            </span>
                            <input type="text" name="contact_name" value="{{ old('contact_name') }}"
                                   class="w-full pl-10 rounded-md border-warm-300 focus:border-green-500 focus:ring-green-500">
                        </div>
                        @error('contact_name')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-warm-800 mb-1">Email Kontak</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400">
                                <!-- Icon Mail -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 5.25v13.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V5.25m19.5 0L12 12.75M2.25 5.25L12 12.75m0 0l9.75-7.5"/>
                                </svg>
                            </span>
                            <input type="email" name="contact_email" value="{{ old('contact_email') }}"
                                   class="w-full pl-10 rounded-md border-warm-300 focus:border-green-500 focus:ring-green-500">
                        </div>
                        @error('contact_email')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label class="block text-sm font-medium text-warm-800 mb-1">No. Telepon</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400">
                                <!-- Icon Phone -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 00-.75.75v.75a12 12 0 01-12-12v-.75a.75.75 0 00-.75-.75H4.5a2.25 2.25 0 00-2.25 2.25v.75z"/>
                                </svg>
                            </span>
                            <input type="text" name="contact_phone" value="{{ old('contact_phone') }}"
                                   class="w-full pl-10 rounded-md border-warm-300 focus:border-green-500 focus:ring-green-500">
                        </div>
                        @error('contact_phone')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Catatan -->
                <div class="border border-green-400 p-4 rounded-lg bg-warm-50">
                    <label class="block text-sm font-medium text-warm-800 mb-1">Catatan</label>
                    <textarea name="notes" rows="3"
                              class="w-full rounded-md border-warm-300 focus:border-green-500 focus:ring-green-500">{{ old('notes') }}</textarea>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-green-400">
                    <a href="{{ route('dashboard') }}" class="text-green-700 hover:text-green-900 underline">Kembali Keberanda</a>
                    <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 rounded-md bg-green-600 text-white font-semibold shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Pesan Sekarang
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
