<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-display text-2xl text-warm-900 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-warm-300 text-warm-800 rounded-md hover:bg-warm-50 focus:outline-none focus:ring-2 focus:ring-brand-accent-500">
                        {{ __('Logout') }}
                    </button>
                </form>
            @endauth
        </div>
    </x-slot>

    @php
        $totalSales = \App\Models\Booking::where('status','confirmed')->sum('total_amount');
        $todayVisits = \App\Models\Booking::whereDate('visit_date', now()->toDateString())->count();
        $activeTickets = \App\Models\Ticket::where('active', true)->count();
        $pending = \App\Models\Booking::where('status','pending')->count();
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="bg-white ring-1 ring-warm-200 rounded-md p-4 shadow-sm">
                    <div class="text-sm text-warm-600">{{ __('Total Penjualan (Confirmed)') }}</div>
                    <div class="mt-1 text-2xl font-semibold text-warm-900">Rp {{ number_format($totalSales,0,',','.') }}</div>
                </div>
                <div class="bg-white ring-1 ring-warm-200 rounded-md p-4 shadow-sm">
                    <div class="text-sm text-warm-600">{{ __('Kunjungan Hari Ini') }}</div>
                    <div class="mt-1 text-2xl font-semibold text-warm-900">{{ $todayVisits }}</div>
                </div>
                <div class="bg-white ring-1 ring-warm-200 rounded-md p-4 shadow-sm">
                    <div class="text-sm text-warm-600">{{ __('Paket Aktif') }}</div>
                    <div class="mt-1 text-2xl font-semibold text-warm-900">{{ $activeTickets }}</div>
                </div>
                <div class="bg-white ring-1 ring-warm-200 rounded-md p-4 shadow-sm">
                    <div class="text-sm text-warm-600">{{ __('Pending Orders') }}</div>
                    <div class="mt-1 text-2xl font-semibold text-warm-900">{{ $pending }}</div>
                </div>
            </div>

            <div class="mt-8 bg-white ring-1 ring-warm-200 overflow-hidden shadow-sm rounded-md">
                <div class="p-6">
                    <h3 class="font-display text-xl text-warm-900">{{ __('Riwayat Terbaru') }}</h3>
                    @php
                        $recent = \App\Models\Booking::with('ticket','user')->latest()->take(8)->get();
                    @endphp
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left border-b border-warm-200 text-warm-700">
                                    <th class="p-2">{{ __('Tanggal') }}</th>
                                    <th class="p-2">{{ __('Kode') }}</th>
                                    <th class="p-2">{{ __('Pengguna') }}</th>
                                    <th class="p-2">{{ __('Paket') }}</th>
                                    <th class="p-2">{{ __('Qty') }}</th>
                                    <th class="p-2">{{ __('Total') }}</th>
                                    <th class="p-2">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recent as $b)
                                    <tr class="border-b border-warm-200 text-warm-800">
                                        <td class="p-2">{{ optional($b->visit_date)->format('d M Y') }}</td>
                                        <td class="p-2 font-mono">{{ $b->booking_code }}</td>
                                        <td class="p-2">{{ optional($b->user)->name }}</td>
                                        <td class="p-2">{{ optional($b->ticket)->name }}</td>
                                        <td class="p-2">{{ $b->quantity }}</td>
                                        <td class="p-2">Rp {{ number_format($b->total_amount,0,',','.') }}</td>
                                        <td class="p-2 capitalize">{{ $b->status }}</td>
                                    </tr>
                                @empty
                                    <tr><td class="p-4 text-warm-600" colspan="7">{{ __('Belum ada data') }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid gap-6 md:grid-cols-2">
                <div class="bg-white ring-1 ring-warm-200 rounded-md shadow-sm p-4">
                    <h4 class="font-semibold text-warm-900">{{ __('Informasi Kunjungan & Etika') }}</h4>
                    <ul class="mt-2 text-sm text-warm-700 list-disc list-inside">
                        <li>{{ __('Gunakan pakaian sopan (kamen/selendang bila perlu).') }}</li>
                        <li>{{ __('Hormati aktivitas keagamaan dan jaga ketenangan.') }}</li>
                        <li>{{ __('Datang sesuai slot waktu yang dipilih.') }}</li>
                    </ul>
                </div>
                <div class="bg-white ring-1 ring-warm-200 rounded-md shadow-sm p-4">
                    <h4 class="font-semibold text-warm-900">{{ __('Jam Operasional') }}</h4>
                    <p class="mt-1 text-sm text-warm-700">{{ __('Setiap hari 06.00–18.00 WITA (Asia/Makassar)') }}</p>
                    <a href="https://maps.google.com/?q=Pura+Lempuyang" target="_blank" class="inline-flex items-center mt-3 px-3 py-2 bg-brand-primary-600 text-white rounded-md hover:bg-brand-primary-700 focus:outline-none focus:ring-2 focus:ring-brand-accent-500">{{ __('Lihat di Google Maps') }}</a>
                </div>
            </div>

            <!-- Gallery + Book Now CTA (Animated Carousel with Thumbnails) -->
            <section class="mt-10">
                <div class="flex items-center justify-between">
                    <h3 class="font-display text-xl text-warm-900">{{ __('Pura Lempuyang Gallery') }}</h3>
                    <a href="{{ route('packages') }}" class="inline-flex items-center px-4 py-2 rounded-md bg-brand-primary-600 text-white text-sm hover:bg-brand-primary-700 focus:outline-none focus:ring-2 focus:ring-brand-accent-500">{{ __('home.book_now') ?? __('Book Now') }}</a>
                </div>

                <div class="mt-4" x-data="{
                        images: [
                            {src: 'https://images.unsplash.com/photo-1528164344705-47542687000d?q=80&w=1600&auto=format&fit=crop', alt: 'Gerbang Pura Lempuyang & Gunung Agung'},
                            {src: 'https://images.unsplash.com/photo-1558980664-10eb5e3102b5?q=80&w=1600&auto=format&fit=crop', alt: 'Tangga menuju area suci'},
                            {src: 'https://images.unsplash.com/photo-1558980823-0da3d51b3101?q=80&w=1600&auto=format&fit=crop', alt: 'Panorama pegunungan Bali'},
                            {src: 'https://images.unsplash.com/photo-1548013146-72479768bada?q=80&w=1600&auto=format&fit=crop', alt: 'Silhouette di sore hari'},
                            {src: 'https://images.unsplash.com/photo-1505764706515-aa95265c5abc?q=80&w=1600&auto=format&fit=crop', alt: 'Awan dan puncak gunung'},
                            {src: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=1600&auto=format&fit=crop', alt: 'Langit biru di pelataran pura'}
                        ],
                        i: 0,
                        playing: true,
                        interval: null,
                        next(){ this.i = (this.i + 1) % this.images.length },
                        prev(){ this.i = (this.i - 1 + this.images.length) % this.images.length },
                        go(k){ this.i = k },
                        start(){ this.interval = setInterval(() => { if (this.playing) this.next() }, 4000) },
                        stop(){ if(this.interval) clearInterval(this.interval) },
                        init(){ this.start() },
                    }"
                    @mouseenter="playing=false" @mouseleave="playing=true"
                    @keydown.arrow-right.prevent="next()" @keydown.arrow-left.prevent="prev()"
                    tabindex="0" role="region" aria-label="Lempuyang gallery">

                    <!-- Slider -->
                    <div class="relative h-64 md:h-80 lg:h-96 rounded-lg overflow-hidden ring-1 ring-warm-200">
                        <template x-for="(img, idx) in images" :key="idx">
                            <div x-show="i === idx" x-transition.opacity.duration.500ms class="absolute inset-0">
                                <img :src="img.src" :alt="img.alt" loading="lazy" class="w-full h-full object-cover" />
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/50 to-transparent text-white p-3 text-sm">
                                    <span x-text="img.alt"></span>
                                </div>
                            </div>
                        </template>

                        <!-- Controls -->
                        <button type="button" @click="prev()" aria-label="Previous" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-warm-900 rounded-full p-2 shadow focus:outline-none focus:ring-2 focus:ring-brand-accent-500">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                        </button>
                        <button type="button" @click="next()" aria-label="Next" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-warm-900 rounded-full p-2 shadow focus:outline-none focus:ring-2 focus:ring-brand-accent-500">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                        </button>
                    </div>

                    <!-- Thumbnails -->
                    <div class="mt-3 grid grid-cols-6 gap-2">
                        <template x-for="(img, idx) in images" :key="'thumb-'+idx">
                            <button type="button" @click="go(idx)" :aria-label="'Go to slide ' + (idx+1)"
                                    class="relative rounded-md overflow-hidden ring-1 ring-warm-200 focus:outline-none focus:ring-2 focus:ring-brand-accent-500"
                                    :class="{'ring-2 ring-brand-gold-500': i === idx}">
                                <img :src="img.src" :alt="img.alt" loading="lazy" class="w-full h-12 object-cover" />
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5" :class="{'bg-black/10': i !== idx}"></div>
                            </button>
                        </template>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
