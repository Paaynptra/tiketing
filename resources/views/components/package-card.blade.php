@props(['ticket'])
@php $isAuth = auth()->check(); @endphp
<div class="group relative overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-warm-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:ring-brand-gold-500">
    <div class="absolute inset-0 pointer-events-none opacity-5 bg-[radial-gradient(120%_80%_at_20%_20%,#10B981_0%,transparent_35%),radial-gradient(100%_70%_at_80%_0%,#F59E0B_0%,transparent_30%)]"></div>

    <!-- Image banner -->
    <div class="relative aspect-[16/9] bg-warm-100 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1528164344705-47542687000d?q=80&w=1600&auto=format&fit=crop" alt="{{ $ticket->name }} — Pura Lempuyang" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-[1.03]" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
    </div>

    <div class="relative p-6 flex flex-col gap-4">
        <header class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h3 class="font-display text-2xl text-warm-900 truncate">{{ $ticket->name }}</h3>
                <p class="mt-1 text-warm-600 text-sm">{{ $ticket->description }}</p>
            </div>
            <span class="shrink-0 inline-flex items-center gap-1 rounded-full border border-warm-300 px-2 py-1 text-[10px] uppercase tracking-widest text-warm-700 bg-warm-50 shadow-inner">NFC</span>
        </header>

        <div class="flex items-end justify-between gap-4">
            <div class="flex items-baseline gap-2">
                <div class="text-3xl font-semibold text-warm-900">Rp {{ number_format($ticket->price, 0, ',', '.') }}</div>
                <span class="text-xs text-warm-600">/{{ __('home.per_person') }}</span>
            </div>
            <div class="relative">
                <div class="bg-white p-2 rounded-md ring-1 ring-warm-200 transition-transform duration-300 group-hover:rotate-1">
                    <svg aria-hidden="true" class="w-16 h-16 text-warm-700" viewBox="0 0 48 48" fill="none" stroke="currentColor">
                        <rect x="6" y="6" width="36" height="36" rx="4" ry="4" stroke-width="2"/>
                        <path d="M12 20h24M12 28h24M20 12v24M28 12v24" stroke-width="2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="relative rounded-lg bg-warm-50 ring-1 ring-warm-200 p-4">
            <p class="text-xs text-warm-600">{{ __('home.includes') }}:</p>
            <ul class="mt-1 text-sm text-warm-800 grid grid-cols-2 gap-x-4 gap-y-1">
                <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-primary-600"></span>{{ __('home.entry') }}</li>
                <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-gold-500"></span>{{ __('home.photo_spot') }}</li>
            </ul>
        </div>

        <footer class="flex items-center justify-between">
            @if ($isAuth)
                <a href="{{ route('booking.index', ['ticket_id' => $ticket->id]) }}" class="inline-flex items-center px-4 py-2 rounded-md bg-brand-primary-600 text-white text-sm hover:bg-brand-primary-700 focus:outline-none focus:ring-2 focus:ring-brand-accent-500">{{ __('home.select') }}</a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-md bg-warm-900 text-white text-sm hover:bg-warm-800 focus:outline-none focus:ring-2 focus:ring-brand-accent-500">{{ __('Login') }}</a>
            @endif
            <span class="text-xs text-warm-600">{{ __('home.limited_quota') }}</span>
        </footer>
    </div>
</div>
