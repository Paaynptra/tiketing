<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-2xl text-warm-900 leading-tight">
                {{ __('home.packages') }}
            </h2>
            <a href="{{ route('home') }}" class="inline-flex items-center px-3 py-2 rounded-md border border-warm-300 text-warm-800 bg-white hover:bg-warm-50 focus:outline-none focus:ring-2 focus:ring-brand-accent-500">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12l9-8 9 8"/><path d="M9 21V9h6v12"/></svg>
                Home
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            <p class="text-warm-700 max-w-3xl">{{ __('Pilih paket kunjungan yang sesuai. Untuk memesan, Anda perlu masuk terlebih dahulu.') }}</p>
            <div class="mt-6 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($tickets as $ticket)
                    <x-package-card :ticket="$ticket" />
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
