<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'E-Tiketing') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans bg-warm-50 text-warm-900">
        <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-50 bg-white text-warm-900 px-3 py-2 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-brand-accent-500">Skip to main content</a>
        <div class="relative min-h-screen">
        @include('layouts.main-navigation')

            <main id="main">
                <!-- Hero -->
                <section class="relative overflow-hidden">
                    <div class="absolute inset-0">
                        <div class="w-full h-full bg-gradient-to-b from-teal-100 via-emerald-50 to-warm-50"></div>
                    </div>
                    <div class="max-w-7xl mx-auto px-4 py-16 md:py-24 relative grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <h1 class="font-display text-4xl md:text-5xl tracking-tight text-warm-900">
                                {{ __('home.hero_title') }}
                            </h1>
                            <p class="mt-4 text-warm-700 leading-relaxed">
                                {{ __('home.hero_subtitle') }}
                            </p>
                            <div class="mt-6 flex gap-3">
                                <a href="{{ route('booking.index') }}" class="inline-flex items-center px-5 py-3 bg-brand-primary-600 text-white rounded-md shadow hover:bg-brand-primary-700 focus:outline-none focus:ring-2 focus:ring-brand-accent-500">{{ __('home.cta') }}</a>
                                <a href="#rules" class="inline-flex items-center px-5 py-3 border border-warm-300 text-warm-800 rounded-md hover:bg-warm-50 focus:outline-none focus:ring-2 focus:ring-brand-accent-500">{{ __('home.learn_more') }}</a>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="aspect-[4/3] rounded-lg overflow-hidden ring-1 ring-warm-200 shadow">
                                <img src="https://images.unsplash.com/photo-1528164344705-47542687000d?q=80&w=1200&auto=format&fit=crop" alt="Pura Lempuyang dengan siluet Gunung Agung saat matahari terbit" class="w-full h-full object-cover" />
                            </div>
                            <p class="sr-only">{{ __('home.hero_image_alt') }}</p>
                        </div>
                    </div>
                </section>

                <!-- Public Gallery (Animated) -->
                <section class="max-w-7xl mx-auto px-4 pt-6 pb-4">
                    <div class="flex items-center">
                        <h3 class="font-display text-xl text-warm-900">{{ __('home.gallery') }}</h3>
                    </div>
                    <div class="mt-3" x-data="{
                            images: [
                                {src: 'https://images.unsplash.com/photo-1528164344705-47542687000d?q=80&w=1600&auto=format&fit=crop', alt: 'Gerbang Pura Lempuyang & Gunung Agung'},
                                {src: 'https://images.unsplash.com/photo-1558980664-10eb5e3102b5?q=80&w=1600&auto=format&fit=crop', alt: 'Tangga menuju area suci'},
                                {src: 'https://images.unsplash.com/photo-1558980823-0da3d51b3101?q=80&w=1600&auto=format&fit=crop', alt: 'Panorama pegunungan Bali'},
                            ],
                            i: 0, playing: true, interval: null,
                            next(){ this.i = (this.i + 1) % this.images.length },
                            prev(){ this.i = (this.i - 1 + this.images.length) % this.images.length },
                            start(){ this.interval = setInterval(() => { if (this.playing) this.next() }, 4000) },
                            stop(){ if(this.interval) clearInterval(this.interval) },
                            init(){ this.start() },
                        }" @mouseenter="playing=false" @mouseleave="playing=true" tabindex="0" role="region" aria-label="Lempuyang gallery">
                        <div class="relative h-56 md:h-72 lg:h-80 rounded-lg overflow-hidden ring-1 ring-warm-200">
                            <template x-for="(img, idx) in images" :key="idx">
                                <div x-show="i === idx" x-transition.opacity.duration.500ms class="absolute inset-0">
                                    <img :src="img.src" :alt="img.alt" loading="lazy" class="w-full h-full object-cover" />
                                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/50 to-transparent text-white p-3 text-sm">
                                        <span>{{ __('home.gallery_caption') }}</span>
                                    </div>
                                </div>
                            </template>
                            <button type="button" @click="prev()" aria-label="Previous" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-warm-900 rounded-full p-2 shadow focus:outline-none focus:ring-2 focus:ring-brand-accent-500">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                            </button>
                            <button type="button" @click="next()" aria-label="Next" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-warm-900 rounded-full p-2 shadow focus:outline-none focus:ring-2 focus:ring-brand-accent-500">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            </button>
                        </div>
                    </div>
                </section>

                <!-- Cards with modal (Stories) -->
                <section class="max-w-7xl mx-auto px-4 pb-10"
                         x-data="{
                            modalOpen: false,
                            current: { title: '', img: '', desc: '', full: '' },
                            open(h){ this.current = h; this.modalOpen = true; this.$nextTick(()=>{ this.$refs.modal && this.$refs.modal.focus(); }); },
                            close(){ this.modalOpen = false; this.current = { title: '', img: '', desc: '', full: '' } }
                         }"
                         x-effect="document.body.classList.toggle('overflow-hidden', modalOpen)"
                         @keydown.escape.window="close()">
                    <h3 class="font-display text-xl text-warm-900">Sorotan</h3>
                    <div class="mt-4 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach(($highlights ?? []) as $h)
                            <article class="group rounded-2xl overflow-hidden bg-white ring-1 ring-warm-200 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                                <button type="button" class="text-left w-full"
                                        data-title="{{ $h['title'] }}"
                                        data-img="{{ $h['img'] }}"
                                        data-desc="{{ $h['desc'] }}"
                                        data-full="{{ $h['full'] }}"
                                        @click="open({ title: $el.dataset.title, img: $el.dataset.img, desc: $el.dataset.desc, full: $el.dataset.full })"
                                        aria-haspopup="dialog" aria-label="Buka detail {{ $h['title'] }}">
                                    <div class="aspect-[16/9] bg-warm-100 overflow-hidden">
                                        <img src="{{ $h['img'] }}" alt="{{ $h['title'] }}" class="w-full h-full object-cover transition duration-300 group-hover:scale-[1.03]" />
                                    </div>
                                    <div class="p-4">
                                        <h4 class="font-semibold text-warm-900">{{ $h['title'] }}</h4>
                                        <p class="text-sm text-warm-700 mt-1">{{ $h['desc'] }}</p>
                                    </div>
                                </button>
                            </article>
                        @endforeach
                    </div>

                    <!-- Modal -->
                    <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4"
                         role="dialog" aria-modal="true" aria-labelledby="storyTitle" aria-describedby="storyBody">
                        <div class="absolute inset-0 bg-black/50" @click="close()" aria-hidden="true"></div>
                        <div x-show="modalOpen" x-transition.scale class="relative bg-white rounded-xl shadow-xl max-w-5xl w-full overflow-hidden ring-1 ring-warm-200"
                             tabindex="-1" x-ref="modal">
                            <div class="relative">
                                <img :src="current.img" :alt="current.title" class="w-full max-h-[70vh] object-cover" />
                                <button type="button" @click="close()" class="absolute top-2 right-2 bg-white/90 hover:bg-white rounded-full p-2 shadow focus:outline-none focus:ring-2 focus:ring-brand-accent-500" aria-label="Tutup">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M6 18L18 6"/></svg>
                                </button>
                            </div>
                            <div class="p-6 md:p-7">
                                <h4 id="storyTitle" class="font-display text-2xl md:text-3xl text-warm-900" x-text="current.title"></h4>
                                <p class="mt-2 text-sm text-warm-700" x-text="current.desc"></p>
                                <p id="storyBody" class="mt-3 text-warm-800 leading-relaxed" x-text="current.full"></p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Packages preview removed per request; see /packages for full listing -->

                <!-- Before You Visit (moved below) -->
                <section id="rules" class="max-w-7xl mx-auto px-4 pb-16">
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-white ring-1 ring-warm-200 rounded-md p-5 shadow-sm">
                            <h3 class="font-display text-xl text-warm-900">{{ __('home.before_visit') }}</h3>
                            <ul class="mt-3 text-sm text-warm-700 space-y-3">
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-brand-primary-600 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 18c4-2 12-2 16 0"/><path d="M6 14c3-1.5 9-1.5 12 0"/><path d="M8 10c2-.8 6-.8 8 0"/><path d="M12 4v2"/></svg>
                                    <span>{{ __('home.rule_dress') }}</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-brand-primary-600 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3l2.09 6.26H20.5l-5.17 3.76L17.4 20 12 15.9 6.6 20l2.07-6.98L3.5 9.26h6.41L12 3z"/></svg>
                                    <span>{{ __('home.rule_respect') }}</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-brand-primary-600 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v6l4 2"/></svg>
                                    <span>{{ __('home.rule_time') }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="bg-white ring-1 ring-warm-200 rounded-md p-5 shadow-sm">
                            <h3 class="font-display text-xl text-warm-900">{{ __('home.hours') }}</h3>
                            <p class="mt-2 text-sm text-warm-700">{{ __('home.hours_desc') }}</p>
                            <a href="https://maps.google.com/?q=Pura+Lempuyang" target="_blank" class="inline-flex items-center mt-3 px-3 py-2 bg-brand-primary-600 text-white rounded-md hover:bg-brand-primary-700 focus:outline-none focus:ring-2 focus:ring-brand-accent-500">
                                <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 12-9 12S3 17 3 10a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ __('home.view_map') }}
                            </a>
                        </div>
                        <div class="bg-white ring-1 ring-warm-200 rounded-md p-5 shadow-sm">
                            <h3 class="font-display text-xl text-warm-900">{{ __('home.tips') }}</h3>
                            <ul class="mt-3 text-sm text-warm-700 space-y-3">
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-brand-gold-500 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="5"/><path d="M12 1v3M12 20v3M4.22 4.22l2.12 2.12M17.66 17.66l2.12 2.12M1 12h3M20 12h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12"/></svg>
                                    <span>{{ __('home.tip_sunrise') }}</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-brand-gold-500 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 18V6l8 6-8 6z"/></svg>
                                    <span>{{ __('home.tip_queue') }}</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-brand-gold-500 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 16l3-3 3 3 3-3 3 3 3-3"/><path d="M4 20h16"/></svg>
                                    <span>{{ __('home.tip_weather') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Contact -->
                <section id="contact" class="max-w-7xl mx-auto px-4 pb-20">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-white ring-1 ring-warm-200 rounded-md p-5 shadow-sm">
                            <h3 class="font-display text-xl text-warm-900">{{ __('home.contact_title') }}</h3>
                            <p class="mt-2 text-sm text-warm-700">{{ __('home.contact_desc') }}</p>
                            <div class="mt-4 space-y-2 text-sm">
                                <a class="inline-flex items-center gap-2 text-brand-primary-700 hover:underline" href="https://wa.me/6281234567890?text=Halo%20E-Tiketing" target="_blank" rel="noopener">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.62-6.003C.122 5.281 5.403 0 12.057 0c3.188 0 6.167 1.24 8.413 3.488A11.82 11.82 0 0124 11.945c-.003 6.654-5.284 11.935-11.938 11.935a11.9 11.9 0 01-6.003-1.62L.057 24zM6.6 20.13c1.72.995 3.282 1.591 5.48 1.592 5.448 0 9.886-4.434 9.89-9.885.002-5.462-4.415-9.89-9.881-9.893-5.45 0-9.887 4.434-9.89 9.884a9.86 9.86 0 001.596 5.42l-.999 3.648 3.804-0.766z"/></svg>
                                    {{ __('home.contact_whatsapp') }}
                                </a>
                                <div class="flex items-center gap-2 text-warm-800">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="M22 6l-10 7L2 6"/></svg>
                                    <a href="mailto:support@lempuyang.test" class="hover:underline">support@lempuyang.test</a>
                                </div>
                                <div class="flex items-start gap-2 text-warm-800">
                                    <svg class="w-4 h-4 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 12-9 12S3 17 3 10a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <span>{{ __('home.contact_address') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white ring-1 ring-warm-200 rounded-md p-2 shadow-sm h-64 md:h-80">
                            <iframe title="Google Maps - Pura Lempuyang" class="w-full h-full rounded-md" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                    src="https://www.google.com/maps?q=Pura%20Lempuyang&output=embed"></iframe>
                        </div>
                    </div>
                </section>
                <section class="max-w-7xl mx-auto px-4 pb-20">
                    <h3 class="font-display text-2xl md:text-3xl text-center text-warm-900 mb-10">Apa Kata Mereka?</h3>
                    <div class="grid gap-8 md:grid-cols-3">
                        <div class="bg-white shadow-lg rounded-2xl p-6 ring-1 ring-warm-200">
                            <div class="flex items-center gap-4">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User" class="w-14 h-14 rounded-full object-cover shadow" />
                                <div>
                                    <p class="font-semibold text-warm-900">Ayu</p>
                                    <p class="text-sm text-warm-600">Pengunjung</p>
                                </div>
                            </div>
                            <p class="mt-4 text-warm-700 leading-relaxed">Pengalaman saya sangat luar biasa, proses pemesanan tiket cepat dan mudah. Tempatnya juga indah sekali.</p>
                        </div>

                        <div class="bg-white shadow-lg rounded-2xl p-6 ring-1 ring-warm-200">
                            <div class="flex items-center gap-4">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="w-14 h-14 rounded-full object-cover shadow" />
                                <div>
                                    <p class="font-semibold text-warm-900">Made</p>
                                    <p class="text-sm text-warm-600">Traveler</p>
                                </div>
                            </div>
                            <p class="mt-4 text-warm-700 leading-relaxed">Sangat puas dengan layanan ini, dari awal sampai akhir terasa profesional. Saya pasti akan kembali lagi.</p>
                        </div>

                        <div class="bg-white shadow-lg rounded-2xl p-6 ring-1 ring-warm-200">
                            <div class="flex items-center gap-4">
                                <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="User" class="w-14 h-14 rounded-full object-cover shadow" />
                                <div>
                                    <p class="font-semibold text-warm-900">Dewi</p>
                                    <p class="text-sm text-warm-600">Wisatawan</p>
                                </div>
                            </div>
                            <p class="mt-4 text-warm-700 leading-relaxed">Tampilan websitenya elegan, mudah digunakan, dan informatif. Sangat membantu dalam merencanakan perjalanan saya.</p>
                        </div>
                    </div>
                </section>
            </main>
        </div>
            </main>
        </div>
        <footer class="mt-10 bg-gradient-to-r from-brand-accent-600 to-brand-primary-700 text-white">
            <div class="max-w-7xl mx-auto px-4 py-8 grid sm:grid-cols-3 gap-6">
                <div>
                    <div class="font-display text-lg">{{ config('app.name', 'E-Tiketing') }}</div>
                    <p class="mt-2 text-sm text-white/90">{{ __('home.hero_subtitle') }}</p>
                </div>
                <div>
                    <div class="font-semibold">{{ __('home.packages') }}</div>
                    <ul class="mt-2 text-sm space-y-1">
                        <li><a class="hover:underline" href="{{ route('packages') }}">{{ __('home.popular_packages') }}</a></li>
                        <li><a class="hover:underline" href="#rules">{{ __('home.before_visit') }}</a></li>
                    </ul>
                </div>
                <div>
                    <div class="font-semibold">{{ __('home.contact') }}</div>
                    <ul class="mt-2 text-sm space-y-1">
                        <li><a class="hover:underline" href="https://wa.me/6281234567890" target="_blank" rel="noopener">WhatsApp</a></li>
                        <li><a class="hover:underline" href="mailto:support@lempuyang.test">Email</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </body>
</html>
