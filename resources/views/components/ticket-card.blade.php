@props(['ticket'])
<a href="{{ route('booking.index', ['ticket_id' => $ticket->id]) }}" aria-label="{{ __('home.book_package', ['name' => $ticket->name]) }}"
   class="group block focus:outline-none focus:ring-2 focus:ring-brand-accent-500 rounded-2xl">
    <article class="relative overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-warm-200 transition-all duration-300
                    group-hover:-translate-y-1 group-hover:shadow-lg group-hover:ring-brand-gold-500">
        <div class="absolute inset-0 pointer-events-none">
            <div class="opacity-5 bg-[radial-gradient(120%_80%_at_20%_20%,#10B981_0%,transparent_35%),radial-gradient(100%_70%_at_80%_0%,#F59E0B_0%,transparent_30%)] w-full h-full"></div>
        </div>

        <div class="relative p-5 sm:p-6 flex flex-col gap-4">
            <header class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <h3 class="font-display text-xl sm:text-2xl text-warm-900 truncate">{{ $ticket->name }}</h3>
                    <p class="mt-1 text-warm-600 text-xs sm:text-sm truncate hidden xs:block">{{ Str::limit($ticket->description, 90) }}</p>
                </div>
                <span class="shrink-0 inline-flex items-center gap-1 rounded-full border border-warm-300 px-2 py-1 text-[10px] uppercase tracking-widest text-warm-700 bg-warm-50 shadow-inner">NFC</span>
            </header>

            <div class="flex items-end justify-between gap-4">
                <div class="flex items-baseline gap-2">
                    <div class="text-2xl md:text-3xl font-semibold text-warm-900">Rp {{ number_format($ticket->price, 0, ',', '.') }}</div>
                    <span class="text-[11px] md:text-xs text-warm-600">/{{ __('home.per_person') }}</span>
                </div>
                <div class="relative">
                    <div class="bg-white p-1.5 sm:p-2 rounded-md ring-1 ring-warm-200 transition-transform duration-300 group-hover:rotate-1">
                        <svg aria-hidden="true" class="w-12 h-12 sm:w-16 sm:h-16 text-warm-700" viewBox="0 0 48 48" fill="none" stroke="currentColor">
                            <rect x="6" y="6" width="36" height="36" rx="4" ry="4" stroke-width="2"/>
                            <path d="M12 20h24M12 28h24M20 12v24M28 12v24" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="relative rounded-lg bg-warm-50 ring-1 ring-warm-200 p-3 sm:p-4">
                <p class="text-xs text-warm-600">{{ __('home.includes') }}:</p>
                <ul class="mt-1 text-xs sm:text-sm text-warm-800 grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-1">
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-primary-600"></span>{{ __('home.entry') }}</li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-gold-500"></span>{{ __('home.photo_spot') }}</li>
                </ul>
            </div>

            <footer class="flex items-center justify-between">
                <span class="inline-flex items-center px-3 sm:px-4 py-2 rounded-md bg-brand-primary-600 text-white text-xs sm:text-sm transition-colors duration-200
                               group-hover:bg-brand-primary-700">{{ __('home.select') }}</span>
                <span class="text-[11px] sm:text-xs text-warm-600">{{ __('home.limited_quota') }}</span>
            </footer>
        </div>

        <div class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
             aria-hidden="true">
            <div class="absolute -inset-x-10 -bottom-10 h-40 bg-gradient-to-t from-brand-accent-200/30 to-transparent"></div>
        </div>
    </article>
</a>
